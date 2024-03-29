<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"] == '1' || $_SESSION["u_nivel"] == '2' || $_SESSION["u_nivel"] == '4') {
if ($_SESSION["sa"] == '1') {



  $user_id = $_SESSION["u_id"];

  
  if ($_SESSION["u_nivel"] == '2') {
    $empresa_id = $_SESSION["u_ente_id"];
    $stmt2 = mysqli_prepare($conexion, "SELECT * FROM `system_users` WHERE u_id!='$user_id' AND u_ente_id='$empresa_id' ORDER BY u_ente_id, u_nivel ASC");
  } elseif ($_SESSION["u_nivel"] != '') {
    $stmt2 = mysqli_prepare($conexion, "SELECT * FROM `system_users` WHERE u_id!='$user_id' AND u_nivel='1' AND sa!='1' ORDER BY u_ente_id, u_nivel ASC");
  }




  $stmt = mysqli_prepare($conexion, "SELECT * FROM `user_permisos` WHERE user = ?");

  $stmt2->execute();
  $result2 = $stmt2->get_result();
  if ($result2->num_rows > 0) {
    while ($row2 = $result2->fetch_assoc()) {
      $uid = $row2['u_id'];
      $nombre = $row2['u_nombre'];
      echo ' <tr class="odd">
    <td class="sorting_1">
      <div class="d-flex justify-content-start align-items-center user-name">
        <div class="avatar-wrapper">
          <div class="avatar avatar-sm me-3"><img src="../../assets/img/avatars/' . $row2['u_id'] . '.png" alt="Avatar" class="rounded-circle"  onerror="this.onerror=null; this.src=\'../../assets/img/avatars/default.jpg\'"></div>
        </div>
        <div class="d-flex flex-column"><a href="app-user-view-account.html" class="text-body text-truncate"><span class="fw-medium">' . $row2['u_nombre'] . '</span></a><small class="text-muted">' . $row2['u_ente'] . '</small></div>
      </div>
       </td>
    <td>';
    $stmt->bind_param('s', $uid);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        switch ($row['modulo']) {
          case ('go'):
            echo '<span class="badge bg-label-primary">Gestión operativa</span>';
            break;
          case ('com'):
            echo '<span class="badge bg-label-success">Compras</span>';
            break;
          case ('veh'):
            echo '<span class="badge bg-label-warning">Vehículos</span>';
            break;
        }

      }
    }

    echo '</td>

    <td>'.fechaCastellano($row2['creado']).explode(' ', $row2['creado'])[1].'
    </td>
    <td class="text-center">
    <div class="text-nowrap">
    <button class="btn btn-sm btn-icon me-2" onclick="modalAddPermisos(\''.$uid.'\', \''.$nombre.'\')" ><i class="bx bx-edit"></i></button>
    <button class="btn btn-sm btn-icon" onclick="modalRemovePermisos(\''.$uid.'\', \''.$nombre.'\')" ><i class="bx bx-trash"></i></button>
    
    </div>
    </td>
  </tr>';
    }
  }
  $stmt->close();
  $stmt2->close();


}


}
