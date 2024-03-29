<?php
include('../config/conexion.php');
if ($_SESSION["u_nivel"] == '1') {
  require('../config/funcione_globales.php');

  $id = $_GET["i"];
  $user = $_SESSION["u_ente_id"];


  $stmt = $conexion->prepare("DELETE FROM `com_compras` WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->close();

  $stmt = $conexion->prepare("DELETE FROM `com_compras_estructura` WHERE id_compra = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->close();


  user_activity(1, 'Eliminó una compra');

  echo 'ok';


}
