<?php
include('../config/conexion.php');
if ($_SESSION["u_nivel"] == '1') {
  require('../config/funcione_globales.php');

  $user = $_SESSION["u_ente_id"];
  
  $id = $_GET["i"];
  $accion = $_GET["accion"];




  if ($accion == 'pausar') {
    
    $stmt2 = $conexion->prepare("UPDATE `com_compras_periodicas` SET `status`='1' WHERE id=?");
    $stmt2->bind_param("s", $id);
    $stmt2->execute();
    if ($stmt2) {
      echo 'ok';
    }
    $stmt2 -> close();
    

  }elseif ($accion == 'eliminar') {

    $stmt = $conexion->prepare("DELETE FROM `com_compras_periodicas` WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    if ($stmt) {
      echo 'ok';
    }
    $stmt->close();
    user_activity(1, 'Eliminó una compra periódica');


    $stmt2 = $conexion->prepare("UPDATE `com_compras` SET `id_compra_periodica`='0' WHERE id_compra_periodica=?");
    $stmt2->bind_param("s", $id);
    $stmt2->execute();
    $stmt2 -> close();

  }






}
