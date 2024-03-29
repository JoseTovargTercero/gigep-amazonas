<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"]) {




  $stmta = mysqli_prepare($conexion, "SELECT * FROM `veh_reporte_fallas` WHERE vehiculo = ? AND status='0'");



if ($_SESSION["u_nivel"] == '1') {
  $stmt = mysqli_prepare($conexion, "SELECT * FROM `veh_vehiculos`
  LEFT JOIN system_users ON system_users.u_id=veh_vehiculos.empresa_id
  ");
}else {
 $empresa_id = $_SESSION["u_ente_id"];
 $stmt = mysqli_prepare($conexion, "SELECT * FROM `veh_vehiculos` WHERE empresa_id = ?");
 $stmt->bind_param('s', $empresa_id);
}
  
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
  echo '  <tr>

    <td class="sorting_1">
    <div class="d-flex justify-content-start align-items-center user-name">
      <div class="avatar-wrapper">
        <div class="avatar me-2"><span class="avatar-initial rounded-circle bg-label-secondary"><i class="bx bxs-truck"></i></span></div>
      </div>
      <div class="d-flex flex-column"><span class="fw-medium mb-0">'.$row['modelo'].'</span><small class=""text-muted>'.$row['marca'].'</small></div>
    </div>
  </td>

  <td class="sorting_1">
  <div class="d-flex flex-column"><a class="text-body ""><span class="fw-medium">'.$row['tipo_vehiculo'].'</span>
</td>


  <td>
   '.$row['placa'].'
  </td>

  <td>';
  $stmta->bind_param('s', $id);
  $stmta->execute();
  $resulta = $stmta->get_result();
  if ($resulta->num_rows > 0) {
    $in = 0;
    while ($row3 = $resulta->fetch_assoc()) {
      if ($row3['gravedad'] == '2' || $in == 1) {
        $in = 1;
      }else {
        $in = 2;
      }
    }

    if ($in == 1) {
      echo '<span class="badge rounded bg-label-danger">Inoperativo</span>';
    }else {
      echo '<span class="badge rounded bg-label-warning">Fallando</span>';
    }


  }else {
    echo '<span class="badge rounded bg-label-success">Operativo</span>';
  }

  echo '</td>
  <td class="text-center">'.($row['cauchos'] == '0' ? '<span class="text-danger">80%</span>' : '<span class="text-success">100%</span>').'</td>
  <td>
    <div class="dropdown">
      <button class="btn p-0" type="button" id="deliveryPerformance" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="bx bx-dots-vertical-rounded"></i>
      </button>
      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="deliveryPerformance">
      <a href="veh_vehiculo?i='.$row['id'].'" class="dropdown-item pointer" ><i class="bx bx-detail me-2"></i>Detalles</a>';

      if ($row['empresa_id'] == $_SESSION["u_ente_id"]) {
        echo '<a class="dropdown-item pointer" onclick="re_falla(\''.$id.'\')"><i class="bx bx-wrench me-2"></i>Reportar falla</a><hr>';
        echo '<a class="dropdown-item pointer" onclick="eliminar(\''.$id.'\')"><i class="bx bx-trash me-2"></i>Eliminar</a>';
      }

      echo '</div>
    </div>
  </td>
</tr>
';
  }
}
$stmt->close();
$stmta->close();




} else {
  header("Location: ../../public/index.php");
}
