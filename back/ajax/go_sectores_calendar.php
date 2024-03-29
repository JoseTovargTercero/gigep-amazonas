<?php
include('../config/conexion.php');
if ($_SESSION["u_nivel"]) {

  $i = $_GET["i"];
  if ($i === 'all') {
    $stmt = mysqli_prepare($conexion, "SELECT tarea, fecha, id_tarea FROM `go_tareas` WHERE status='0'");
  }else {
    $stmt = mysqli_prepare($conexion, "SELECT tarea, fecha, id_tarea FROM `go_tareas` WHERE id_operacion = ? AND status='0'");
    $stmt->bind_param('s', $i);
  }
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

      echo $row['tarea'].'~'.$row['fecha'].'~'.$row['id_tarea'].'*';
    }
  }
  $stmt->close();


  
}else {
  header("Location: ../../public/index.php");
}




?>