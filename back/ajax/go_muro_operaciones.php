<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"] == 1 || $_SESSION["u_nivel"] == 2 || $_SESSION["u_nivel"] == 3) {

  $condicion ='';

  $filter = $_GET["f"];

  if ($filter != 'false') {
    switch ($filter) {
      case ('mes'):
        $month = date('m');
        $ano = date('Y');
        $condicion = "WHERE ano = '$ano' AND mes='$month'";
        break;
      case ("contingencias"):
        $condicion = "WHERE tipo_p='3'";
        break;
      case ("ejecutado"):
        $condicion = "WHERE cerrado='1'";
        break;
      case ("este_trimestre"):
        $trimestre = trimestre();
        $ano = date('Y');
        $condicion = "WHERE ano='$ano' AND trimestre='$trimestre'";
        break;
      case ("estrategicos"):
        $condicion = "WHERE tipo_p='2'";
        break;
      case ("mes_pasado"):
        $mes_anterior = date('m', strtotime('-1 month'));

        if (date('m') == 1 || date('m') == 01) {
          $ano = date('Y') - 1;
        } else {
          $ano = date('Y');
        }

        $last_month = date('Y-m'); // falta configurar
        $condicion = "WHERE ano='$ano' AND mes='$mes_anterior'";
        break;
      case ("operacionales"):
        $condicion = "WHERE tipo_p='1'";
        break;
      case ("trimestre_pasado"):

        $trimestre = trimestre();
        if ($trimestre == 1 || $trimestre == 01) {
          $ano = date('Y') - 1;
          $trimestre = 4;
        } else {
          $ano = date('Y');
          $trimestre -= 1;
        }

        $last_trimestre = ''; //Falta configurar
        $condicion = "WHERE ano='$ano' AND trimestre='$last_trimestre'";
        break;
    }
  }

  $ordenamiento = ' ORDER BY go_operaciones.id DESC';
  $order = $_GET["o"];

  if ($order != 'false') {
    switch ($order) {
      
      case ('fecha_a'):
        $ordenamiento = ' ORDER BY data_time ASC';
        break;
      
      case ('fecha_d'):
        $ordenamiento = ' ORDER BY data_time DESC';
        break;
      
      case ('tipo_a'):
        $ordenamiento = ' ORDER BY tipo_p ASC';
        break;
      
      case ('tipo_d'):
        $ordenamiento = ' ORDER BY tipo_p DESC';
        break;

    }
  }





  $users = array();
  $stmt_users = mysqli_prepare($conexion, "SELECT * FROM `system_users` WHERE u_nivel ='2'");
  $stmt_users->execute();
  $result_users = $stmt_users->get_result();
  if ($result_users->num_rows > 0) {
    while ($row_users = $result_users->fetch_assoc()) {
      $users[$row_users['u_ente_id']] = $row_users['u_ente'];
    }
  }
  $stmt_users->close();




   
  $stmt_opera = mysqli_prepare($conexion, "SELECT DISTINCT(empresa_id) FROM `go_tareas_responsables` WHERE operacion =?");


  $stmt = mysqli_prepare($conexion, "SELECT go_operaciones.cerrado, go_operaciones.tipo_resp, go_operaciones.users_id, go_planes.nombre AS nombrePlan, go_operaciones.id AS id_o, go_operaciones.tipo_p, system_users.u_ente, go_operaciones.nombre, go_operaciones.descripcion, go_operaciones.data_time, go_operaciones.empresa_id FROM `go_operaciones`
  LEFT JOIN system_users ON system_users.u_id = go_operaciones.empresa_id
  LEFT JOIN go_planes ON go_planes.id = go_operaciones.id_p
  $condicion $ordenamiento");
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

      $id = $row['id_o'];

      if ($row['cerrado'] == '1') {
        $class = 'card-border-shadow-success';
      }else {
        $class = '';
      }
      echo '






          <div class="card o-h mb-4 '.$class.'">
          <div class="card-body zi-2">
            <div class="card-text d-flex justify-content-between">
              <h5 class="card-title">' . $row['u_ente'];


              switch ($row['tipo_p']) {
                case ('1'):
                   echo '<br><small class="text-success" style="font-size: 12px">  SECTORIAL</small> <small class="text-muted">- '.$row['nombrePlan'].'</small>';
                   break;
                case ('2'):
                    echo '<br><small class="text-primary" style="font-size: 12px">  ESTRATÉGICO</small> <small class="text-muted">- '.$row['nombrePlan'].'</small>';
                  break;
                case ('3'):
                    echo '<br><small class="text-warning" style="font-size: 12px">  CONTINGENCIA</small>';
                  break;
             
              }
              
              
              
              echo '</h5>
              <div>
              <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">';

                $stmt_opera->bind_param('s', $id);
                $stmt_opera->execute();
                $result_opera = $stmt_opera->get_result();
                if ($result_opera->num_rows > 0) {
                  while ($row_opera = $result_opera->fetch_assoc()) {

                    echo '<li class="avatar avatar-xs pull-up" title="' . $users[$row_opera['empresa_id']] . '" >';
                    if (file_exists('../../assets/img/avatars/' . $row_opera['empresa_id'] . '.png')) {
                      echo '<img src="../../assets/img/avatars/' . $row_opera['empresa_id'] . '.png" alt="logo ' . $users[$row_opera['empresa_id']] . '" class=" rounded-circle " title="' . $users[$row_opera['empresa_id']] . '">';
                    } else {
                      echo '<div class="bg-primary rounded-circle avatar-l">' . substr($users[$row_opera['empresa_id']], 0, 1) . '</div>';
                    }

                    echo '</li>';
                  }
                  /*  echo '<li class="avatar avatar-xs pull-up" data-bs-toggle="popover" title="Participantes" onclick="verPartivcipantes(\''.$id.'\')">
                          <div class="bg-secondary rounded-circle avatar-l">?</div>
                          </li>';*/
                }

            echo '
                </ul>
              </div>
            </div>
            <p class="card-text ">
              <strong>' . $row['nombre'] . '</strong>:&nbsp;' . $row['descripcion'] . '
              <br>
            </p>
            <div class="card-text d-flex justify-content-between mt-3">
              <div class="d-flex">
                <div class="avatar flex-shrink-0 me-2">
                  <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-calendar-exclamation bx-sm"></i></span>
                </div>
                <div>
                  <h6 class="mb-0 text-nowrap">' . fechaCastellano($row['data_time']) . '</h6>
                  <small><span class="text-muted">Creado por:</span> ';

                  if ($row['tipo_resp'] == '1') {
                    echo "La EPA";
                  }else {
                    echo nombreUsuario($row['users_id']);
                  }


                  echo '</small>
                </div>
              </div>
              <a href="go_operacion?i=' . $id . '" class="text-primary">Ver detalles <i class="bx bxs-analyse"></i> </a>
            </div>
            </div>';

      if ($row['empresa_id'] == $_SESSION["u_ente_id"]) {
        echo '
              <div class="operation_user">z</div>
              ';
      }
      echo '</div>';
    }
  }
  $stmt->close();
  $stmt_opera->close();
} else {
  header("Location: ../../public/index.php");
}
