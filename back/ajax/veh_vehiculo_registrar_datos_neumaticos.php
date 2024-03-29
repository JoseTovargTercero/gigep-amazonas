<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"]) {

$vehiculo = $_POST["vehiculo"];
$neumaticos = $_POST["neumaticos"];
$neumaticos = explode('*', $neumaticos);

$stmt_o = $conexion->prepare("INSERT INTO veh_vida_neumaticos (vehiculo, etiqueta, porcentaje) VALUES (?, ?, ?)");
foreach ($neumaticos as $item) {
  $datos = explode('~', $item);
  $stmt_o->bind_param("sss", $vehiculo, $datos[1], $datos[0]);
  $stmt_o->execute();
}

$stmt_o->close();

} else {
  header("Location: ../../public/index.php");
}

?>