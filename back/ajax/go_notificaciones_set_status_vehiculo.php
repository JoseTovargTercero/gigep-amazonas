<?php
include('../config/conexion.php');
include('../config/funcione_globales.php');

if ($_SESSION["u_nivel"]) {


  $t = $_GET["t"];
  $g = $_GET["v"];


  
  $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_tareas` WHERE id_tarea = ?");
  $stmt->bind_param('s', $t);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $user_send = $row['responsable_ente_id'];
   }
  }
  $stmt->close();








  if ($_GET["s"] == '1') {
    //actualiza el estatus y notifica al usuario
    $stmt2 = $conexion->prepare("UPDATE `veh_vehiculos_tarea` SET `status`='1' WHERE vehiculo=? AND tarea=?");
    $stmt2->bind_param("ss", $g, $t);
    $stmt2->execute();
    $stmt2 -> close();

    notificar([$user_send], 28, $g, $t);


  }elseif ($_GET["s"] == '2') {
    $comentario = $_GET["c"];


    // elimina el vehciulo y envia una notificacion con el comentario


    
    $stmt = $conexion->prepare("DELETE FROM `veh_vehiculos_tarea` WHERE vehiculo=? AND tarea=?");
    $stmt->bind_param("ss", $g, $t);
    $stmt->execute();
    $stmt->close();



    notificar(['admin_users', $user_send], 29, $g, $comentario);

  }
  

}else {
  header("Location: ../../public/index.php");
}
