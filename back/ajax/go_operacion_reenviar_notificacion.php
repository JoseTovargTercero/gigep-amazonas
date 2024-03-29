<?php
include('../config/conexion.php');
include('../config/funcione_globales.php');


if ($_SESSION["u_nivel"]) {

  $id = $_GET["i"];

  $stmt2 = $conexion->prepare("UPDATE `go_tareas_responsables` SET `status`='0', `comentario`='' WHERE id=?");
  $stmt2->bind_param("s", $id);
  $stmt2->execute();
  $stmt2 -> close();


  $date = date('Y-m-d H:i:s');

  $stmt = $conexion->prepare("UPDATE `notificaciones` SET `visto`='0', `date`='$date' WHERE guia=? AND tipo='8'");
  $stmt->bind_param("s", $id);
  $stmt->execute();
  $stmt -> close();


} else {
  header("Location: ../../public/index.php");
}
