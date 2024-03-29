<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"]) {


  $i = $_GET["i"];
  $user = $_SESSION["u_id"];


  $stmt = $conexion->prepare("DELETE FROM `system_messages_vistos` WHERE operacion = ? AND user_2= ?");
  $stmt->bind_param("ss", $i, $user);
  $stmt->execute();
  $stmt->close();
  


} else {
  header("Location: ../../public/index.php");
}
