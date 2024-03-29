<?php
include('../config/conexion.php');
include('../config/funcione_globales.php');


if ($_SESSION["u_nivel"]) {

  $i = $_GET["i"];
  $m = $_GET["m"];

  echo contar("SELECT count(*) FROM go_tareas WHERE id_operacion='$i' AND status='0'").'~';
  echo contar("SELECT count(*) FROM go_tareas WHERE id_operacion='$i' AND status='1'").'~';





  
  $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_operaciones` WHERE id = ?");
  $stmt->bind_param('s', $operacion_id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $cerrado = $row['cerrado'];
    }
  }





  $stmt2 = mysqli_prepare($conexion, "SELECT id, empresa_id, empresa FROM `go_tareas_responsables` WHERE tarea = ? AND status='1'");



  $last_date = '';
  $stmt = mysqli_prepare($conexion, "SELECT go_tareas.fechaFin, go_operaciones.cerrado, go_tareas.usarios_id, go_tareas.responsable_ente_id, go_tareas.creacion, go_tareas.tipo_ejecucion, go_tareas.tarea, go_tareas.status, go_tareas.id_tarea, go_tareas.fecha FROM `go_tareas` 
  LEFT JOIN go_operaciones ON go_operaciones.id = go_tareas.id_operacion
  WHERE id_operacion = ? ORDER BY tipo_ejecucion ASC, fecha ASC");
  $stmt->bind_param('s', $i);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $id = $row['id_tarea'];
      $empresa_id = $row['responsable_ente_id'];

      $cerrado = $row['cerrado'];

      if ($_SESSION["op_c"] == 1) {
        $cerrado = 1;
      }




      

      if ($row['tipo_ejecucion'] != '2') {
        if ($last_date != $row['fecha']) {
          echo '<tr style="background-color: #d1d1d14d; font-weight: 500;">
          <td COLSPAN=4>'.fechaCastellano($row['fecha']).'</td>
          </tr>';
          $last_date = $row['fecha'];
        }
      }else {

        if ($last_date != 'Trimestral') {
          echo '<tr style="background-color: #d1d1d14d; font-weight: 500;">
          <td COLSPAN=4>Todo el año</td>
          </tr>';
          $last_date = 'Trimestral';
        }
      }




      echo '<tr><td>';

      $stmt2->bind_param('s', $row['id_tarea']);
      $stmt2->execute();
      $result2 = $stmt2->get_result();
      if ($result2->num_rows > 0) {
        echo '<ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">';
        while ($row2 = $result2->fetch_assoc()) {
          echo '
          <li  data-bs-toggle="tooltip"  data-popup="tooltip-custom"  data-bs-placement="top"  class="avatar avatar-xs avatar2 pull-up"  title="'.$row2['empresa'].'">
          <img onclick="verDetallesResponsabilidad(\''.$row2['id'].'\')" onerror="this.onerror=null; this.src=\'../../assets/img/avatars/default.jpg\'"  src="../../assets/img/avatars/'.$row2['empresa_id'].'.png" alt="Avatar" class="rounded-circle" />
        </li>

        </li>';
      }
      echo '</ul>';
      }

      echo '</td>
      
      <td style="width: 70%">';

      if ($row['status'] == '0') {
       echo '<span class="badge me-3 bg-label-danger" title="Pendiente">P</span>';
      }elseif ($row['status'] == '1') {
        echo '<span class="badge me-3 bg-label-success" title="Ejecutado">E</span>';
      }else{
        echo '<span class="badge me-3 bg-label-primary" title="En proceso">EP</span>';
      }


      echo $row['tarea'].'</td>
 
      <td  style="width:10%">';


      if ($row['fechaFin'] != '') {
        if ($row['status'] == '0' && $row['fechaFin'] < date('Y-m-d')) {
          echo '<span class="badge badge-sm bg-danger"><small>NO SE COMPLETÓ</small></span>';
        }
      }
      
      
      
      echo '</td>


      <td style="width:5%">
      <div class="dropdown">
        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
          <i class="bx bx-dots-vertical-rounded"></i>
        </button>

        
        <div class="dropdown-menu">
          <a class="dropdown-item pointer" href="go_tarea.php?t='.$id.'"><i class="bx bx-detail me-1"></i> Ver detalles</a>';

          if ($cerrado == 0) {
            if ($_SESSION["u_ente_id"] == $empresa_id ) {
              if ($row['status'] == '0' || $row['status'] == '2' ) {
                echo '<a class="dropdown-item pointer" onclick="ejecutado(\''.$row['id_tarea'].'\')"><i class="bx bx-task me-1"></i> Reportar ejecución</a>';
              }
            }



            if ($_SESSION["u_ente_id"] == $row['responsable_ente_id'] || $_SESSION["u_id"] == $row['usarios_id']){

              echo '<a class="dropdown-item pointer" onclick="addResponsable(\''.$row['id_tarea'].'\')"><i class="bx bx-user-plus me-1"></i> Agregar otra empresa</a>';




              if (check_time_diff($row['creacion'], date('Y-m-d H:i:s')) ) {
                echo '<a class="dropdown-item pointer" onclick="borrarTarea(\''.$id.'\')"><i class="bx bx-edit-alt me-1"></i> Eliminar</a>';
              }
            }

        }



          echo '
        </div>
      </div>
      </td>
      </tr>';
    }
  }else {
    echo '<tr style="background-color: #d1d1d14d">
    <td COLSPAN=4 style="text-align:center; font-weight: 500;">NO HAY TAREAS REGISTRADAS</td>
    </tr>';
  }

  $stmt2->close();
  $stmt->close();


}else {
  header("Location: ../../public/index.php");
}

?>