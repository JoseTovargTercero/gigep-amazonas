<?php

function deudaComercial($identificador, $tasas_bcv)
{

    global $conexion;

    // 1. Obtener datos del cliente (tabla: cos_comercios)
    $stmt = $conexion->prepare("SELECT * FROM cos_comercios WHERE RIF = ?");
    if (!$stmt) {
        exit("Error al preparar consulta: " . $conexion->error);
    }
    $stmt->bind_param("s", $identificador);
    $stmt->execute();

    $result = $stmt->get_result();
    $datos_cliente = $result->fetch_assoc();

    if (!$datos_cliente) {
        http_response_code(404);
        echo json_encode(["error" => "Cliente no encontrado", "ok" => false], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit(0);
    }

    $stmt->close();


    $cliente = [
        'datos_cliente' => $datos_cliente,
        'ok' => true,
        'deuda' => null
    ];


    // 2. Obtener último pago registrado
    $stmt = $conexion->prepare("SELECT MAX(CONCAT(anio_pago, LPAD(mes_pago,2,'0'))) AS ultimo_pago
          FROM cos_servicios_comercios
          WHERE rif_cliente = ?");
    if (!$stmt) {
        exit("Error al preparar consultaxx: " . $conexion->error);
    }


    $stmt->bind_param("s", $identificador);
    $stmt->execute();
    $stmt->bind_result($ultimo_pago);
    $stmt->fetch();
    $stmt->close();

    // 2. Definir punto de inicio
    if ($ultimo_pago) {
        // último pago está en formato YYYYMM (ej: 202509)
        $anio_inicio = intval(substr($ultimo_pago, 0, 4));
        $mes_inicio  = intval(substr($ultimo_pago, 4, 2)) + 1; // siguiente mes
        if ($mes_inicio == 13) {
            $mes_inicio = 1;
            $anio_inicio++;
        }
    } else {
        // Si no tiene pagos, comienza desde 09/2025
        $anio_inicio = 2025;
        $mes_inicio  = 8;
    }

    // 3. Generar deuda hasta mes actual
    $anio_actual = date("Y");
    $mes_actual  = date("n");

    $detalle = [];
    $total_usd = 0;
    $total_bs  = 0;

    $anio = $anio_inicio;
    $mes  = $mes_inicio;

    while ($anio < $anio_actual || ($anio == $anio_actual && $mes <= $mes_actual)) {
        $monto_usd = 10.00;
        $monto_bs  = $monto_usd * $tasas_bcv;

        $detalle[] = [
            "anio"  => $anio,
            "mes"   => $mes,
            "monto_usd" => $monto_usd,
            "monto_bs"  => $monto_bs
        ];

        $total_usd += $monto_usd;
        $total_bs  += $monto_bs;

        // avanzar al siguiente mes
        $mes++;
        if ($mes == 13) {
            $mes = 1;
            $anio++;
        }
    }



    $cliente['deuda'] = [
        "rif_cliente" => $identificador,
        "ultimo_pago" => $ultimo_pago ?: "202509", // si no hay pago, arranca en 09/2025
        "detalle"     => $detalle,
        "total_usd"   => $total_usd,
        "total_bs"    => $total_bs,
        "tasa_bcv"    => $tasas_bcv
    ];


    return $cliente;
}
