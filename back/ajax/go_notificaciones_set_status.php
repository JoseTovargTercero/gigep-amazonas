<?php
include('../config/conexion.php');
include('../config/funcione_globales.php');

if ($_SESSION["u_nivel"]) {





  $i = $_GET["i"];
  $user_send = $_GET['u'];
  $g = $_GET["g"];


  
  $stmt = mysqli_prepare($conexion, "SELECT go_tareas.tipo_registro, go_tareas.id_tarea FROM `go_tareas_responsables`
  LEFT JOIN go_tareas ON go_tareas.id_tarea = go_tareas_responsables.tarea
   WHERE id = ?");
  $stmt->bind_param('s', $g);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $id_tarea = $row['id_tarea'];
      $tipo_registro = $row['tipo_registro'];
    }
  }
  $stmt->close();




  if ($_GET["s"] == '1') {
    $stmt2 = $conexion->prepare("UPDATE `go_tareas_responsables` SET `status`='1' WHERE id=?");
    $stmt2->bind_param("s", $g);
    $stmt2->execute();
    $stmt2 -> close();

    if ($tipo_registro == '1') {
      notificar(['admin_users'], 7, $g);
    }else {
      notificar(['admin_users', $user_send], 7, $g);
    }

    echo $id_tarea;
  }elseif ($_GET["s"] == '2') {
    $comentario = $_GET["c"];


    $stmt2 = $conexion->prepare("UPDATE `go_tareas_responsables` SET `status`='2', comentario=? WHERE id=?");
    $stmt2->bind_param("ss", $comentario, $g);
    $stmt2->execute();
    $stmt2 -> close();

    if ($tipo_registro == '1') {
      notificar(['admin_users'], 8, $g);
    }else {
      notificar(['admin_users', $user_send], 8, $g);
    }

  }
  

}else {
  header("Location: ../../public/index.php");
}
