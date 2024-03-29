<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"]) {




  if (isset($_GET["a"])) {
    
    $r = $_GET["a"];
        
    $stmt2 = $conexion->prepare("UPDATE `go_solicitud_union` SET `status`='1' WHERE id=?");
    $stmt2->bind_param("s", $r);
    $stmt2->execute();
    $stmt2 -> close();

    user_activity(3, 'Aceptó una solicitud para unirse a una tarea');


    $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_solicitud_union` WHERE id=?");
    $stmt->bind_param('s', $r);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          notificar([$row['user_1']], 19, $r);
      }
    }
    $stmt->close();


    header("Location:".$_SERVER['HTTP_REFERER']);
    exit();
  }elseif (isset($_GET["r"])) {
    
    $r = $_GET["r"];
        
    $stmt2 = $conexion->prepare("UPDATE `go_solicitud_union` SET `status`='2' WHERE id=?");
    $stmt2->bind_param("s", $r);
    $stmt2->execute();
    $stmt2 -> close();

    user_activity(3, 'Rechazó una solicitud para unirse a una tarea');


    $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_solicitud_union` WHERE id=?");
    $stmt->bind_param('s', $r);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          notificar([$row['user_1']], 18, $r);
      }
    }
    $stmt->close();


    header("Location:".$_SERVER['HTTP_REFERER']);
    exit();
  }

  $accion = $_POST["accion"];

  if ($accion == 's') {
     // Registrar
    $tipo_solicitud = $_POST["tipo_solicitud"];
    $tarea_solicitud = $_POST["tarea_solicitud"];
    $descripcion_solicitud = $_POST["descripcion_solicitud"];
    $oper = $_POST["t"];
    $user = $_SESSION["u_ente_id"];
  
    // 0 Enviada
    // 1 Vista
    // 2 Rechazada

    $year = date('Y');
    $trimestre = trimestre();

    $stmt_o = $conexion->prepare("INSERT INTO go_solicitud_union (tipo, operacion, tarea, descripcion, user_1, ano, trimestre) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt_o->bind_param("sssssss", $tipo_solicitud, $oper, $tarea_solicitud, $descripcion_solicitud, $user, $year, $trimestre);
    $stmt_o->execute();

    if ($stmt_o) {
      $id_r = $conexion->insert_id;
    }else {
      echo "error";
    }
    $stmt_o->close();




    $stmt = mysqli_prepare($conexion, "SELECT empresa_id FROM `go_operaciones` WHERE id=?");
    $stmt->bind_param('s', $oper);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          notificar([$row['empresa_id']], 10, $oper);
      }
    }
    $stmt->close();

  }elseif ($accion == 'c') {
    $oper = $_POST["t"];
    $user = $_SESSION["u_ente_id"];
  
    $stmt = $conexion->prepare("DELETE FROM `go_solicitud_union` WHERE operacion = ? AND user_1= ?");
    $stmt->bind_param("ss", $oper, $user);
    $stmt->execute();
    $stmt->close();



    

    $stmt = mysqli_prepare($conexion, "SELECT empresa_id FROM `go_operaciones` WHERE id=?");
    $stmt->bind_param('s', $oper);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {

          $stmt = $conexion->prepare("DELETE FROM `notificaciones` WHERE guia = ? AND user_2= ?");
          $stmt->bind_param("ss", $oper, $row['empresa_id']);
          $stmt->execute();
          $stmt->close();
      
      }
    }
    $stmt->close();




  }


















} else {
  header("Location: ../../public/index.php");
}
