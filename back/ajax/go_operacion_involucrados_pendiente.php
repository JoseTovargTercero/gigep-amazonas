<?php
include('../config/conexion.php');
include('../config/funcione_globales.php');


if ($_SESSION["u_nivel"]) {

  $stmt2 = mysqli_prepare($conexion, "SELECT notificaciones.visto, go_tareas_responsables.comentario, go_tareas.tarea AS nombreTarea, go_tareas.status AS statusTarea, system_users.u_nombre, system_users.u_id, system_users.u_ente, go_tareas_responsables.id, go_tareas_responsables.empresa_id, go_tareas_responsables.empresa, go_tareas_responsables.status, go_tareas_responsables.responsabilidad, go_tareas_responsables.fechaAsig FROM `go_tareas_responsables`
                      LEFT JOIN system_users ON system_users.u_id = go_tareas_responsables.empresa_id
                      LEFT JOIN go_tareas ON go_tareas.id_tarea = go_tareas_responsables.tarea
                      LEFT JOIN notificaciones ON notificaciones.guia = go_tareas_responsables.id AND notificaciones.tipo ='14' AND notificaciones.user_2=system_users.u_id
                       WHERE go_tareas_responsables.operacion= ?  AND go_tareas_responsables.status!='1' ORDER BY go_tareas_responsables.empresa_id");
$stmt2->bind_param('s', $_GET["i"]);

$stmt2->execute();
$result2 = $stmt2->get_result();
if ($result2->num_rows > 0) {
  while ($row2 = $result2->fetch_assoc()) {
    $id = $row2['id']; 
    if ($row2['id'] ==  $_GET["v"]) {
      $pulseClass = 'pulseOpacity';
    }else{
      $pulseClass = '';
    }
    echo '<tr class="odd '.$pulseClass.'">
    <td>';
    if ($row2['visto'] == 0) {
      echo '<span class="text-secondary" title="Entregado"><i class="bx bx-check-double"></i></span>';
    }else {
      echo '<span class="text-primary" title="Visto"><i class="bx bx-check-double"></i></span>';
    }


    echo'</td>
    <td><div class="d-flex justify-content-start align-items-center user-name">';
        if (file_exists('../../assets/img/avatars/' . $row2['u_id'] . '.png')) {
          echo ' 
          <div class="avatar-wrapper"><div class="avatar me-2"><img src="../../assets/img/avatars/' . $row2['u_id'] . '.png" alt="Avatar" class="rounded-circle"></div></div>';
        } else {
          echo '   <div class="avatar-wrapper"><div class="avatar me-2"><span class="avatar-initial rounded-circle bg-label-info">' . substr($row2['u_ente'], 0, 1) . '</span></div></div>';
        }

        echo '
        <div class="d-flex flex-column"><span class="emp_name text-truncate">' . $row2['empresa'] . '</span><small class="emp_post text-truncate text-muted">' . $row2['nombreTarea'] . '</small></div>
    
        </div>    </div>
    </td>
    <td>'.$row2['responsabilidad'].'</td>


    <td class="text-center">'; 
    
    if ( $row2['status'] == 0) {
      echo '<span class="badge  bg-label-info" title="Pendiente">Pendiente</span>';
    }else {
      echo '<span class="badge  bg-label-danger" title="Rechazado">Rechazado</span>';
    }
    
    echo'</td>
    <td><i title="'.($row2['comentario'] == '' ? 'Pendiente':$row2['comentario']).'" class="bx '.($row2['comentario'] == '' ? 'bx-question-mark':'bx-info-circle').'"></i></td>
    <td>';


    if ($row2['statusTarea'] != 2) {
      if ($row2['status'] == 2 && $_SESSION["u_ente_id"] == $row2['empresa_id']) {
          echo '<button onclick="reenviar(\''.$id.'\')" class="btn btn-primary">Reenviar</button>';
        }
      }
    echo '
    </td>
  </tr>';

  }
}


} else {
  header("Location: ../../public/index.php");
}
