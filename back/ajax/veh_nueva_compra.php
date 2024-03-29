<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"] == '1') {



  $nombre_compra = $_POST["nombre_compra"];
  $fecha_compra = $_POST["fecha"];
  $respuestos = $_POST["respuestos"];
  $user = $_SESSION["u_id"];


  $stmt_o = $conexion->prepare("INSERT INTO com_compras (nombre, tipo, fecha, status, user, veh) VALUES (?, '1', ?, '1', ?, '1')");
  $stmt_o->bind_param("sss", $nombre_compra, $fecha_compra, $user);
  $stmt_o->execute();
  
  if ($stmt_o) {
    $id_r = $conexion->insert_id;
  user_activity(2, 'Registro una nueva compra de repuestos');

  }
  
  $stmt_o->close();



  $stmt2 = $conexion->prepare("UPDATE `veh_repuestos` SET `status`='1' WHERE id=?");




  /* COMPROBAR LA CANTIDAD */
  $stmt = mysqli_prepare($conexion, "SELECT * FROM `veh_repuestos` WHERE id = ?");
  /* COMPROBAR LA CANTIDAD */

  $stmt_o = $conexion->prepare("INSERT INTO com_compras_estructura (insumo_id, cantidad_i, compra_id, user_id) VALUES (?, ?, ? , ?)");
$users = array();

  if (strpos($respuestos, ",") !== false) {
    $resps = explode(",", $respuestos);
    foreach ($resps as $item) {
      $stmt->bind_param('s', $item);
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $stmt_o->bind_param("ssss", $item, $row['cantidad'], $id_r, $row['empresa_id']);
          $stmt_o->execute();

          $stmt2->bind_param("s", $item);
          $stmt2->execute();

          if (!in_array($row['empresa_id'], $users)) {
            array_push($users, $row['empresa_id']);
          }
        }
      }
    }

    foreach ($users as $value) {
      notificar([$value], 25, $id_r);
    }
  }else {
    $stmt->bind_param('s', $respuestos);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $stmt_o->bind_param("ssss", $respuestos, $row['cantidad'], $id_r, $row['empresa_id']);
        $stmt_o->execute();

        notificar([$row['empresa_id']], 25, $id_r);
        $stmt2->bind_param("s", $respuestos);
        $stmt2->execute();
        
      }
    }
  }

  $stmt->close();
  $stmt2->close();
  $stmt_o->close();




  echo 'ok';
} else {
  header("Location: ../../public/index.php");
}
