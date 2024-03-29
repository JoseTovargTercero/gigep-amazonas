<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"]) {



  
  $t = $_POST["t"]; // TAREA/OPERACION/CHAT
  $message = $_POST["message"]; ////MENSAJE
  $p = $_POST["p"]; // PRIVACIDAD
  $ty = $_POST["ty"]; // USER_2
  $user_1 = $_SESSION["u_id"]; // USER1






  $stmt_o = $conexion->prepare("INSERT INTO system_messages (identificador, tipo, user_1, user_2, message) VALUES (?, ?, ?, ?, ?)");
  $stmt_o->bind_param("sssss", $t, $p, $user_1, $ty, $message);
  $stmt_o->execute();

  if ($stmt_o) {
   
    if ($ty == 'i') {



      /* SE REGISTRA EN LA TABLA DE MENSAJES PENDIENTES */
      $stmt_v = $conexion->prepare("INSERT INTO system_messages_vistos (operacion, user_2) VALUES (?, ?)");

      $stmt = mysqli_prepare($conexion, "SELECT DISTINCT(empresa_id) FROM `go_tareas_responsables` WHERE operacion='$t' AND status='1' AND empresa_id!='$user_1'");
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $stmt_v->bind_param("ss", $t, $row['empresa_id']);
            $stmt_v->execute();

            notificar([$row['empresa_id']], 9, $t, false, $user_1);


        }
      }
      $stmt->close();
      /* SE REGISTRA EN LA TABLA DE MENSAJES PENDIENTES */


      /* SE REGISTRA EN LA TABLA DE MENSAJES PENDIENTES AL RESP DE LA OPERACION */
      $stmt = mysqli_prepare($conexion, "SELECT empresa_id FROM `go_operaciones` WHERE id='$t'");
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          if ($row['empresa_id'] != $user_1) {
            $stmt_v->bind_param("ss", $t, $row['empresa_id']);
            $stmt_v->execute();
            notificar([$row['empresa_id']], 9, $t);
          }
        }
      }
      $stmt->close();
      $stmt_v->close();
      /* SE REGISTRA EN LA TABLA DE MENSAJES PENDIENTES AL RESP DE LA OPERACION */


    }



  }else {
    echo "error";
  }
  $stmt_o->close();



} else {
  header("Location: ../../public/index.php");
}
