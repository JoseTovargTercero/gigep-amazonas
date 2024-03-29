<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"]) {

  $v = $_GET["v"];
  $id = $_GET["i"];

  $date = date('Y-m-d H:i:s');

  if ($v == '1') {
    $c = $_GET["c"];
    $stmt2 = $conexion->prepare("UPDATE `veh_reporte_fallas` SET `status`='1', `solucion`='$date', `costo_reparacion`='$c' WHERE id_r=?");
    $stmt2->bind_param("s", $id);
    $stmt2->execute();
    $stmt2 -> close();

    user_activity(3, 'Actualizo el estatus de una falla');


    $stmt2 = $conexion->prepare("UPDATE `veh_repuestos` SET `status`='1' WHERE falla_id=?");
    $stmt2->bind_param("s", $id);
    $stmt2->execute();
    $stmt2 -> close();


    $stmt = mysqli_prepare($conexion, "SELECT * FROM `veh_reporte_fallas` WHERE id_r = ?");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $v = $row['vehiculo'];
        notificar(['admin_users'], 22, $v);
      }
    }
  }elseif ($v == '2') {

    echo ' 
    <div class="row justify-content-between mt-3">
        <h4 class="text-nowrap mb-0">Vehículo Inoperativo</h4>
        <small class="text-muted">Insumos necesarios para su reactivación</small>
      </div>  <div class="list-group mt-3" id="listInsumos">
  ';


    $stmt = mysqli_prepare($conexion, "SELECT veh_partes.insumo, veh_repuestos.cantidad FROM `veh_repuestos` 
    LEFT JOIN veh_partes ON veh_partes.id_i=veh_repuestos.repuesto
    WHERE falla_id = ?");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo '<div class="list-group-item list-group-item-action d-flex justify-content-between">
        <div class="li-wrapper d-flex justify-content-start align-items-center">
        <span class="badge badge-center bg-label-secondary me-2">' . $row['cantidad'] . '</span>  
          <div class="list-content">
            <h6 class="mb-1">' . ($row['insumo'] == '' ? 'Mano de obra' : $row['insumo']) . '</h6>
          </div>
        </div>
      </div>';
      }
    }
    $stmt->close();

  }elseif ($v == '3') {


    $stmt = $conexion->prepare("DELETE FROM `veh_vehiculos` WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->close();
    
    user_activity(1, 'Eliminó un vehículo');


    $stmt2 = $conexion->prepare("DELETE FROM `veh_repuestos` WHERE falla_id = ?");

    $stmt = mysqli_prepare($conexion, "SELECT * FROM `veh_reporte_fallas` WHERE vehiculo = ?");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $id_r = $row['id_r'];
        $stmt2->bind_param("s", $id_r);
        $stmt2->execute();
      }
    }
    $stmt->close();
    $stmt2->close();





    $stmt = $conexion->prepare("DELETE FROM `veh_reporte_fallas` WHERE vehiculo = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->close();


  }

} else {
  header("Location: ../../public/index.php");
}
