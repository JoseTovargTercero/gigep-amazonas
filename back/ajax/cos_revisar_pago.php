<?php
require_once('../config/conexion.php');


header('Content-Type: application/json');

// leer el body
$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['id'], $input['estado'], $input['observacion'])) {
    echo json_encode([
        "success" => false,
        "message" => "Datos incompletos."
    ]);
    exit;
}

$id = intval($input['id']);
$estado = $input['estado'];
$observacion = $input['observacion'];

try {
    // preparar consulta
    $stmt = $conexion->prepare("UPDATE cos_pagos 
                                SET estatus = ?, observaciones = ? 
                                WHERE id = ?");
    $stmt->bind_param("ssi", $estado, $observacion, $id);

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Pago actualizado correctamente."
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Error al actualizar el pago."
        ]);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
}

$conexion->close();
