<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"] == '1') {


    
    $nombre = $_POST["nombre"];
    $tipoCompra = $_POST["tipoCompra"];
    $fecha = $_POST["fecha"];
    $user = $_SESSION["u_id"];





    if ($tipoCompra == '1') {

      $stmt_o = $conexion->prepare("INSERT INTO com_compras (nombre, tipo, fecha, user) VALUES (?, ?, ?, ?)");
      $stmt_o->bind_param("ssss", $nombre, $tipoCompra, $fecha, $user);
      $stmt_o->execute();
      
      if ($stmt_o) {
        $id_r = $conexion->insert_id;
      }

      user_activity(2, 'Creó una nueva compra');
      
      
    }else {
      
      
      
      if ($tipoCompra == '1') {
        $nfecha = addDaysToDate($fecha, 15);
      }else {
        $nfecha = addDaysToDate($fecha, 30);
      }
      
      
      
      $stmt_o = $conexion->prepare("INSERT INTO com_compras_periodicas (nombre, tipo, fecha) VALUES (?, ?, ?)");
      $stmt_o->bind_param("sss", $nombre, $tipoCompra, $nfecha);
      $stmt_o->execute();
      
      
      if ($stmt_o) {
        $id_r = $conexion->insert_id;

        user_activity(2, 'Creó una nueva compra');
        $stmt_k = $conexion->prepare("INSERT INTO com_compras (nombre, tipo, fecha, user, id_compra_periodica) VALUES (?, ?, ?, ?, ?)");
        $stmt_k->bind_param("sssss", $nombre, $tipoCompra, $fecha, $user, $id_r);
        $stmt_k->execute();
      }
    

    }


    notificar(['global_users'], 20, $id_r);





} else {
  header("Location: ../../public/index.php");
}
