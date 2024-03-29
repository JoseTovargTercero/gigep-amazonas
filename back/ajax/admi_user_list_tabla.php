<?php
include('../config/conexion.php');
if ($_SESSION["u_nivel"] == '1' || $_SESSION["u_nivel"] == '2' || $_SESSION["u_nivel"] == '4') {


  if ($_SESSION["u_nivel"] == '2') {
    $empresa_id = $_SESSION["u_ente_id"];
    $extraCondition = " AND u_ente_id='$empresa_id'";
  } elseif ($_SESSION["u_nivel"] != '') {
    $extraCondition = " AND u_nivel!='1'";
  }


  $user_id = $_SESSION["u_id"];

  $stmt2 = mysqli_prepare($conexion, "SELECT * FROM `system_users` WHERE u_id!='$user_id' $extraCondition ORDER BY u_ente_id, u_nivel ASC");
  $stmt2->execute();
  $result2 = $stmt2->get_result();
  if ($result2->num_rows > 0) {
    while ($row2 = $result2->fetch_assoc()) {
      $uid = $row2['u_id'];
      echo ' <tr class="odd">
    <td class="sorting_1">
      <div class="d-flex justify-content-start align-items-center user-name">
        <div class="avatar-wrapper">
          <div class="avatar avatar-sm me-3"><img src="../../assets/img/avatars/' . $row2['u_id'] . '.png" alt="Avatar" class="rounded-circle"  onerror="this.onerror=null; this.src=\'../../assets/img/avatars/default.jpg\'"></div>
        </div>
        <div class="d-flex flex-column"><a href="app-user-view-account.html" class="text-body text-truncate"><span class="fw-medium">' . $row2['u_nombre'] . '</span></a><small class="text-muted">' . $row2['u_ente'] . '</small></div>
      </div>
    </td>
    <td>' . $row2['u_email'] . '</td>
    <td>';

      switch ($row2['u_nivel']) {
        case '1':
          echo 'ADMIN EPA';
          break;
        case '2':
          echo 'EMPRESA';
          break;
        case '3':
          echo 'EMPLEADO';
          break;
      }

      echo '
    </td>


    <td>';
      switch ($row2['u_status']) {
        case '0':
          echo '<span class="badge bg-label-warning">Pendiente</span>';
          break;
        case '3':
          echo '<span class="badge bg-label-danger">Bloqueado</span>';
          break;
        case '1':
          echo '<span class="badge bg-label-info">Normal</span>';
          break;
      }
      echo '
    </td>
    <td class="text-center">
      <div class="d-inline-block text-nowrap">
      <button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded me-2"></i></button>
        <div class="dropdown-menu dropdown-menu-end m-0">
        <a onclick="manejador(\'d\', \''.$uid.'\')" class="pointer dropdown-item"><i class="bx bx-trash"></i> Eliminar</a>';
            if ($row2['u_status'] == '3') {
              echo '<a onclick="manejador(\'ub\', \''.$uid.'\')" class="pointer dropdown-item"><i class="bx bx-user-check"></i> Dar acceso</a>';
            }elseif($row2['u_status'] == '1'){
              echo '<a onclick="manejador(\'b\', \''.$uid.'\')" class="pointer dropdown-item"><i class="bx bx-user-x"></i> Suspender</a>';
            }
        echo '</div>
      </div>
    </td>
  </tr>';
    }
  }




}
?>