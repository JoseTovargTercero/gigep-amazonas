<?php
include('../config/conexion.php');
if ($_SESSION["u_nivel"] == '1') {
  require('../config/funcione_globales.php');

  $user = $_SESSION["u_ente_id"];
  
  $id = $_GET["i"];

  $stmt2 = $conexion->prepare("UPDATE `com_compras` SET `status`='1' WHERE id=?");
  $stmt2->bind_param("s", $id);
  $stmt2->execute();
  if ($stmt2) {
    echo 'ok';
  }
  $stmt2 -> close();


  
  
$stmt = mysqli_prepare($conexion, "SELECT com_compras.id_compra_periodica, com_compras.nombre, com_compras.tipo, com_compras_periodicas.fecha, com_compras_periodicas.id AS id_compra FROM `com_compras`
LEFT JOIN com_compras_periodicas ON com_compras_periodicas.id = com_compras.id_compra_periodica 
 WHERE com_compras.id = ?");
$stmt->bind_param('s', $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $id_compra_periodica = $row['id_compra_periodica'];
    $nombre = $row['nombre'];
    $tipo = $row['tipo'];
    $fecha = $row['fecha'];
    $id_compra = $row['id_compra'];
    if ($id_compra_periodica !=0) {




      // SE PROCEDE A REPROGRAMAR LA COMPRA
      $stmt_o = $conexion->prepare("INSERT INTO com_compras (nombre, tipo, fecha, id_compra_periodica) VALUES (?, ?, ?, ?)");
      $stmt_o->bind_param("ssss", $nombre, $tipo, $fecha, $id_compra_periodica);
      $stmt_o->execute();
      $id_c = $conexion->insert_id;
      $stmt_o->close(); 


      if ($tipo == '1') {
        $nfecha = addDaysToDate($fecha, 15);
      }else {
        $nfecha = addDaysToDate($fecha, 30);
      }


      $stmt2 = $conexion->prepare("UPDATE `com_compras_periodicas` SET `fecha`='$nfecha' WHERE id=?");
      $stmt2->bind_param("s", $id_compra);
      $stmt2->execute();
      $stmt2 -> close();
      // SE PROCEDE A REPROGRAMAR LA COMPRA
      user_activity(3, 'Actualizó el estado de una compra');


      notificar(['global_users'], 21, $id_c);
      
    // SE PROCEDE A INSERTAR LOS PRODUCTOS
    $stmt_a = $conexion->prepare("INSERT INTO com_compras_estructura (insumo_id, cantidad_i, compra_id, user_id) VALUES (?, ?, ?, ?)");

    $stmt3 = mysqli_prepare($conexion, "SELECT * FROM `com_compras_periodicas_configuradas` WHERE compra_p_id = ?");
    $stmt3->bind_param('s', $id_compra_periodica);
    $stmt3->execute();
    $result = $stmt3->get_result();
    if ($result->num_rows > 0) {
      while ($row2 = $result->fetch_assoc()) {
        $insumo_id = $row2['insumo_id'];
        $cantidad_i = $row2['cantidad_i'];
        $compra_p_id = $row2['compra_p_id'];
        $user_id = $row2['user_id'];
        
        $stmt_a->bind_param("ssss", $insumo_id, $cantidad_i, $id_c, $user_id);
        $stmt_a->execute();

      }
    }
    $stmt3->close();
    // SE PROCEDE A INSERTAR LOS PRODUCTOS
    $stmt_a->close();




    }
  }
}
$stmt->close();












}
