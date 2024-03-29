<?php
include('../../back/config/conexion.php');
require('../../back/config/funcione_globales.php');

if (!$_SESSION["u_nivel"]) {
  header("Location: ../index.php");
} else {

  $t = $_GET["t"];






  $stmt = mysqli_prepare($conexion, "SELECT go_tareas.estado, local_comunidades.nombre_c_comunal, local_comunas.nombre_comuna, go_tareas.parroquia, local_parroquia.nombre_parroquia, local_municipio.nombre_municipio, local_estados.t_estados, go_tareas.tipo_ejecucion, go_tareas.fechaFin, go_tareas.responsable_ente_id, go_tareas.vehiculos, go_tareas.condicion_vehiculos, go_tareas.atencion_personas_1, go_tareas.atencion_personas_2, go_tareas.atencion_personas_3, go_tareas.atencion_personas_4, go_tareas.atencion_comunidades_1, go_tareas.atencion_comunidades_2, go_tareas.atencion_comunidades_3, go_tareas.atencion_comunidades_4, go_tareas.atencion_comunas_1, go_tareas.atencion_comunas_2, go_tareas.atencion_comunas_3, go_tareas.atencion_comunas_4, go_tareas.unidad_medida, go_tareas.mt_1, go_tareas.mt_2, go_tareas.mt_3, go_tareas.mt_4, go_tareas.mr_1, go_tareas.mr_2, go_tareas.mr_3, go_tareas.mr_4, go_tareas.cantidad_medida, go_tareas.atencion_personas, go_tareas.atencion_comunidades, go_tareas.atencion_comunas, go_tareas.tipo_ejecucion, go_tareas.id_tarea, go_operaciones.cerrado, go_tareas.fecha, go_tareas.fecha_ejecucion, go_tareas.status, system_users.u_ente, go_tareas.ubicacion, go_tareas.cords, go_tareas.tarea, go_tareas.descripcion, go_tareas.creacion FROM `go_tareas` 
  LEFT JOIN go_operaciones ON go_operaciones.id = go_tareas.id_operacion
  LEFT JOIN system_users ON go_operaciones.empresa_id = system_users.u_id
  LEFT JOIN local_estados ON go_tareas.estado = local_estados.id_estados
  LEFT JOIN local_municipio ON local_municipio.id_municipio = go_tareas.municipio
  LEFT JOIN local_parroquia ON local_parroquia.id_parroquias = go_tareas.parroquia
  LEFT JOIN local_comunas ON local_comunas.id_Comuna = go_tareas.comuna
  LEFT JOIN local_comunidades ON local_comunidades.id_consejo = go_tareas.comunidad

  WHERE go_tareas.id_tarea = ?");
  $stmt->bind_param('s', $t);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $lugar = $row['ubicacion'];
      $id_tarea = $row['id_tarea'];
      $geometry = $row['cords'];
      $cerrado = $row['cerrado'];
      $status = $row['status'];
      $nombre = $row['tarea'];
      $decripcion = $row['descripcion'];
      $_uente = $row['u_ente'];
      $creacion = $row['creacion'];
      $fechaFin = $row['fechaFin'];
      $fecha = $row['fecha'];
      $fechaejecu = $row['fecha_ejecucion'];
      $tipo_ejecucion = $row['tipo_ejecucion'];
      $tipoEjecucion = $row['tipo_ejecucion'];
      $unidad_medida = $row['unidad_medida'];
      $mt_1 = $row['mt_1'];
      $mt_2 = $row['mt_2'];
      $mt_3 = $row['mt_3'];
      $mt_4 = $row['mt_4'];
      $mr_1 = $row['mr_1'];
      $mr_2 = $row['mr_2'];
      $mr_3 = $row['mr_3'];
      $mr_4 = $row['mr_4'];
      $cantidad_medida = $row['cantidad_medida'];
      $atencion_personas = $row['atencion_personas'];
      $atencion_comunidades = $row['atencion_comunidades'];
      $atencion_comunas = $row['atencion_comunas'];
      $atencion_personas_1 = $row['atencion_personas_1'];
      $atencion_personas_2 = $row['atencion_personas_2'];
      $atencion_personas_3 = $row['atencion_personas_3'];
      $atencion_personas_4 = $row['atencion_personas_4'];
      $atencion_comunidades_1 = $row['atencion_comunidades_1'];
      $atencion_comunidades_2 = $row['atencion_comunidades_2'];
      $atencion_comunidades_3 = $row['atencion_comunidades_3'];
      $atencion_comunidades_4 = $row['atencion_comunidades_4'];
      $atencion_comunas_1 = $row['atencion_comunas_1'];
      $atencion_comunas_2 = $row['atencion_comunas_2'];
      $atencion_comunas_3 = $row['atencion_comunas_3'];
      $atencion_comunas_4 = $row['atencion_comunas_4'];

      $responsable_ente_id = $row['responsable_ente_id'];
      $vehiculos = $row['vehiculos'];
      $condicion_vehiculos = $row['condicion_vehiculos'];
    
    
      $estado = $row['estado'];
      $t_estados = $row['t_estados'];
      $nombre_municipio = $row['nombre_municipio'];
      $nombre_parroquia = $row['nombre_parroquia'];
      $parroquia = $row['parroquia'];
      $nombre_comuna = $row['nombre_comuna'];
      $nombre_c_comunal = $row['nombre_c_comunal'];






      if ($tipo_ejecucion == '1') {
        $fechaFin = $fecha;

      }

    }
  } else {

    echo '
  <style>
    @import url("https://fonts.googleapis.com/css?family=Open+Sans:700");
    * {
      margin: 0;
      padding: 0;
      font-family: "Open Sans", sans-serif;
      text-align: center;
      text-decoration: none;
      outline: none;
      border: none;
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      -ms-box-sizing: border-box;
      box-sizing: border-box;
    }

    ::selection {
      background: transparent;
    }

    img {
      max-width: 100%;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    html, body {
      height: 100%;
    }

    body {
      background: #fff;
    }

    .wrapper {
      position: relative;
      padding: 20px;
    }
    .wrapper .oops {
      color: #4B4F4B;
      font-size: 8em;
      letter-spacing: 0.05em;
      margin-top: 30px;
    }
    .wrapper .info {
      color: #4B4F4B;
      padding: 5px;
    }
    .wrapper .button {
      background: #FF5659;
      color: #fff;
      text-transform: uppercase;
      padding: 10px 40px;
      border-radius: 50px;
      transition: 150ms;
      cursor: pointer
    }
    .wrapper .button:hover {
      background: #FF2629;
      transition: 150ms;
    }
    .wrapper .button:hover .fa-angle-left {
      animation: test 700ms ease-out;
      animation-iteration-count: infinite;
    }
    @keyframes test {
      to {
        margin-right: 20px;
      }
    }
    .wrapper .button .fa-angle-left {
      font-size: 1.2em;
      margin-right: 15px;
    }
    .wrapper img {
      padding: 10px;
    }
  </style>

  <div class="wrapper">
    <h1 class="oops">Oops</h1>
    <p class="info">La información que intenta consultar ha sido eliminada.<br>¡Tarea no encontrada!</p>
    <br />
    <button onclick="history.back()" class="button">Regresar</button>
  </div>';
    exit();
  }

  /*if ($_SESSION["u_nivel"] == 1) {
    $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_operaciones` WHERE id = ?");
    $stmt->bind_param('s', $operacion_id);
  } else {
    $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_operaciones` WHERE id = ? AND empresa_id = ?");
    $stmt->bind_param('ss', $operacion_id, $_SESSION["u_ente_id"]);
  }

  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $nombre = $row['nombre'];
      $descripcion = $row['descripcion'];
      $empresa_id = $row['empresa_id'];
    }
  } else {
    header("Location: go_muro");
  }

  if ($_SESSION["u_ente_id"] == $empresa_id) {
    $modo = '1';
  } else {
    $modo = '2';
  }*/

?>
  <!DOCTYPE html>
  <html lang="es" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title class="go" id="title">Tarea</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <script src="../../assets/vendor/js/helpers.js"></script>
    <script src="../../assets/js/config.js"></script>
    <link rel="stylesheet" href="../../assets/css/animate.css" />
    <link rel="stylesheet" href="../../assets/css/bs-stepper.css" />
    <link rel="stylesheet" href="../../assets/css/tags.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="../../assets/vendor/leaflet.fullscreen-master/Control.FullScreen.css" />
    <script src="../../assets/vendor/leaflet.fullscreen-master/Control.FullScreen.js"></script>
    <link rel="stylesheet" href="../../assets/vendor/leaflet.draw/leafletDraw.css" />
    <script src="../../assets/vendor/leaflet.draw/leaflet.draw.js"></script>
    <script src="../../js/sweetalert2.all.min.js"></script>
    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>

    <style>
      #map {
        height: 50vh;
        width: 100%;
      }
    </style>
  </head>



  <body>
    <div class="container-loader">
      <div class="spinner">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
      </div>
    </div>



    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
        <?php require('../includes/menu.php'); ?>
        <!-- / Menu -->
        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          <?php require('../includes/nav.php'); ?>
          <!-- / Navbar -->
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y ">
              <div class=" d-flex justify-content-between">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gestión Operativa /</span> Acción </h4>
              </div>
              <div class="row animated mb-4 animated fadeInRight" id="vistaPrincipal">




                <div class="col-lg-8">
                  <div class="row">



                    <div class="col-lg-12">
                      <div class="card mb-3" style="overflow: hidden;">
                        <div class="d-flex row">
                          <div class="col-8">
                            <div class="card-body">
                              <h6 class="card-title mb-1 text-nowrap"> <?php echo $nombre ?> - <?php echo ($status === 0 ? '<span class="fw-bold text-primary">Pendiente</span>' : '<span class="fw-bold text-success">Ejecutado</span>') ?><br><br>
                            

                              Tiempo de ejecución: <span class="text-primary">


                              <?php 
                              switch ($tipo_ejecucion) {
                                case ('1'):
                                  echo 'un día';
                                  break;
                                case ('2'):
                                  echo 'Todo el año';
                                  break;
                                case ('3'):
                                  echo 'Una semana';
                                  break;
                                case ('4'):
                                  echo 'Un mes';
                                  break;
                                case ('5'):
                                  echo 'Un trimestre';
                                  break;
                                case ('6'):
                                  echo 'Un semestre';
                                  break;
                                }
                              ?>
</span>
                            </h6>
                              <small class="d-block mb-3 text-muted"> <?php echo $decripcion ?> </small>
                            </div>
                          </div>
                          <div class="col-4 pt-3 ps-0">

                            <?php
                            echo '<ul class="timeline ps-3">
                                         <li class="timeline-item ps-4 border-left-dashed">
                                           <span class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                                             <i class="bx bx-star"></i>
                                           </span>
                                           <div class="timeline-event ps-0 pb-0">
                                             <div class="timeline-header">
                                               <small class="text-primary text-uppercase fw-medium">Inicia la ejecución</small>
                                             </div>
                                             <h6 class="mb-1">' . $_uente . '</h6>
                                             <p class="text-muted mb-0">' . fechaCastellano($fecha) . '</p>
                                           </div>
                                         </li>
                                         <li class="timeline-item ps-4 border-transparent">';




                            if ($status == '0') {
                              echo '
                              <span class="timeline-indicator-advanced timeline-indicator-danger border-0 shadow-none">
                              <i class="bx bx-task-x"></i>
                            </span>
                            <div class="timeline-event ps-0 pb-0">
                              <div class="timeline-header">
                                <small class="text-danger text-uppercase fw-medium">Pendiente</small>
                                </div>
                                <p class="text-muted mb-0">'. fechaCastellano($fechaFin) . '</p>
                              ';
                            } elseif ($row['status'] == '1') {
                              echo '
                                           <span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                                           <i class="bx bx-task"></i>
                                         </span>
                                         <div class="timeline-event ps-0 pb-0">
                                           <div class="timeline-header">
                                             <small class="text-success text-uppercase fw-medium">Ejecutado</small>
                                           </div>
                                           <p class="text-muted mb-0">' .fechaCastellano($fechaFin) . '</p>
                                           ';
                            } else {
                              echo '
                              <span class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                              <i class="bx bx-task"></i>
                            </span>
                            <div class="timeline-event ps-0 pb-0">
                              <div class="timeline-header">
                                <small class="text-primary text-uppercase fw-medium">En proceso</small>
                              </div>
                              ';
                            }





                            echo '</div>
                                         </li>
                                       </ul>';
                            ?>
                          </div>
                        </div>
                      </div>










                    </div>










                    <div class="col-lg-12 mb-3">

                      <div class="card ">
                        <div class="card-body">
                          <div class="card-title d-flex justify-content-between">


                            <h5>Lugar de ejecución</h5>
                          </div>

                          <div id="map"></div>

                          <div class="divider text-start">
                            <div class="divider-text">
                              <i class="bx bx-map"></i>
                            </div>
                          </div>
                         <?php 
                            echo '<b>Estado: </b>'.$t_estados.' ';
                            if ($estado != '02') {
                              echo '<b>Ubicación: </b>'.$lugar;
                            } else {
                                echo '<b>Municipio: </b>'.$nombre_municipio.' <b>Parroquia: </b> '.$nombre_parroquia.' ';
                              if ($parroquia == '020302' || $parroquia == '020301' || $parroquia == '020303' || $parroquia == '020304') {
                                echo '<b>Comuna: </b>'.$nombre_comuna.' <b>Comunidad: </b>'.$nombre_c_comunal;
                              } else {
                                  echo '<b>Ubicación: </b>'.$lugar;
                              }
                            }
                         ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="col-md-6 col-lg-4 order-2 mb-4">
                  <?php if ($status == 1 || $status == 2) { ?>
                    <?php

                    $result1 = '';
                    $result2 = '';
                    $result3 = '';
                    $result4 = '';

                    if ($mr_1 != '') {
                      $p_1 = $mr_1 * 100 / $mt_1;
                      if ($p_1 >= 100) {
                        $result1 = '<span>' . $p_1 . '% alcanzado</span>';
                      } else {
                        $result1 = '<span>' . $p_1 . '% alcanzado</span>';
                      }
                    }

                    if ($mr_2 != '') {
                      $p_2 = $mr_2 * 100 / $mt_2;
                      if ($p_2 >= 100) {
                        $result2 = '<span>' . $p_2 . '% alcanzado</span>';
                      } else {
                        $result2 = '<span>' . $p_2 . '% alcanzado</span>';
                      }
                    }
                    if ($mr_3 != '') {
                      $p_3 = $mr_3 * 100 / $mt_3;
                      if ($p_3 >= 100) {
                        $result3 = '<span>' . $p_3 . '% alcanzado</span>';
                      } else {
                        $result3 = '<span>' . $p_3 . '% alcanzado</span>';
                      }
                    }
                    if ($mr_4 != '') {
                      $p_4 = $mr_4 * 100 / $mt_4;
                      if ($p_4 >= 100) {
                        $result4 = '<span>' . $p_4 . '% alcanzado</span>';
                      } else {
                        $result4 = '<span>' . $p_4 . '% alcanzado</span>';
                      }
                    }

                    $mr_t = $mr_1 + $mr_2 + $mr_3 + $mr_4;
                    $mt_t = $mt_1 + $mt_2 + $mt_3 + $mt_4;

                    if ($mr_t != '') {
                      $pt = $mr_t * 100 / $mt_t;
                      if ($pt >= 100) {
                        $result_t = '<small class="text-success fw-medium"><i class="bx bx-chevron-up text-success"></i> <span>' . $pt . '%</span> </small>';
                      } else {
                        $result_t = '<small class="text-danger fw-medium"><i class="bx bx-chevron-down text-danger"></i> <span>' . $pt . '%</span> </small>';
                      }
                    }



                    ?>
                    <div class="card mb-3">
                      <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="card-title mb-0">
                          <h5 class="m-0 me-2">Resultados</h5>
                          <small class="text-muted">Resultados de la ejecución</small>
                        </div>
                      </div>
                      <div class="card-body">
                        <?php

                        if ($tipoEjecucion == '2') {
                          echo ' <div class="d-flex flex-row align-items-center gap-1 mb-4">
                  <h2 class="mb-2">' . $mr_t . ' <small>(' . $unidad_medida . ')</small></h2>
                  
                    ' . $result_t . ' 
                  
                </div>';
                        }
                        ?>

                        <ul class="p-0 m-0">

                          <?php if ($tipoEjecucion == '1') { ?>


                            <li class="d-flex mb-4">
                              <div class="d-flex w-100 flex-wrap justify-content-between gap-2">
                                <div class="me-2">
                                  <small class="text-muted"><i class="me-2 bx bx-abacus"></i><strong><?php echo ($cantidad_medida == '' ? 'X ' : $cantidad_medida) . '</strong> ' . $unidad_medida ?></small> <br>
                                  <?php
                                  echo ' <small class="text-muted"><i class="me-2 bx bx-user"></i>Personas atendidas:<strong> ' . $atencion_personas . '</strong></small><br>';
                                  echo ' <small class="text-muted"><i class="me-2 bx bx-map-pin"></i>Comunidades: <strong>' . $atencion_comunidades . '</strong></small><br>';
                                  echo ' <small class="text-muted"><i class="me-2 bx bx-map-alt"></i>Comunas: <strong>' . $atencion_comunas . '</strong></small>';
                                  ?>
                                </div>

                              </div>
                            </li>







                          <?php } else { ?>

                            <li class="d-flex mb-4">
                              <div class="d-flex w-100 flex-wrap justify-content-between gap-2">
                                <div class="me-2">
                                  <h6 class="mb-1">Primer trimestre</h6>
                                  <small class="text-muted"><i class="me-2 bx bx-abacus"></i><strong><?php echo ($mr_1 == '' ? 'X ' : $mr_1) . '</strong> ' . '<small>(' . $unidad_medida . ') / ' . $mt_1 . '</small>' ?></small> <br>
                                  <?php
                                  echo ' <small class="text-muted"><i class="me-2 bx bx-user"></i>Personas atendidas:<strong> ' . $atencion_personas_1 . '</strong></small><br>';
                                  echo ' <small class="text-muted"><i class="me-2 bx bx-map-pin"></i>Comunidades: <strong>' . $atencion_comunidades_1 . '</strong></small><br>';
                                  echo ' <small class="text-muted"><i class="me-2 bx bx-map-alt"></i>Comunas: <strong>' . $atencion_comunas_1 . '</strong></small>';
                                  ?>
                                </div>
                                <div class="user-progress">
                                  <?php echo $result1 ?>
                                </div>
                              </div>
                            </li>
                            <hr>


                            <li class="d-flex mb-4">
                              <div class="d-flex w-100 flex-wrap justify-content-between gap-2">
                                <div class="me-2">
                                  <h6 class="mb-1">Segundo trimestre</h6>
                                  <small class="text-muted"><i class="me-2 bx bx-abacus"></i><strong><?php echo ($mr_2 == '' ? 'X ' : $mr_2) . '</strong> ' . '<small>(' . $unidad_medida . ') / ' . $mt_2 . '</small>' ?></small> <br>
                                  <?php
                                  echo ' <small class="text-muted"><i class="me-2 bx bx-user"></i>Personas atendidas:<strong> ' . $atencion_personas_2 . '</strong></small><br>';
                                  echo ' <small class="text-muted"><i class="me-2 bx bx-map-pin"></i>Comunidades: <strong>' . $atencion_comunidades_2 . '</strong></small><br>';
                                  echo ' <small class="text-muted"><i class="me-2 bx bx-map-alt"></i>Comunas: <strong>' . $atencion_comunas_2 . '</strong></small>';
                                  ?>
                                </div>
                                <div class="user-progress">
                                  <?php echo $result2 ?>
                                </div>
                              </div>
                            </li>

                            <hr>


                            <li class="d-flex mb-4">
                              <div class="d-flex w-100 flex-wrap justify-content-between gap-2">
                                <div class="me-2">
                                  <h6 class="mb-1">Tercer trimestre</h6>
                                  <small class="text-muted"><i class="me-2 bx bx-abacus"></i><strong><?php echo ($mr_3 == '' ? 'X ' : $mr_3) . '</strong> ' . '<small>(' . $unidad_medida . ') / ' . $mt_3 . '</small>' ?></small> <br>
                                  <?php
                                  echo ' <small class="text-muted"><i class="me-2 bx bx-user"></i>Personas atendidas:<strong> ' . $atencion_personas_3 . '</strong></small><br>';
                                  echo ' <small class="text-muted"><i class="me-2 bx bx-map-pin"></i>Comunidades: <strong>' . $atencion_comunidades_3 . '</strong></small><br>';
                                  echo ' <small class="text-muted"><i class="me-2 bx bx-map-alt"></i>Comunas: <strong>' . $atencion_comunas_3 . '</strong></small>';
                                  ?>
                                </div>
                                <div class="user-progress">
                                  <?php echo $result3 ?>
                                </div>
                              </div>
                            </li>

                            <hr>

                            <li class="d-flex mb-4">
                              <div class="d-flex w-100 flex-wrap justify-content-between gap-2">
                                <div class="me-2">
                                  <h6 class="mb-1">Cuarto trimestre</h6>
                                  <small class="text-muted"><i class="me-2 bx bx-abacus"></i><strong><?php echo ($mr_4 == '' ? 'X ' : $mr_4) . '</strong> ' . '<small>(' . $unidad_medida . ') / ' . $mt_4 . '</small>' ?></small> <br>
                                  <?php
                                  echo ' <small class="text-muted"><i class="me-2 bx bx-user"></i>Personas atendidas:<strong> ' . $atencion_personas_4 . '</strong></small><br>';
                                  echo ' <small class="text-muted"><i class="me-2 bx bx-map-pin"></i>Comunidades: <strong>' . $atencion_comunidades_4 . '</strong></small><br>';
                                  echo ' <small class="text-muted"><i class="me-2 bx bx-map-alt"></i>Comunas: <strong>' . $atencion_comunas_4 . '</strong></small>';
                                  ?>
                                </div>
                                <div class="user-progress">
                                  <?php echo $result4 ?>
                                </div>
                              </div>
                            </li>






                          <?php } ?>











                        </ul>
                      </div>



                      <div class="card mb-3">

                        <div class="card-body">


                          <div class="containerPhoto">

                            <?php

                            $trimestres = array('t1', 't2', 't3', 't4');
                            $archivo = $id_tarea . '_';



                            if ($tipoEjecucion == '1') {
                              $count = 1;
                              $car = 1;
                              $active = 's';
                              while ($active == 's') {
                                if (file_exists('../../assets/img/tareas/' . $archivo . $count . '.png')) {
                                  echo '
                                       <img src="../../assets/img/tareas/' . $archivo . $count . '.png" class="images img_cover ' . ($car == '1' ? 'active' : '') . '" id="img_' . $car . '" onclick="toggle_class(\'img_' . $car . '\')">';
                                } else {
                                  $active = 'n';
                                }
                                $car++;
                                $count++;
                              }
                            } else {
                              $car = 1;
                              foreach ($trimestres as $item) {
                                $count = 1;
                                $active = 's';
                                while ($active == 's') {
                                  if (file_exists('../../assets/img/tareas/' . $item . '_' . $archivo . $count . '.png')) {
                                    echo '
                                            <img src="../../assets/img/tareas/' . $item . '_' . $archivo . $count . '.png" class="img_cover ' . ($car == '1' ? 'active' : '') . ' images" id="img_' . $car . '" onclick="toggle_class(\'img_' . $car . '\')">';
                                    $car++;
                                  } else {
                                    $active = 'n';
                                  }
                                  $count++;
                                }
                              }
                            }

                            ?>





                          </div>
















                          <script>
                            function toggle_class(id) {
                              var elem = document.getElementById(id);
                              if (elem.className.indexOf("img_center") > -1) {
                                elem.className = elem.className.replace("img_center", "");
                                elem.className += " img_cover";
                              } else {
                                elem.className = elem.className.replace("img_cover", "");
                                elem.className += " img_center";
                              }
                            }



                            function setImg(id) {
                              $(".images").removeClass('active');
                              $("#" + id).addClass('active');

                              $(".page-item").removeClass('active');
                              $("." + id).addClass('active');



                            }
                          </script>









                          <div class="d-flex mt-3">
                            <ul class="pagination m-a">


                              <?php

                              if ($tipoEjecucion == '1') {
                                $count = 1;
                                $active = 's';
                                $car = 1;
                                while ($active == 's') {
                                  if (file_exists('../../assets/img/tareas/' . $archivo . $count . '.png')) {
                                    echo '
                                    <li class="page-item img_' . $car . ' ' . ($car == '1' ? 'active' : '') . '">
                                      <a class="page-link pointer" onclick="setImg(\'img_' . $car . '\')">' . $car . '</a>
                                    </li>';
                                  } else {
                                    $active = 'n';
                                  }
                                  $count++;
                                  $car++;
                                }
                              } else {
                                $car = 1;
                                foreach ($trimestres as $item) {
                                  $count = 1;
                                  $active = 's';
                                  while ($active == 's') {
                                    if (file_exists('../../assets/img/tareas/' . $item . '_' . $archivo . $count . '.png')) {

                                      echo '
                                      <li class="page-item img_' . $car . ' ' . ($car == '1' ? 'active' : '') . '">
                                        <a class="page-link pointer" onclick="setImg(\'img_' . $car . '\')">' . $car . '</a>
                                      </li>';

                                      $count++;
                                      $car++;
                                    } else {
                                      $active = 'n';
                                    }
                                  }
                                }
                              }
                              ?>



                            </ul>
                          </div>



                        </div>
                      </div>
                    </div>
                  <?php } ?>



                  <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between">
                      <h5 class="card-title m-0">
                        <i class="bx bx-car"></i> Vehículos
                      </h5>
                      <?php if ($status === 0) { ?>
                        <?php if ($responsable_ente_id == $_SESSION["u_ente_id"] || $_SESSION["u_nivel"] == 1) { ?>
                          <button class="btn btn-primary btn-sm" onclick="vistaAddMedios()">Modificar</button>
                        <?php } ?>
                      <?php } ?>
                    </div>
                    <div class="card-body">
                      <section id="listaMediosEnd">
                      </section>
                    </div>
                  </div>


                  <div class="card mb-3">
                    <div class="card-header ">
                      <h5 class="card-title m-0"> <i class="bx bx-group"></i> Responsables</h5>
                    </div>

                    <div class="card-body">
                      <?php
                      $stmt2 = mysqli_prepare($conexion, "SELECT id, empresa_id, empresa, responsabilidad, fechaAsig FROM `go_tareas_responsables` WHERE tarea = ? AND status='1'");
                      $stmt2->bind_param('s', $t);
                      $stmt2->execute();
                      $result2 = $stmt2->get_result();
                      if ($result2->num_rows > 0) {
                        while ($row2 = $result2->fetch_assoc()) {
                          // array_push($responsables, [$row2['empresa'], $row2['id'], $row2['empresa_id'], $row2['responsabilidad']]);

                          if ($row2['empresa_id'] == $_SESSION["u_ente_id"]) {
                            $classPulse = 'pulseOpacity';
                          } else {
                            $classPulse = '';
                          }
                          echo '  
                          
                        <div class="timeline-event ' . $classPulse . '">
                      
                        <div class="timeline-header mb-2 d-flex w-100 flex-wrap align-items-center justify-content-between">
                            <h6 class="mb-0">' . $row2['empresa'] . '</h6>
                            <small class="text-muted">' . fechaCastellano($row2['fechaAsig']) . '</small>
                          </div>

                          <div class="d-flex flex-wrap mt-2">
                            <div class="avatar me-3">
                              <img src="../../assets/img/avatars/8.png" alt="Avatar" class="rounded-circle">
                            </div>
                            <div>
                              <h6 class="mb-0">Responsabilidad:</h6>
                              <span>' . $row2['responsabilidad'] . '</span>
                            </div>
                          </div>
                        </div>

                        <div class="divider">
                              <div class="divider-text"></div>
                            </div>
                                
                          
                         ';
                        }
                      } else {
                        echo "<p class='text-center'>
                        <img  src='../../assets/img/illustrations/comunidad.png' alt='OK' height='150px'>
                        <p class='mt-3 text-center'> No hay ningún otra empresa involucrada.</p>
                        </p>";
                      }
                      $stmt2->close();

                      ?>
                    </div>
                  </div>

                  <div class="card mb-3">

                    <div class="card-header">

                      <h5 class="card-title m-0"> <i class="bx bx-cube"></i> Insumos</h5>
                    </div>
                    <div class="card-body">
                      <ul class="p-0 m-0">

                        <?php
                        $stmt2 = mysqli_prepare($conexion, "SELECT id, recurso, status FROM `go_tareas_recursos` WHERE tarea = ?");
                        $stmt2->bind_param('s', $t);
                        $stmt2->execute();
                        $result2 = $stmt2->get_result();
                        if ($result2->num_rows > 0) {
                          while ($row2 = $result2->fetch_assoc()) {
                            // array_push($responsables, [$row2['empresa'], $row2['id'], $row2['empresa_id'], $row2['responsabilidad']]);
                            echo '  <li class="d-flex mb-4 pb-1">
                          <div class="avatar flex-shrink-0 me-3">
                            <div class="bg-label-info rounded grid-center p-2 fw-bold">' . substr($row2['recurso'], 0, 1) . '</div>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                            <h6 class="mb-1">' . $row2['recurso'] . '</h6>
                              <small class=" d-block text-muted">' . ($row2['status'] == '0' ? ' <i class="bx bx-info-circle"></i> Pendiente' : 'Listo') . '</small>
                            </div>
              ';

                            /*
                            <div>
                            ' . ($row2['status'] == '0' ? ' <button id="btni_'. $row2['id'] .'" onclick="setStatusRecuros(\'' . $row2['id'] . '\', \'' . $row2['recurso'] . '\')" type="button" class="btn btn-sm btn-icon btn-label-linkedin"><i class="tf-icons bx bx-check"></i></button>' : '') . ' 
                            </div>*/
                            echo '
                          </div>
                        </li>';
                          }
                        } else {
                          echo "<p class='text-center'>No se registraron insumos.</p>";
                        }
                        $stmt2->close();

                        ?>
                      </ul>
                    </div>
                  </div>




                  <div class="card mb-3">

                    <div class="card-header text-centered">

                      <h5 class="card-title m-0"> <i class="bx bx-cloud-rain"></i> Condiciones adversas</h5>

                    </div>
                    <div class="card-body">
                      <ul class="p-0 m-0">

                        <?php
                        $stmt2 = mysqli_prepare($conexion, "SELECT condicion FROM `go_tareas_condiciones` WHERE tarea = ?");
                        $stmt2->bind_param('s', $t);
                        $stmt2->execute();
                        $result2 = $stmt2->get_result();
                        if ($result2->num_rows > 0) {
                          while ($row2 = $result2->fetch_assoc()) {
                            // array_push($responsables, [$row2['empresa'], $row2['id'], $row2['empresa_id'], $row2['responsabilidad']]);
                            echo '  <li class="d-flex mb-4 pb-1">
                          <div class="avatar avatar-xs flex-shrink-0 me-3">
                          <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-error"></i></span>
                        </div>


                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                            <h6 class="mb-1">' . $row2['condicion'] . '</h6>
                            </div>
                          </div>
                        </li>';
                          }
                        } else {
                          echo "
                          <p class='text-center'>
                        <img src='../../assets/img/illustrations/condiciones.png' alt='OK' height='150px'>
                        <p class='mt-3 text-center'>No se registraron condiciones adversas.</p>
                        </p>";
                        }
                        $stmt2->close();

                        ?>
                      </ul>
                    </div>
                  </div>





                </div>









              </div>
              <?php if ($responsable_ente_id == $_SESSION["u_ente_id"] || $_SESSION["u_nivel"] == 1) { ?>

                <div class="row animated mb-4 animated fadeInRight" id="vistaVehiculos" style="display: none;">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="card mb-3" style="overflow: hidden;">
                        <div class="card-body">
                          <div class="d-flex justify-content-between">
                            <div>
                              <h6 class="card-title mb-1 text-nowrap"> Registro de vehiculos</h6>
                              <small class="d-block text-muted"> Seleccione los vehículos que se usaran para la ejecución de la acción </small>
                            </div>

                            <button class="btn btn-sm btn-secondary" onclick="cerrarVistaAddMedios()">Cerrar</button>
                          </div>
                        </div>
                        <div>

                          <hr>




                          <div class="table-responsive text-start text-nowrap mb-3">
                            <table class="table table-borderless">
                              <thead>
                                <tr>
                                  <th>Vehículo</th>
                                  <th>Placa</th>
                                  <th>Acciones</th>
                                  <th></th>
                                  <th></th>
                                </tr>
                              </thead>
                              <tbody id="listVehiculos">
                              </tbody>
                            </table>
                          </div>




                          <script>
                            function cerrarVistaAddMedios() {
                              $(".container-loader").show();
                              $.get("../../back/ajax/go_tarea_get_medios_definitivos.php", "t=" + "<?php echo $_GET["t"] ?>", function(data) {
                                $('#listaMediosEnd').html(data)
                                $('#vistaPrincipal').show()
                                $('#vistaVehiculos').hide()
                                $(".container-loader").hide();
                              });
                            }


                            function vistaAddMedios() {
                              $(".container-loader").show();
                              getMedios()

                              $('#vistaPrincipal').hide()
                              $('#vistaVehiculos').show()
                              $(".container-loader").hide();
                            }

                            function getMedios() {
                              $('.container-loader').show()
                              $.get("../../back/ajax/go_tarea_get_medios_.php", "t=" + "<?php echo $_GET["t"] ?>", function(data) {
                                $('.container-loader').hide()
                                $('#listVehiculos').html(data)
                              });
                            }



                            /* AGREGAR / QUITAR VEHICULO */
                            function vehiculo(id, op) {
                              $(".container-loader").show();

                              $.get("../../back/ajax/go_tarea_set_medios_2.php", "m=" + id + "&t=<?php echo $_GET["t"] ?>", function(data) {
                                getMedios()
                                $(".container-loader").hide();
                                if (op == 's') {
                                  Swal.fire({
                                    title: "Atención",
                                    text: "El vehículo que agregó esta empleado para una tarea en la fecha seleccionada",
                                    icon: "info",
                                    showCancelButton: true,
                                    confirmButtonColor: "#69a5ff",
                                    confirmButtonText: "Ok"
                                  })
                                }

                              });



                            }
                            /* AGREGAR / QUITAR VEHICULO */
                          </script>









                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="content-backdrop fade"></div>
                </div>
              <?php } ?>

              <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
          </div>



          <script>
            function obtenerMedios() {
              $('.container-loader').show()
              $.get("../../back/ajax/go_tarea_get_medios_definitivos.php", "t=" + "<?php echo $_GET["t"] ?>", function(data) {
                $('.container-loader').hide()
                $('#listaMediosEnd').html(data)
              });
            }
            obtenerMedios()
          </script>
          <!-- Modal  -->

          <!-- Modal empresas involucradas -->



          <!-- Overlay -->
          <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- Modal  -->



        <!-- / Layout wrapper -->
        <?php require('../includes/alerts.html'); ?>
        <!-- build:js assets/vendor/js/core.js -->
        <script src="../../assets/vendor/libs/popper/popper.js"></script>
        <script src="../../assets/vendor/js/bootstrap.js"></script>
        <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
        <script src="../../assets/vendor/js/menu.js"></script>
        <script src="../../assets/js/main.js"></script>
        <script src="../../assets/js/ui-popover.js"></script>


  </body>
  <script>
    /*
                    function setStatusRecuros(id, recurso) {
                      Swal.fire({
                        title: "¿Esta seguro?",
                        icon: "warning",
                        html: `Se cambiará el estatus del insumo "<b>` + recurso + `</b>". Los cambios son irreversibles.`,
                        confirmButtonColor: "#69a5ff",
                        cancelButtonText: `Cancelar`,
                        showCancelButton: true,
                        confirmButtonText: "Cambiar",
                      }).then((result) => {
                        if (result.isConfirmed) {


                          $('#btni_'+id).removeAttr
                          //cambuar status
                        }
                      });
                    }

                    */


    /*MAPA */
    var map = new L.Map("map", {
      fullscreenControl: true,
      fullscreenControlOptions: {
        position: "topleft",
      },
    }).setView([5.65, -67.6], 13);
    map.attributionControl.setPrefix("Leaflet");

    var baseLayers = {
      Satelite: L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
        minZoom: 2,
        maxZoom: 28,
        attribution: '',
        subdomains: ["mt0", "mt1", "mt2", "mt3"]
      }),
      Calles: L.tileLayer("http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}", {
        minZoom: 2,
        maxZoom: 28,
        attribution: "",
        subdomains: ["mt0", "mt1", "mt2", "mt3"],
      }),
    };
    map.addLayer(baseLayers.Satelite);

    var overlayers = {};

    var controlRight1 = L.control
      .layers(baseLayers, overlayers, {
        position: "topright", // 'topleft', 'bottomleft', 'bottomright'
        collapsed: true, // true
      })
      .addTo(map); // Primer Control Derecha



    function cargarContenidoMapa(contenido) {
      map.removeLayer(baseLayers.Satelite);
      map.addLayer(baseLayers.Calles);
      let = json = JSON.parse(contenido)
      let geoJson = L.geoJSON(json).addTo(map);
      map.fitBounds(geoJson.getBounds());
      map.setZoom(13);
    }





    cargarContenidoMapa('<?php echo $geometry ?>');
  </script>

  </html>

<?php
}
?>