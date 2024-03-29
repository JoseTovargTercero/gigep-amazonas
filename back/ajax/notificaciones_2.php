<?php
include('../config/conexion.php');
include('../config/funcione_globales.php');


if ($_SESSION["u_nivel"]) {
  $user_id = $_SESSION["u_id"];



  function vista($id, $u_ente, $tipo, $date, $u_id, $guia, $user_1){

    $contenido = ' <li class="pointer list-group-item list-group-item-action dropdown-notifications-item"  onclick="verNotification(\'' . $id . '\', \'' . $guia . '\', \'' . $user_1 . '\')" >
    <div class="d-flex">
      <div class="flex-shrink-0 me-3">
        <div class="avatar">';
    if (file_exists('../../assets/img/avatars/' . $u_id . '.png')) {
      $contenido .= ' <img src="../../assets/img/avatars/' . $u_id . '.png" alt="logo ' . $u_ente . '" class="rounded-circle" title="' . $u_ente . '">';
    } else {
      $contenido .= '  <span class="avatar-initial rounded-circle bg-label-danger"> ' . substr($u_ente, 0, 1) . '</span>';
    }
    $contenido .= '
        </div>
      </div>
      <div class="flex-grow-1">
        <h6 class="mb-1">' . $u_ente . '</h6>
        <p class="mb-0">' . textNotification($tipo) . '</p>
        <small class="text-muted">' . dateToTimeAgo($date) . '</small>
      </div>
  
    </div>
   </li>';

    return $contenido;
  }



  /*
  '12' => 'Actualizó el estado de un ticket',
  '13' => 'Cerro un ticket',
  '15' => 'Eliminó una tarea asignada',//Listo
  */



  $stmt = mysqli_prepare($conexion, "SELECT go_tareas_responsables.tarea AS tareaId, notificaciones.id, notificaciones.tipo, notificaciones.guia, system_users.u_id, system_users.u_ente, system_users.u_nombre, notificaciones.date, notificaciones.guia, notificaciones.user_1  FROM `notificaciones` 
  LEFT JOIN system_users ON system_users.u_id = notificaciones.user_1 
  LEFT JOIN go_tareas_responsables ON go_tareas_responsables.id = notificaciones.guia 
  WHERE user_2='$user_id' ORDER BY id DESC");
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $id = $row['id'];
      $tipo = $row['tipo'];
      $guia = $row['guia'];
      $user_1 = $row['user_1'];


      echo vista($id, $row['u_ente'], $tipo, $row['date'], $row['u_id'], $guia, $user_1);
    }
  }
  $stmt->close();


} else {
  header("Location: ../../public/index.php");
}
