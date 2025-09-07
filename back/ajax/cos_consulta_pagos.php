<?php
require_once('../config/conexion.php');
include('../config/funcione_globales.php');


header('Content-Type: application/json');
//WHERE estatus = 'Pendiente'


$input = json_decode(file_get_contents("php://input"), true);
$filtro = $input['filtro'] ?? '';



switch ($filtro) {
    case 'pendientes_general':
        $where_filtro = "WHERE cos_pagos.estatus = 'Pendiente' ";
        break;
    case 'pendientes_por_usuario':
        $where_filtro = "WHERE cos_pagos.estatus = 'Pendiente' AND cos_pagos.id_usuario = ? ";
        break;
    default:
        $where_filtro = "WHERE 1 ";
        break;
}


$datos = array();
$stmt = mysqli_prepare($conexion, "SELECT * FROM `cos_pagos`
LEFT JOIN cos_comercios ON cos_pagos.id_cliente = cos_comercios.id
 $where_filtro");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $datos[] = $row;
    }
}
$stmt->close();

echo json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
