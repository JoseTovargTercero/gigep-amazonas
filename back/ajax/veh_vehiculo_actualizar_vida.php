<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"]) {

$id = $_POST["id"];
$vida = $_POST["vida"];
$etiqueta = $_POST["etiqueta"];
$vehiculo = $_POST["vehiculo"];


$stmt2 = $conexion->prepare("UPDATE `veh_vida_neumaticos` SET `etiqueta`=?, `porcentaje`=?  WHERE id=?");
$stmt2->bind_param("sss", $etiqueta, $vida, $id);
$stmt2->execute();
if ($stmt2) {
  echo 'ok';
}
$stmt2 -> close();

$date = date('Y-m-d H:s:i');
$stmt2 = $conexion->prepare("UPDATE `veh_vehiculos` SET `ultimaActualizacionCauchos`='$date'  WHERE id=?");
$stmt2->bind_param("s", $vehiculo);
$stmt2->execute();
$stmt2 -> close();



} else {
  header("Location: ../../public/index.php");
}

?>