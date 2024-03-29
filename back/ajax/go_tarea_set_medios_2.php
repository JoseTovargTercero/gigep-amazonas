<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"]) {




  $vehiculo = $_GET["m"];
  $tarea = $_GET["t"];





  $stmt = mysqli_prepare($conexion, "SELECT * FROM `veh_vehiculos_tarea` WHERE tarea = ? AND vehiculo=?");
  $stmt->bind_param('ss', $tarea, $vehiculo);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $accion = 'd';
  }else{
    $accion = 'a';
  }
  $stmt->close();



  $stmt = mysqli_prepare($conexion, "SELECT * FROM `veh_vehiculos` WHERE id = ?");
  $stmt->bind_param('s', $vehiculo);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

      $empresa_id = $row['empresa_id'];
  }
  }
  $stmt->close();





  if ($accion == 'd') {
    // BORRA EL VEHICULO Y LA NOTIFICACION


    $stmt = $conexion->prepare("DELETE FROM `veh_vehiculos_tarea` WHERE vehiculo = ? AND tarea = ?");
    $stmt->bind_param("ss", $vehiculo, $tarea);
    $stmt->execute();
    $stmt->close();

    $stmt = $conexion->prepare("DELETE FROM `notificaciones` WHERE guia = ? AND tipo = '27' AND comentario = ?");
    $stmt->bind_param("ss", $vehiculo, $tarea);
    $stmt->execute();
    $stmt->close();

  } elseif($accion == 'a') {

    //agrega el vehiculo y la notificacion




    $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_tareas` WHERE id_tarea = ?");
    $stmt->bind_param('s', $tarea);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $fecha = $row['fecha'];
      }
    }
    $stmt->close();

    if ($_GET["u_ente_id"] != $empresa_id) {
      notificar([$empresa_id], 27, $vehiculo, $tarea);
      $st_vehiculo = '0';
    }else {
      $st_vehiculo = '1';
    }

    $stmt_o = $conexion->prepare("INSERT INTO veh_vehiculos_tarea (vehiculo, tarea, fecha, status) VALUES (?, ?, ?, ?)");
    $stmt_o->bind_param("ssss", $vehiculo, $tarea, $fecha, $st_vehiculo);
    $stmt_o->execute();
    $stmt_o->close();



  }
} else {
  header("Location: ../../public/index.php");
}
