<?php
require_once('../config/conexion.php');
include('../config/funcione_globales.php');


header('Content-Type: application/json');
//WHERE estatus = 'Pendiente'
$datos = array();
$stmt = mysqli_prepare($conexion, "SELECT * FROM `cos_pagos`
LEFT JOIN cos_comercios ON cos_pagos.id_cliente = cos_comercios.id
 WHERE cos_pagos.estatus = 'Pendiente' ORDER BY cos_pagos.id DESC");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $datos[] = $row;
    }
}
$stmt->close();

echo json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
