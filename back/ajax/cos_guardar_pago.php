<?php
require_once('../config/conexion.php');
require_once 'cos_deuda_comercial.php';
require_once '../config/tasas_cambio.php';


header('Content-Type: application/json; charset=utf-8');

// Respuesta por defecto
$response = ["success" => false, "message" => "Error desconocido"];

// Verificar si se recibieron los campos obligatorios
if (empty($_POST['tipo_pago']) || empty($_POST['fechaHora'])) {
    $response['message'] = "Faltan campos obligatorios";
    echo json_encode($response);
    exit;
}

// Sanitizar datos
$id_cliente  = $_POST['id'];
$tipo_pago   = $_POST['tipo_pago'];
$fechaHora   = $_POST['fechaHora'];
$observacion = $_POST['observacion'] ?? '';
$banco_emisor = $_POST['banco_emisor'] ?? '';
$codigo      = $_POST['codigo'] ?? '';


// verificar si existe la el cliente
$stmt = $conexion->prepare("SELECT RIF AS rif_cliente FROM cos_comercios WHERE ID = ?");
$stmt->bind_param("s", $id_cliente);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    $response['message'] = "Cliente no encontrado";
    echo json_encode($response);
    exit;
}
$row = $result->fetch_assoc();
$rif_cliente = $row['rif_cliente'];
$stmt->close();



$mes_pago = date('m', strtotime($fechaHora));
$anio_pago  = date('Y', strtotime($fechaHora));
$fecha_pago = date('Y-m-d H:i:s', strtotime($fechaHora));



$deuda_comercial = deudaComercial($rif_cliente, $tasas_bcv);

// verifica que total_usd no sea 0

if (!$deuda_comercial['ok'] || $deuda_comercial['deuda']['total_usd'] <= 0) {
    $response['message'] = "No hay deuda pendiente para este cliente para este cliente";
    echo json_encode($response);
    exit;
}
$monto_usd = $deuda_comercial['deuda']['total_usd'];
$monto_bs  = $deuda_comercial['deuda']['total_bs'];
$detalles_deuda = $deuda_comercial['deuda']['detalle'];


// Si el tipo de pago requiere comprobante y código
if (($tipo_pago === "transferencia" || $tipo_pago === "pago_movil") && (empty($codigo) || empty($_FILES['comprobante']['name']))) {
    $response['message'] = "Debe enviar comprobante y código de referencia";
    echo json_encode($response);
    exit;
}

try {
    // Iniciar transacción
    $conexion->begin_transaction();


    // REGISTRAR EL PAGO
    $stmt = $conexion->prepare("
    INSERT INTO cos_pagos 
    (id_cliente, rif_cliente, mes_pago, anio_pago, fecha_pago, monto_usd, monto_bs, tasa_cambio, metodo_pago, referencia_pago, observaciones) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

    $stmt->bind_param(
        "ssissddssss",  // 11 tipos → 2 string, 1 string, 1 int, 1 string, 2 double, 1 double, 3 string
        $id_cliente,
        $rif_cliente,
        $mes_pago,
        $anio_pago,
        $fecha_pago,
        $monto_usd,
        $monto_bs,
        $tasas_bcv,
        $tipo_pago,
        $codigo,
        $observacion
    );

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Pago registrado correctamente";
    } else {
        throw new Exception("Error al guardar en BD: " . $stmt->error);
    }
    // recupera el id del registro
    $id_pago = $stmt->insert_id;

    $stmt->close();



    // registra los meses pagados con el id del pago
    $stmt = $conexion->prepare("INSERT INTO cos_servicios_comercios (
        rif_cliente, 
        monto_usd, 
        monto_bs, 
        tipo_servicio, 
        id_pago,
        anio_pago,
        mes_pago
    ) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Error al preparar consulta: " . $conexion->error);
    }
    $servicio = 'Comercial';

    foreach ($detalles_deuda as $mes) {
        $stmt->bind_param(
            "sssssss",
            $rif_cliente,
            $mes['monto_usd'],
            $mes['monto_bs'],
            $servicio,
            $id_pago,
            $mes['anio'],
            $mes['mes']
        );
        if (!$stmt->execute()) {
            throw new Exception("Error al guardar detalle de deuda: " . $stmt->error);
        }
    }
    $stmt->close();



    // Guardar comprobante
    if (isset($_FILES['comprobante']) && $_FILES['comprobante']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . "/uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $extension = strtolower(pathinfo($_FILES['comprobante']['name'], PATHINFO_EXTENSION));
        $permitidos = ['jpg', 'jpeg', 'png'];
        if (!in_array($extension, $permitidos)) {
            throw new Exception("Extensión de archivo no permitida");
        }

        $nombreLimpio = "comp_{$id_pago}_" . uniqid() . "." . $extension;
        $destino = $uploadDir . $nombreLimpio;

        if (!move_uploaded_file($_FILES['comprobante']['tmp_name'], $destino)) {
            throw new Exception("Error al guardar el comprobante");
        }
    }


    // Confirmar cambios
    $conexion->commit();
    $response['success'] = true;
    $response['message'] = "Pago registrado correctamente";
} catch (Exception $e) {
    $conexion->rollback();
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
