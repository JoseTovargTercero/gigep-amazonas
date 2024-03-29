<?php
include('../config/conexion.php');
include('../config/funcione_globales.php');


if ($_SESSION["u_nivel"]) {

  $id = $_GET["i"];


  $resposablesPrevios = array();

  $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_tareas_responsables` WHERE tarea = ?");
  $stmt->bind_param('s', $id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      array_push($resposablesPrevios,$row['empresa_id']);
    }
  }
  $stmt->close();
 // mas el administrador

 $stmt = mysqli_prepare($conexion, "SELECT responsable_ente_id FROM `go_tareas` WHERE id_tarea = ?");
 $stmt->bind_param('s', $id);
 $stmt->execute();
 $result = $stmt->get_result();
 if ($result->num_rows > 0) {
   while ($row = $result->fetch_assoc()) {
     array_push($resposablesPrevios,$row['responsable_ente_id']);
   }
 }
 $stmt->close();
// mas el administrador




  $stmt = mysqli_prepare($conexion, "SELECT * FROM `system_users` WHERE u_nivel ='2'");
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    echo '<option value="">Seleccione</option>';
    while ($row = $result->fetch_assoc()) {
      
      if (!in_array($row['u_id'], $resposablesPrevios)) {
        echo '<option value="' . $row['u_id'] . '">' . $row['u_ente'] . '</option>';
      }


    }
  }
  $stmt->close();







} else {
  header("Location: ../../public/index.php");
}
