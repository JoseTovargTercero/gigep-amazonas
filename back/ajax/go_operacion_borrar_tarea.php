<?php
include('../config/conexion.php');
include('../config/funcione_globales.php');



if ($_SESSION["u_nivel"] && isset($_GET["i"])) {



  $id = $_GET["i"];



  $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_tareas`  WHERE id_tarea = ?");
  $stmt->bind_param('s', $id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $tipo_registro = $row['tipo_registro'];
      $responsable_ente_id = $row['responsable_ente_id'];
      $tarea = $row['tarea'];
      $userCreate = $row['usarios_id'];
    }
  }
  $stmt->execute();
  $stmt->close();

  if ($responsable_ente_id != $_SESSION["u_ente_id"] && $_SESSION["u_id"] != $userCreate) {
    echo "NP";
    exit();
  }

  if ($tipo_registro == '1' && $_SESSION["u_nivel"] == '2' || $tipo_registro == '1' && $_SESSION["u_nivel"] == '3') {
    // enviar notificacion a la EPA
    notificar(['admin_users'], 15, $id, $tarea);
  }


  $stmt1 = $conexion->prepare("DELETE FROM `go_tareas` WHERE id_tarea = ?");
  $stmt1->bind_param("s", $id);
  $stmt1->execute();
  $stmt1->close();

  user_activity(1, 'Eliminó una tarea');

  
 if ($stmt) {
    echo 'ok';

    $stmt0 = $conexion->prepare("DELETE FROM `go_tareas_condiciones` WHERE tarea = ?");
    $stmt0->bind_param("s", $id);
    $stmt0->execute();
    $stmt0->close();
    $stmt3 = $conexion->prepare("DELETE FROM `go_tareas_recursos` WHERE tarea = ?");
    $stmt3->bind_param("s", $id);
    $stmt3->execute();
    $stmt3->close();

    $stmt5 = $conexion->prepare("DELETE FROM `notificaciones` WHERE guia = ? AND tipo='2'");
    $stmt5->bind_param("s", $id);
    $stmt5->execute();
    $stmt5->close();

    
    
    $stmt2 = $conexion->prepare("DELETE FROM `notificaciones` WHERE guia = ? AND tipo='14'");

  $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_tareas_responsables`  WHERE tarea = ?");
  $stmt->bind_param('s', $id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $id_r = $row['id'];
      $stmt2->bind_param("s", $id_r);
      $stmt2->execute();
      //TODO: BORRAR TIPO 14 CON ID RESPONSABLE
    }
  }

  $stmt2->close();

  $stmt->close();


  $stmt4 = $conexion->prepare("DELETE FROM `go_tareas_responsables` WHERE tarea = ?");
  $stmt4->bind_param("s", $id);
  $stmt4->execute();
  $stmt4->close();
  



    // eliminar recursos
    // eliminar responsables
    // eliminar condiciones
    // eliminar notificaciones de asignacion
    // eliminar FOTOS
    $salir = '';
    $c = 1;
    while ( $salir != 's') {
      if (file_exists('../../assets/img/tareas/'.$id.'_'.$c. '.png')) {
        unlink('../../assets/img/tareas/'.$id.'_'.$c. '.png');
        $c++;
      }else {
        $salir = 's';
      }
    }

  }





}else {
  header("Location: ../../public/index.php");
}
?>