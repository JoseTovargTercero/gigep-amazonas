<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"]) {

  
  $tarea = $_GET["t"];

  $stmt = mysqli_prepare($conexion, "SELECT veh_vehiculos.marca, veh_vehiculos.modelo, veh_vehiculos_tarea.status FROM `veh_vehiculos_tarea`
  LEFT JOIN veh_vehiculos ON veh_vehiculos.id = veh_vehiculos_tarea.vehiculo
   WHERE tarea = ?");
  $stmt->bind_param('s', $tarea);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    echo '<ul class="p-0 m-0">';
    while ($row = $result->fetch_assoc()) {
        echo '<li class="d-flex mb-4 pb-1">

     <div class="avatar-wrapper">
        <div class="avatar me-2"><span class="avatar-initial bg-label-secondary"><i class="bx bxs-truck"></i></span></div>
      </div>

        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
          <div class="me-2">
            <small class="text-muted d-block mb-1">'.$row['marca'].'</small>
            <h6 class="mb-0">'.$row['modelo'].'</h6>
          </div>
          <div class="user-progress d-flex align-items-center gap-1">
            '.($row['status'] == '0' ? '<span class="badge bg-label-secondary">Pendiente</span>' : '<span class="badge bg-label-primary">Confirmado</span>').'
          </div>
        </div>
      </li>';

    }

    echo '</ul>';

    exit();
  }else {
    $contenido = "<p class='text-center'>";

    if ($_SESSION["u_nivel"] == '1') {
      $contenido .= "
        
      <img class='pulseOpacity' src='../../assets/img/illustrations/x2.png' alt='OK' height='150px'>
        <p class='mt-3 text-center pulseOpacity'> Las empresas involucradas en la ejecución de la tarea no cuentan con los vehículos necesarios.</p>";
    } else {
      $contenido .= "
       
      <img src='../../assets/img/illustrations/x2.png' alt='OK' height='150px'>
       <p class='mt-3 text-center'> Aun no se han configurado vehículos para la ejecución.</p>";
    }

    $contenido .= "</p>";
  }
  $stmt->close();





  $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_tareas` WHERE id_tarea = ?");
  $stmt->bind_param('s', $tarea);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $vehiculos = $row['vehiculos'];

      if ($vehiculos == 'No') {
        $contenido = "<p class='text-center'>
           <img src='../../assets/img/illustrations/ok.png' alt='OK' height='150px'>
         <p class='mt-3 text-center'> Se indico que no se necesitan vehículos para la ejecución de la tarea.</p>
          </p>";
      }



    }
  }
  $stmt->close();







  echo $contenido;



} else {
  header("Location: ../../public/index.php");
}
