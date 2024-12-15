<?php
include('../../back/config/conexion.php');
include('../../back/config/funcione_globales.php');

if (isset($_GET["v"])) {
  $v = $_GET["v"];
} else {
  $v = "x";
}

//notificar(['involved_users', 'admin_users'], 6, 9);
if (!$_SESSION["u_nivel"]) {
  header("Location: ../index.php");
} else {

  @$operacion_id = $_GET["i"];

  //if ($_SESSION["u_nivel"] == 1) {
  /*} else {
      $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_operaciones` WHERE id = ? AND empresa_id = ?");
      $stmt->bind_param('ss', $operacion_id, $_SESSION["u_ente_id"]);
    }*/






  $usuario = '';
  $plancerrado = '';
  $_SESSION["op_c"] = '0';

  $stmt = mysqli_prepare($conexion, "SELECT system_users.u_ente, go_operaciones.id_p, go_operaciones.nombre, go_operaciones.descripcion, go_operaciones.empresa_id, go_operaciones.cerrado, go_operaciones.tipo_p, go_planes.nombre AS nombrePlan, go_planes.cerrado AS cerradoPlan FROM `go_operaciones` 
LEFT JOIN go_planes ON go_planes.id = go_operaciones.id_p
LEFT JOIN system_users ON system_users.u_id = go_operaciones.empresa_id
WHERE go_operaciones.id = ?");
  $stmt->bind_param('s', $operacion_id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $nombre = $row['nombre'];
      $descripcion = $row['descripcion'];
      $empresa_id = $row['empresa_id'];
      $tipo_p = $row['tipo_p'];
      $u_ente = $row['u_ente'];
      $status = $row['cerrado'];


      if ($row['cerradoPlan'] == '1') {
        $status = 1;
        $_SESSION["op_c"] = 1;
      }






      if ($_SESSION["u_id"] == $row['empresa_id']) {
        $usuario = 'SA';
      }
      if ($row['id_p'] == '0') {
        $plan = 'Plan de Contingencia';
      } else {
        $plan = $row['nombrePlan'];
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
        <p class="info">La información que intenta consultar ha sido eliminada.<br>¡acción no encontrada!</p>
        <br />
        <button onclick="history.back()" class="button">Regresar</button>
      </div>
    ';
    exit();
  }



  if ($_SESSION["u_ente_id"] == $empresa_id || $_SESSION["u_nivel"] == '1') {
    $modo = '1'; // ADMINISTRADORES DE LA TAREA Y EMPESA PUBLICA
  } else {


    $stmt2 = mysqli_prepare($conexion, "SELECT empresa_id FROM `go_tareas_responsables` WHERE operacion= ?");
    $stmt2->bind_param('s', $_GET["i"]);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    if ($result2->num_rows > 0) {
      while ($row2 = $result2->fetch_assoc()) {
        $modo = '2'; // INVOLUCRADOS
      }
    } else {
      $modo = '3'; // INVOLUCRADOS
    }
    $stmt2->close();
  }

?>
  <!DOCTYPE html>
  <html lang="es" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title class="go" id="title">Operación</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
    <link rel="stylesheet" href="../../assets/vendor/calendar/theme1.css" />
    <link rel="stylesheet" href="../../assets/css/app-chat.css" />
    <script src="../../js/sweetalert2.all.min.js"></script>
    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>

    <style>
      td {
        padding: 10px !important;
      }

      tr {
        border-bottom: 1px solid #d9dee3;

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
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gestión Operativa /</span> Operación </h4>
              </div>


              <div class="row mb-4 " id="vistaPrincipal">










                <div class="col-lg-7 mb-3">


                  <div class="card mb-3" style="overflow: hidden;">
                    <div class="d-flex align-items-end row">
                      <div class="col-8">
                        <div class="card-body">
                          <h6 class="card-title mb-1 text-nowrap"> <?php echo $nombre ?> - <span class="fw-bold text-success"><?php echo $u_ente ?></span></h6>
                          <small class="d-block mb-3 text-nowrap"><strong>Plan: </strong><?php echo $plan ?></small>

                          <h5 class="card-title text-primary mb-1"><?php echo ($status === 0 ? '<span class="fw-bold text-primary">Pendiente</span>' : '<span class="fw-bold text-success">Cerrada</span>'); ?></h5>
                          <small class="d-block mb-3 text-muted"> <?php echo $descripcion ?> </small>

                          <?php
                          if ($usuario == 'SA' && $status == '0') {
                            echo '<a onclick="cerrarOperacion()" class="btn btn-sm btn-primary text-white">Cerrar operación</a>';
                          }
                          ?>


                        </div>
                      </div>
                      <div class="col-4 pt-3 ps-0">
                        <img src="https://img.freepik.com/free-vector/happy-freelancer-with-computer-home-young-man-sitting-armchair-using-laptop-chatting-online-smiling-vector-illustration-distance-work-online-learning-freelance_74855-8401.jpg" height="140" class="rounded-start" alt="View Sales">
                      </div>
                    </div>
                  </div>












                  <?php if ($usuario == 'SA') {


                    $stmt2 = mysqli_prepare($conexion, "SELECT go_solicitud_union.id, go_tareas.tarea AS nombreTarea, system_users.u_id, system_users.u_ente, go_solicitud_union.tipo, go_solicitud_union.tarea AS id_t, go_solicitud_union.descripcion FROM `go_solicitud_union`
                                  LEFT JOIN system_users ON system_users.u_id = go_solicitud_union.user_1
                                  LEFT JOIN go_tareas ON go_tareas.id_tarea = go_solicitud_union.tarea
                                  WHERE operacion= ? AND go_solicitud_union.status='0'");
                    $stmt2->bind_param('s', $_GET["i"]);

                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
                    if ($result2->num_rows > 0) {
                      echo '    <div class="card mb-3">
                                <div class="card-body">
                                  <div class="card-title d-flex justify-content-between">
                                    <h5>Solicitudes</h5>
                                    <span class="badge badge-center rounded-pill bg-label-danger"><i class="bx bxs-info-circle"></i></span>
                                  </div>
                                  <div class="table-responsive">
                                    <table class="table table-hover">
                                      <thead>
                                        <tr>
                                          <th>Empresa</th>
                                          <th>Tarea</th>
                                          <th>Detalles</th>
                                          <th>Acción</th>
                                        </tr>
                                      </thead>
                                      <tbody class="table-border-bottom-0">';
                      while ($row2 = $result2->fetch_assoc()) {
                        echo '  
                                  <tr class="odd">
                                  <td>
                                    <div class="d-flex justify-content-start align-items-center user-name">
                                      <div class="d-flex flex-wrap mt-2">
                                        <div class="avatar me-3">';
                        if (file_exists('../../assets/img/avatars/' . $row2['u_id'] . '.png')) {
                          echo '  <img src="../../assets/img/avatars/' . $row2['u_id'] . '.png" alt class="rounded-circle" />';
                        } else {
                          echo ' <div class="avatar-wrapper"> <span class="avatar-initial rounded-circle bg-label-danger">' . substr($row2['u_ente'], 0, 1) . '</span> </div>';
                        }
                        echo '</div>
                                        </div>
                                      <div class="d-flex flex-column"><span class="emp_name text-truncate">' . $row2['u_ente'] . '</span><small class="emp_post text-truncate text-muted">';
                        if ($row2['tipo'] == '2') {
                          echo '<span class="badge bg-label-secondary">Aprovechar recursos</span>';
                        } else {

                          if ($row2['id_t'] == '0') {
                            echo '<span class="badge bg-label-primary">Nueva acción</span>';
                          } else {
                            echo '<span class="badge bg-label-success">Apoyo</span>';
                          }
                        }

                        echo '</small></div>
                                    </div>
                                  </td>
                                  <td>' . $row2['nombreTarea'] . '</td>
                                  <td>' . $row2['descripcion'] . '</td>
                                  <td>
                                    <div class="d-inline-block"><a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></a>
                                      <ul class="dropdown-menu dropdown-menu-end m-0">';

                        if ($row2['tipo'] == '2') {
                          echo '<li><a href="../../back/ajax/go_operacion_solicitud.php?a=' . $row2['id'] . '" class="dropdown-item text-primary delete-record"><i class="bx bxs-user-plus me-2" ></i>Aceptar</a></li>';
                        } else {

                          if ($row2['id_t'] == '0') {
                            echo '<a class="dropdown-item pointer"  onclick="viewNewTask(\'' . $row2['u_id'] . '\', \'' . $row2['id'] . '\', \'' . $row2['u_ente'] . '\',\'' . $row2['descripcion'] . '\')"><i class="bx bx-user-plus me-1"></i> Aceptar</a>';
                          } else {
                            echo '<a class="dropdown-item pointer" onclick="addResponsable(\'' . $row2['id_t'] . '\',\'' . $row2['u_id'] . '\', \'' . $row2['id'] . '\')"><i class="bx bx-user-plus me-1"></i> Aceptar</a>';
                          }
                        }


                        echo '
                                        <div class="dropdown-divider"></div>
                                        <li><a href="../../back/ajax/go_operacion_solicitud.php?r=' . $row2['id'] . '" class="dropdown-item text-danger delete-record"><i class="bx bxs-user-x me-2" ></i>Rechazar</a></li>
                                      </ul>
                                    </div>
                                  </td>
                                </tr>';
                      }
                      echo ' </table>
                                </div>
                              </div>
                            </div>';
                    }
                    $stmt2->close();

                  ?>


                  <?php } ?>








                  <div class="card mb-3">
                    <div class="card-body">
                      <div class="card-title d-flex justify-content-between">
                        <h5>Acciones registradas</h5>
                        <?php if ($status == '0' && $modo == '1') { ?>
                          <button type="button" class="btn btn-outline-primary btn-sm" onclick="viewNewTask()">
                            <span class="tf-icons bx bx-plus"></span>&nbsp; Nueva tarea
                          </button>
                        <?php } ?>
                      </div>
                      <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                          <thead>
                            <tr>
                              <th></th>
                              <th></th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody class="table-border-bottom-0" id="tabla">
                        </table>
                      </div>
                    </div>
                  </div>


                  <?php if ($modo == '1' || $_SESSION["u_nivel"] == '1') { ?>


                    <div class="card mb-3">
                      <div class="card-body">
                        <div class="card-title d-flex justify-content-between">
                          <h5>Participaciones pendientes</h5>
                        </div>
                        <div class="table-responsive ">
                          <table class="datatables-basic table border-top dataTable no-footer dtr-column">
                            <thead>
                              <tr>
                                <th></th>
                                <th>Empresa</th>
                                <th>Responsabilidad</th>
                                <th class="text-center">Status</th>
                                <th></th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody id="involucrados_pendiente">
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>



                  <?php } ?>



                </div>



                <div class="col-lg-5">


                  <div class="card mb-3">
                    <div class="card-body">
                      <h5 class="mb-3">Estado de las tareas</h5>
                      <div class="d-flex flex-column flex-sm-row justify-content-between text-center gap-3">
                        <div class="d-flex flex-column align-items-center">
                          <span><i class="bx bx-task text-primary bx-md p-3 border border-primary rounded-circle border-dashed mb-0"></i></span>
                          <p class="mt-3 mb-2 w-75">Total de acciones ejecutas</p>
                          <h5 class="text-primary mb-0" id="tareas_listas"></h5>
                        </div>
                        <div class="d-flex flex-column align-items-center">
                          <span><i class="bx bx-task-x text-primary bx-md p-3 border border-primary rounded-circle border-dashed mb-0"></i></span>
                          <p class="mt-3 mb-2 w-75">Total de acciones pendientes</p>
                          <h5 class="text-primary mb-0" id="tareas_pendientes"></h5>
                        </div>

                      </div>
                    </div>
                  </div>














                  <?php
                  $stmt2 = mysqli_prepare($conexion, "SELECT system_users.u_id, system_users.u_ente, go_tareas_responsables.id, go_tareas_responsables.empresa_id, go_tareas_responsables.empresa, go_tareas_responsables.responsabilidad, go_tareas_responsables.fechaAsig FROM `go_tareas_responsables`
                      LEFT JOIN system_users ON system_users.u_id = go_tareas_responsables.empresa_id
                       WHERE operacion= ? ORDER BY empresa_id");
                  $stmt2->bind_param('s', $_GET["i"]);

                  $stmt2->execute();
                  $result2 = $stmt2->get_result();
                  if ($result2->num_rows > 0) {
                    echo '
                        <div class="card mb-3">
                          <h5 class="card-header">Empresas/Instituciones involucradas</h5>
                          <div class="card-body">';
                    while ($row2 = $result2->fetch_assoc()) {
                      echo '  
                                  <div class="timeline-event">
                                  <div class="timeline-header mb-2 d-flex w-100 flex-wrap align-items-center justify-content-between">
                                      <h6 class="mb-0">' . $row2['empresa'] . '</h6>
                                      <small class="text-muted">' . fechaCastellano($row2['fechaAsig']) . '</small>
                                    </div>
                                    <div class="d-flex flex-wrap mt-2">
                                      <div class="avatar me-3">';
                      if (file_exists('../../assets/img/avatars/' . $row2['u_id'] . '.png')) {
                        echo '  <img src="../../assets/img/avatars/' . $row2['u_id'] . '.png" alt class="rounded-circle" />';
                      } else {
                        echo '  <span class="avatar-initial rounded-circle bg-label-danger">' . substr($row2['u_ente'], 0, 1) . '</span>';
                      }
                      echo '
                                      </div>
                                      <div>
                                        <span>' . $row2['responsabilidad'] . '</span>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="divider">
                                    <div class="divider-text"></div>
                                  </div>';
                    }
                    echo ' </div>
                        </div>';
                  }
                  $stmt2->close();

                  ?>






                  <?php

                  $stmt2 = mysqli_prepare($conexion, "SELECT go_solicitud_union.descripcion, system_users.u_ente, system_users.u_id  FROM `go_solicitud_union`
                  LEFT JOIN system_users ON system_users.u_id = go_solicitud_union.user_1
                   WHERE operacion= ? AND status='1'");
                  $stmt2->bind_param('s', $_GET["i"]);
                  $stmt2->execute();
                  $result2 = $stmt2->get_result();
                  if ($result2->num_rows > 0) {
                    echo '
                        <div class="card mb-3">
                          <h5 class="card-header">Aprovechamiento de recursos empleados</h5>
                          <div class="card-body">';
                    while ($row2 = $result2->fetch_assoc()) {
                      echo '  
                                  <div class="timeline-event">
                                  <div class="timeline-header mb-2 d-flex w-100 flex-wrap align-items-center justify-content-between">
                                      <h6 class="mb-0">' . $row2['u_ente'] . '</h6>
                                    </div>
                                    <div class="d-flex flex-wrap mt-2">
                                      <div class="avatar me-3">';
                      if (file_exists('../../assets/img/avatars/' . $row2['u_id'] . '.png')) {
                        echo '  <img src="../../assets/img/avatars/' . $row2['u_id'] . '.png" alt class="rounded-circle" />';
                      } else {
                        echo '  <span class="avatar-initial rounded-circle bg-label-danger">' . substr($row2['u_ente'], 0, 1) . '</span>';
                      }
                      echo '
                                      </div>
                                      <div>
                                        <span>' . $row2['descripcion'] . '</span>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="divider">
                                    <div class="divider-text"></div>
                                  </div>';
                    }
                    echo ' </div>
                        </div>';
                  }
                  $stmt2->close();

                  ?>




                  <div class="card mb-3">
                    <div class="card-body">
                      <h5 class="card-title mb-3">Calendario de acciones pendientes</h5>
                      <div id="caleandar" class="mb-3"></div>
                    </div>
                  </div>
                </div>
              </div>
              <?php if ($status == '0') { ?>

                <?php if ($modo == '1') { ?>

                  <div class="row " id="vistaNtarea" style="display: none;">
                    <div class="col-lg-12">
                      <div class="card mb-3">
                        <div class="card-body">
                          <div class="d-flex  justify-content-between">

                            <h5 class="card-title">
                              Nueva acción - <small class="text-light fw-medium mb-2">Registro de acciones a realizar</small>
                            </h5>
                            <button class="btn btn-secondary btn-sm" onclick="viewNewTaskCancel()">Cancelar</button>

                          </div>


                          <div class="bs-stepper wizard-vertical vertical wizard-vertical-icons-example mt-2">
                            <div class="bs-stepper-header">
                              <div onclick="setView('view-1 ')" class="step view-1 active">
                                <button type="button" class="step-trigger" aria-selected="true">
                                  <span class="bs-stepper-circle">
                                    <i class="bx bx-detail"></i>
                                  </span>
                                  <span class="bs-stepper-label mt-1">
                                    <span class="bs-stepper-title">Detalles</span>
                                    <span class="bs-stepper-subtitle">Detalles de la tarea</span>
                                  </span>
                                </button>
                              </div>
                              <div class="line"></div>
                              <div onclick="setView('view-2 ')" class="step view-2">
                                <button type="button" class="step-trigger" aria-selected="false">
                                  <span class="bs-stepper-circle">
                                    <i class="bx bx-error"></i>
                                  </span>

                                  <span class="bs-stepper-label mt-1">
                                    <span class="bs-stepper-title">Condicionantes</span>
                                    <span class="bs-stepper-subtitle">Insumos y condiciones</span>
                                  </span>
                                </button>
                              </div>
                              <div class="line"></div>
                              <div onclick="setView('view-3 ')" class="step view-3">
                                <button type="button" class="step-trigger" aria-selected="false">
                                  <span class="bs-stepper-circle">
                                    <i class='bx bxs-user-detail'></i>
                                  </span>
                                  <span class="bs-stepper-label mt-1">
                                    <span class="bs-stepper-title">Responsables</span>
                                    <span class="bs-stepper-subtitle">Empresas involucradas</span>
                                  </span>
                                </button>
                              </div>
                              <div class="line"></div>
                              <div onclick="setView('view-4')" class="step view-4">
                                <button type="button" class="step-trigger" aria-selected="false">
                                  <span class="bs-stepper-circle">
                                    <i class='bx bxs-car'></i>
                                  </span>
                                  <span class="bs-stepper-label mt-1">
                                    <span class="bs-stepper-title">Vehículos</span>
                                    <span class="bs-stepper-subtitle">Vehículos utilizados</span>
                                  </span>
                                </button>
                              </div>


                              <div class="line"></div>
                              <div onclick="setView('view-5')" class="step view-5">
                                <button type="button" class="step-trigger" aria-selected="false">
                                  <span class="bs-stepper-circle">
                                    <i class='bx bx-current-location'></i>
                                  </span>
                                  <span class="bs-stepper-label mt-1">
                                    <span class="bs-stepper-title">Localización</span>
                                    <span class="bs-stepper-subtitle">Lugar de ejecución</span>
                                  </span>
                                </button>
                              </div>

                            </div>
                            <div class="bs-stepper-content">
                              <form onsubmit="return false">
                                <!-- Account Details -->
                                <div id="view-1" class="view-1 content active">
                                  <div class="content-header mb-3">
                                    <h6 class="mb-0">Detalles</h6>
                                    <small>Detalles de la tarea.</small>
                                  </div>
                                  <div class="row">
                                    <div class="col-sm-6">
                                      <div class="mb-3">
                                        <label for="tipo" class="form-label">Nombre de la tarea</label>
                                        <div class="input-group input-group-merge">
                                          <input onkeyup="max_caracteres(this.value, 'res_car_nombre', 'nombre_o', 60)" type="text" class="form-control" placeholder="Nombre de la operación" id="nombre_o">
                                          <span class="input-group-text" id="res_car_nombre">60</span>
                                        </div>
                                      </div>
                                      <div class="mb-3">
                                        <label for="tipo" class="form-label">Descripción de la tarea</label>
                                        <div class="input-group input-group-merge speech-to-text">
                                          <textarea onkeyup="max_caracteres(this.value, 'res_car_descripcion', 'descripcion_o', 250)" class="form-control" placeholder="Describa la operación" rows="5" id="descripcion_o"></textarea>
                                          <span class="input-group-text" id="res_car_descripcion">
                                            250
                                          </span>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-6">


                                      <div class="mb-3">
                                        <label class="form-label" for="email1">Unidad de medida</label>
                                        <select id="res_car_unidad" class="form-control" onchange="verifica(this.value)">
                                          <option value="">Seleccione</option>

                                          <?php
                                          $stmt = mysqli_prepare($conexion, "SELECT * FROM `unidades_medida` ORDER BY tipo DESC, unidad ASC");
                                          $stmt->execute();
                                          $result = $stmt->get_result();
                                          if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                              echo '<option value="' . $row['unidad'] . '">' . $row['unidad'] . '</option>';
                                            }
                                          }
                                          $stmt->close();


                                          ?>

                                          <option value="Agregar item">Agregar item</option>

                                        </select>
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label" for="email1">Tiempo de ejecución</label>
                                        <select id="res_car_tipo_ejecucion" class="form-control" onchange="tipoEjecucion(this.value)">
                                          <option value="">Seleccione</option>
                                          <option value="1">Un dia</option>
                                          <option value="3">Una semana</option>
                                          <option value="4">Un mes</option>
                                          <option value="5">Un trimestre</option>
                                          <option value="6">Un Semestre</option>
                                          <?php
                                          if ($tipo_p != '3') {
                                            echo '<option value="2">Todo el año</option>';
                                          }
                                          ?>
                                        </select>
                                      </div>

                                      <script>
                                        function tipoEjecucion(value) {
                                          $('#fecha').val('');
                                          if (value == '2') {
                                            $('#section_trimestral').show(300)
                                            $('#fechaIncioM').hide(300)
                                          } else if (value == '') {
                                            $('#section_trimestral').hide(300)
                                            $('#fechaIncioM').hide(300)
                                          } else {
                                            $('#section_trimestral').hide(300)
                                            $('#fechaIncioM').show(300)
                                          }
                                        }
                                      </script>

                                      <div class="mb-3" id="fechaIncioM" style="display: none;">
                                        <label class="form-label" for="email1">Fecha de ejecución</label>
                                        <input type="date" id="fecha" onchange=" sumarDiasYMeses(this.value)" class="form-control">
                                      </div>
                                      <script>
                                        var fechaFin = '';

                                        function sumarDiasYMeses(fecha) {

                                          let fechaActual = new Date(fecha);
                                          let fechaNueva;

                                          if ($('#res_car_tipo_ejecucion').val() == '1') {
                                            // verificar fecha junto al ano del plan
                                            fechaNueva = fecha
                                            return
                                          } else if ($('#res_car_tipo_ejecucion').val() == '3') {
                                            fechaNueva = new Date(fechaActual.getFullYear(), fechaActual.getMonth() + 1, fechaActual.getDate() + 7)
                                          } else if ($('#res_car_tipo_ejecucion').val() != '1') {
                                            var meses = 0;
                                            switch ($('#res_car_tipo_ejecucion').val()) {
                                              case '4':
                                                meses = 1;
                                                break;
                                              case '5':
                                                meses = 3;
                                                break;
                                              case '6':
                                                meses = 6;
                                                break;
                                            }
                                            fechaNueva = new Date(fechaActual.getFullYear(), fechaActual.getMonth() + meses + 1, fechaActual.getDate())
                                          }

                                          if (validateSameYear(new Date(fechaNueva), new Date(fecha)) == false) {
                                            $('#fecha').val('');
                                            fechaFin = ''
                                            toast_s('error', 'La fecha indicada no se ajusta al año en curso, verifique el tiempo de ejecución')
                                          } else {
                                            fechaFin = fechaNueva.getFullYear() + '-' + fechaNueva.getMonth() + '-' + fechaNueva.getDate()
                                          }
                                        }



                                        function validateSameYear(date1, date2) {
                                          let year1 = date1.getFullYear();
                                          let year2 = date2.getFullYear();
                                          if (year1 === year2) {
                                            return true;
                                          } else {
                                            return false;
                                          }
                                        }
                                      </script>


                                      <?php if ($tipo_p != '3') { ?>
                                        <section id="section_trimestral" class="mb-3" style="display: none;">
                                          <label class="form-label" for="email1">Meta por trimestre (I, II, III, IV)</label>
                                          <div class="row">
                                            <div class="col-lg-3">
                                              <input type="number" id="res_car_mt_1" placeholder="I" class="form-control">
                                            </div>
                                            <div class="col-lg-3">
                                              <input type="number" id="res_car_mt_2" placeholder="II" class="form-control">
                                            </div>
                                            <div class="col-lg-3">
                                              <input type="number" id="res_car_mt_3" placeholder="III" class="form-control">
                                            </div>
                                            <div class="col-lg-3">
                                              <input type="number" id="res_car_mt_4" placeholder="IV" class="form-control">
                                            </div>
                                          </div>
                                        </section>
                                      <?php } ?>
                                    </div>

                                    <div class="col-12 d-flex justify-content-between">
                                      <button class="btn btn-label-secondary btn-prev" disabled>
                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                      </button>
                                      <button class="btn btn-primary btn-next" onclick="setView('view-2')">
                                        <span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                      </button>
                                    </div>
                                  </div>
                                </div>
                                <!-- Personal Info -->
                                <div id="view-2" class="view-2 content">
                                  <div class="content-header mb-3">
                                    <h6 class="mb-0">Condicionantes</h6>
                                    <small>Insumos y condiciones.</small>
                                  </div>
                                  <div class="row g-3">
                                    <div class="col-lg-6  mb-4">
                                      <label class="form-label">Insumos necesarios</label>
                                      <div class="input-group input-group-merge">
                                        <div class="form-control d-flex" id="list-recursos" style="min-height: 54px; flex-wrap: wrap;">

                                        </div>
                                        <span class="input-group-text pointer" onclick="verM('#recursos-modal')">
                                          <i class="tf-icons bx bx-plus"></i>
                                        </span>
                                      </div>
                                    </div>
                                    <div class="col-lg-6  mb-4">
                                      <label class="form-label">Condiciones adversas</label>
                                      <div class="input-group input-group-merge">
                                        <div class="form-control d-flex" id="list-cond-adver" style="min-height: 54px; flex-wrap: wrap;">

                                        </div>
                                        <span class="input-group-text pointer" onclick="verM('#condiciones-modal')">
                                          <i class="tf-icons bx bx-plus"></i>
                                        </span>
                                      </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between">
                                      <button class="btn btn-primary btn-prev" onclick="setView('view-1')">
                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                      </button>
                                      <button class="btn btn-primary btn-next" onclick="setView('view-3')">
                                        <span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                      </button>
                                    </div>
                                  </div>
                                </div>
                                <!-- Social Links -->
                                <div id="view-3" class="view-3 content">
                                  <div class="content-header mb-3">
                                    <h6 class="mb-0">Responsables</h6>
                                    <small>Empresas involucradas.</small>
                                  </div>

                                  <div class="row">
                                    <div class="col-lg-12  mb-4">
                                      <label class="form-label">Empresas involucradas</label>
                                      <div class="input-group input-group-merge">
                                        <div class="form-control d-flex" id="list-emp-invo" style="min-height: 54px; flex-wrap: wrap;">
                                        </div>
                                        <span class="input-group-text pointer" onclick="verM('#empresa-modal')">
                                          <i class="tf-icons bx bx-plus"></i>
                                        </span>
                                      </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between">
                                      <button class="btn btn-primary btn-prev" onclick="setView('view-2')">
                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                      </button>
                                      <button class="btn btn-primary btn-next" onclick="setView('view-4')">
                                        <span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                      </button>
                                    </div>
                                  </div>
                                </div>
                                <div id="view-4" class="view-4 content ">
                                  <div class="content-header mb-3 d-flex justify-content-between">
                                    <div>
                                      <h6 class="mb-0">Vehículos</h6>
                                      <small>Vehículos utilizados.</small>
                                    </div>
                                    <div>
                                      <input id="resaltar" onkeyup="search(this.value)" type="text" class="form-control" placeholder="Buscar..." />
                                    </div>
                                  </div>




                                  <script>
                                    function setVehiculos(value) {
                                      if (value == 'Necesarios') {
                                        $('#vehiculos_si').show(300)
                                      } else {
                                        $("#condicion_vehiculos" + " option[value='']").attr("selected", true);
                                        $('#vehiculos_si').hide(300)
                                        $('#tabla-vehiculos').hide(300)
                                      }
                                    }
                                  </script>
                                  <div class="row g-3">
                                    <div class="mb-3 col-lg-6">
                                      <div>
                                        <label for="utilizacion_vehiculos" class="control-label mb-1">Utilización de vehículos</label>
                                        <select id="utilizacion_vehiculos" class="form-control" onchange="setVehiculos(this.value)">
                                          <option value="">Seleccione</option>
                                          <option value="No">No se necesitan vehículos</option>
                                          <option value="Necesarios">Se necesitan vehículos</option>
                                        </select>
                                      </div>
                                    </div>

                                    <div class="mb-3 col-lg-6">

                                      <div id="vehiculos_si" style="display: none;">
                                        <label for="condicion_vehiculos" class="control-label mb-1">Condición del medio</label>
                                        <select id="condicion_vehiculos" onchange="(this.value == 'Si' ? $('#tabla-vehiculos').show():$('#tabla-vehiculos').hide())" class="form-control">
                                          <option value="">Seleccione</option>
                                          <option value="Si">Se cuenta con el (los) vehículo (s)</option>
                                          <option value="No">No se cuenta con el (los) vehículo (s)</option>
                                        </select>
                                      </div>

                                    </div>

                                    <div class="mb-3 col-lg-12">
                                      <div class="table-responsive text-start text-nowrap" id="tabla-vehiculos" style="display: none;">
                                        <table class="table table-borderless">
                                          <thead>
                                            <tr>
                                              <th>Vehículo</th>
                                              <th class="text-center">Placa</th>
                                              <th>Tareas</th>
                                              <th></th>
                                              <th></th>
                                            </tr>
                                          </thead>
                                          <tbody id="listVehiculos">
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between">
                                      <button class="btn btn-primary btn-prev" onclick="setView('view-3')">
                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                      </button>
                                      <button class="btn btn-primary btn-next" onclick="setView('view-5')">
                                        <span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                      </button>
                                    </div>
                                  </div>
                                </div>
                                <div id="view-5" class="view-5 content">
                                  <div class="content-header mb-3">
                                    <h6 class="mb-0">Localización</h6>
                                    <small>Lugar de ejecución.</small>
                                  </div>
                                  <div class="row g-3">

                                    <div class="col-lg-6">


                                      <div class="mb-3">
                                        <label for="instancia" class="form-label">Instancia de ejecución</label>
                                        <select id="instancia" class="form-control" onchange="setInstancia(this.value)">
                                          <option value="">Seleccione</option>
                                          <option value="Estado">Estado</option>
                                          <option value="Municipio">Municipio</option>
                                          <option value="Parroquia">Parroquia</option>
                                          <option value="Comuna">Comuna</option>
                                          <option value="Comunidad">Comunidad</option>
                                        </select>
                                      </div>

                                      <script>
                                        function setInstancia(value) {
                                          if (value == '') {
                                            $('#instancia_estado').hide(300)
                                            return
                                          } else {
                                            $('#instancia_estado').show(300)
                                          }

                                          switch (value) {
                                            case 'Estado':
                                              $('#instancia_municipio').hide(300)
                                              $('#instancia_parroquia').hide(300)
                                              $('#instancia_comuna').hide(300)
                                              $('#instancia_comunidad').hide(300)
                                              break;

                                            case 'Municipio':
                                              $('#instancia_municipio').show(300)
                                              $('#instancia_parroquia').hide(300)
                                              $('#instancia_comuna').hide(300)
                                              $('#instancia_comunidad').hide(300)
                                              break;

                                            case 'Parroquia':
                                              $('#instancia_municipio').show(300)
                                              $('#instancia_parroquia').show(300)
                                              $('#instancia_comuna').hide(300)
                                              $('#instancia_comunidad').hide(300)
                                              break;
                                            case 'Comuna':
                                              $('#instancia_municipio').show(300)
                                              $('#instancia_parroquia').show(300)
                                              $('#instancia_comuna').show(300)
                                              $('#instancia_comunidad').hide(300)
                                              break;
                                            case 'Comunidad':
                                              $('#instancia_municipio').show(300)
                                              $('#instancia_parroquia').show(300)
                                              $('#instancia_comuna').show(300)
                                              $('#instancia_comunidad').show(300)

                                              break;
                                          }
                                        }
                                      </script>



                                      <div class="mb-3" id="instancia_estado" style="display: none;">
                                        <label for="estado" class="form-label">Estado</label>
                                        <select id="estado" class="form-control" onchange="setEstado(this.value)">

                                          <option value="">Seleccione</option>
                                          <?php
                                          $stmt = mysqli_prepare($conexion, "SELECT * FROM local_estados");
                                          $stmt->execute();
                                          $result = $stmt->get_result();
                                          if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                              echo '<option value="' . $row['id_estados'] . '">' . $row['t_estados'] . '</option>';
                                            }
                                          }
                                          $stmt->close();
                                          ?>
                                        </select>
                                      </div>



                                      <section id="serction_amazonas" style="display: none;">
                                        <div class="mb-3" id="instancia_municipio">
                                          <label for="municipio" class="form-label">Municipio</label>
                                          <select id="municipio" class="form-control">

                                            <option value="">Seleccione</option>
                                            <?php
                                            $stmt = mysqli_prepare($conexion, "SELECT * FROM local_municipio");
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            if ($result->num_rows > 0) {
                                              while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . $row['id_municipio'] . '">' . $row['nombre_municipio'] . '</option>';
                                              }
                                            }
                                            $stmt->close();
                                            ?>
                                          </select>
                                        </div>

                                        <div class="mb-3" id="instancia_parroquia">
                                          <label for="parroquia" class="form-label">Parroquia</label>
                                          <select id="parroquia" class="form-control" onchange="setParroquia(this.value)">
                                            <option value="">Seleccione</option>
                                          </select>
                                        </div>

                                        <section id="section_pto" style="display: none;">
                                          <div class="mb-3" id="instancia_comuna">
                                            <label for="comuna" class="form-label">Comuna</label>
                                            <select id="comuna" class="form-control">
                                              <option value="">Seleccione</option>
                                            </select>
                                          </div>

                                          <div class="mb-3" id="instancia_comunidad">
                                            <label for="comunidad" class="form-label">Comunidad</label>
                                            <select id="comunidad" class="form-control" onchange="verificarComunidad(this.value)">
                                              <option value="">Seleccione</option>
                                            </select>
                                          </div>

                                          <div class="mb-3" id="nueva_comunidad_section" style="display: none;">
                                            <label for="otra_comunidad" class="form-label">Nombre de la comunidad</label>
                                            <div class="input-group">
                                              <input type="text" class="form-control" id="otra_comunidad">
                                              <span class="input-group-text cursor-pointer" onclick="cerrarNc()"><i class="bx bx-x"></i></span>
                                            </div>
                                          </div>
                                        </section>
                                      </section>


                                      <script>
                                        function cerrarNc() {

                                          $('#otra_comunidad').val('');
                                          $("#comunidad" + " option[value='']").attr("selected", true);

                                          $('#nueva_comunidad_section').hide(300);
                                          $('#instancia_comunidad').show(300);
                                        }

                                        function verificarComunidad(value) {
                                          if (value == 'add-item') {
                                            $('#otra_comunidad').val('');

                                            $('#nueva_comunidad_section').show(300);
                                            $('#instancia_comunidad').hide(300);
                                          }
                                        }
                                      </script>


                                      <div class="mb-3" id="section_fuera_estado" style="display: none;">
                                        <label for="tipo" class="form-label">Ubicación</label>
                                        <div class="input-group input-group-merge speech-to-text">
                                          <textarea onkeyup="max_caracteres(this.value, 'res_ubicacion', 'ubicacion', 250)" class="form-control" placeholder="Describa la ubicación" rows="3" id="ubicacion"></textarea>
                                          <span class="input-group-text" id="res_ubicacion">
                                            250
                                          </span>
                                        </div>
                                      </div>




                                    </div>
                                    <div class="col-lg-6">

                                      <label for="tipo" class="form-label">Seleccione la ubicación</label>

                                      <div class="w-100" style="height: 280px;">
                                        <div id="map" class="w-100 h-100">
                                        </div>
                                      </div>

                                    </div>

                                    <div class="col-12 d-flex justify-content-between">
                                      <button class="btn btn-primary btn-prev" onclick="setView('view-4')">
                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                      </button>
                                      <button class="btn btn-success btn-submit" onclick="guardarTarea()">Guardar</button>
                                    </div>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                <?php } ?>

              <?php } ?>




              <?php if ($modo == '1' || $modo == '2') { ?>

                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel">
                  <div class="offcanvas-header">
                    <h5 id="offcanvasEndLabel" class="offcanvas-title">Interacciones</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                  </div>
                  <div class="offcanvas-body mx-0 flex-grow-0">
                    <ol class="chat">
                      <li class="chat-item">
                        <span class="chat-item-icon | avatar-icon">
                          <span class="avatar">
                            <?php
                            if (file_exists('../../assets/img/avatars/' . $_SESSION['u_id'] . '.png')) {
                              echo '  <img src="../../assets/img/avatars/' . $_SESSION['u_id'] . '.png" />';
                            } else {
                              echo '  <span class="avatar-initial rounded-circle bg-label-danger">' . substr($_SESSION['u_nombre'], 0, 1) . '</span>';
                            }
                            ?>
                          </span>
                        </span>
                        <div class="new-comment">
                          <div class="form-send-message d-flex justify-content-between align-items-center " style="box-shadow: 0 0.125rem 0.25rem rgba(161,172,184,.4);">
                            <input class="form-control message-input border-0 me-3 shadow-none" onkeyup="max_caracteres(this.value, 'empty', 'message', 250)" type="text" class="form-control" id="message" placeholder="Máximo 250 caracteres">
                            <div class="message-actions d-flex align-items-center">
                              <button class="btn btn-primary d-flex send-msg-btn" onclick="enviar()">
                                <i class="bx bx-paper-plane me-md-1 me-0"></i>
                              </button>
                            </div>
                          </div>
                        </div>
                      </li>
                      <section id="mensajes_recuperados"></section>
                    </ol>
                  </div>
                </div>
                <div class="buy-now">
                  <button id="btn-notice" onclick="setVistoMessege()" type="button" class="btn rounded-pill btn-icon btn-outline-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd" aria-controls="offcanvasEnd">
                    <i class='bx bx-comment-dots bx-tada bx-flip-horizontal'></i>
                    <span class="badge rounded-circle badge-not bg-danger text-white">4</span>
                  </button>
                </div>
                <?php } else {
                if ($status == '0') {
                  if ($_SESSION["u_nivel"] == 2 || $_SESSION["u_nivel"] == 3) {



                    $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_solicitud_union` WHERE operacion = ? AND user_1= ?");
                    $stmt->bind_param('ss', $operacion_id, $_SESSION["u_ente_id"]);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {

                        if ($row['status'] == '0') {
                          echo '<div class="buy-now" id="btn_solicitar">
                          <button type="button" class="btn rounded-pill btn-danger" onclick="cancelarSolicitud()">
                          <i class="bx bx-user-x me-2"></i> Cancelar solicitud</button>
                          </div>';
                        }
                      }
                    } else {
                      echo ' <div class="buy-now" id="btn_solicitar">
                    <button type="button" class="btn rounded-pill btn-primary" data-bs-toggle="modal" data-bs-target="#modal-solicitud">
                      <i class="bx bx-user-plus me-2"></i> Solicitar sumarse a la operación</button>
                  </div>';
                    }
                    $stmt->close();

                ?>
                    <!-- Modal -->
                    <div class="modal fade" id="modal-solicitud" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Solicitar unirse a la operación</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="mb-3">
                              <label for="tipo_solicitud" class="form-label">Tipo de solicitud</label>
                              <select id="tipo_solicitud" class="form-control" onchange="this.value == '1'? $('#solicitud_tarea_div').show(300):$('#solicitud_tarea_div').hide(300)">
                                <!-- <option value="">Seleccione</option>-->
                                <option value="2">Aprovechamiento al máximo de los recursos empleados</option>
                                <!-- <option value="1">Apoyo en la ejecución de una acción</option> -->
                              </select>
                            </div>


                            <div class="mb-3" id="solicitud_tarea_div" style="display: none;">
                              <label for="tarea_solicitud" class="form-label">Tarea</label>
                              <select id="tarea_solicitud" class="form-control">
                                <option value="">Seleccione</option>
                                <?php



                                $stmt = mysqli_prepare($conexion, "SELECT id_tarea, tarea FROM `go_tareas` WHERE id_operacion = ? AND status='0'");
                                $stmt->bind_param('s', $operacion_id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                  while ($row = $result->fetch_assoc()) {
                                    echo ' <option value="' . $row['id_tarea'] . '">' . $row['tarea'] . '</option>';
                                  }
                                }
                                ?>

                                <option value="0">Nueva tarea</option>

                              </select>
                            </div>


                            <div class="mb-3">
                              <label for="tipo" class="form-label">Detalles de la solicitud</label>
                              <div class="input-group input-group-merge speech-to-text">
                                <textarea onkeyup="max_caracteres(this.value, 'res_car_descripcion', 'descripcion_solicitud', 250)" class="form-control" placeholder="Describa su solicitud..." rows="3" id="descripcion_solicitud"></textarea>
                                <span class="input-group-text" id="res_car_descripcion">
                                  250
                                </span>
                              </div>
                            </div>



                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                              Cancelar
                            </button>
                            <button type="button" class="btn btn-primary" onclick="solicitarUnirse()">Enviar</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <script>
                      function cancelarSolicitud() {
                        $('.container-loader').show()
                        $.ajax({
                          type: 'POST',
                          url: '../../back/ajax/go_operacion_solicitud.php',
                          dataType: 'html',
                          data: {
                            t: "<?php echo $operacion_id ?>",
                            accion: 'c'
                          },
                          cache: false,
                          success: function(msg) {
                            $('.container-loader').hide()

                            location.reload();

                            $('#btn_solicitar').html(`<button type="button" class="btn rounded-pill btn-primary" data-bs-toggle="modal" data-bs-target="#modal-solicitud">
                          <i class="bx bx-user-plus me-2"></i> Solicitar sumarse a la operación</button>`)
                            toast_s('success', 'Se cancelo la solicitud correctamente.')
                          }
                        }).fail(function(jqXHR, textStatus, errorThrown) {
                          // loader cargando hide
                        });
                      }

                      function solicitarUnirse() {
                        let tipo_solicitud = $('#tipo_solicitud').val()
                        let descripcion_solicitud = $('#descripcion_solicitud').val()
                        let tarea_solicitud = $('#tarea_solicitud').val()
                        $('.container-loader').show()
                        $.ajax({
                          type: 'POST',
                          url: '../../back/ajax/go_operacion_solicitud.php',
                          dataType: 'html',
                          data: {
                            t: "<?php echo $operacion_id ?>",
                            tipo_solicitud: tipo_solicitud,
                            descripcion_solicitud: descripcion_solicitud,
                            tarea_solicitud: tarea_solicitud,
                            accion: 's'
                          },
                          cache: false,
                          success: function(msg) {
                            $('.container-loader').hide()
                            $('#modal-solicitud').modal('toggle')
                            $('#btn_solicitar').html(`  <button type="button" class="btn rounded-pill btn-danger" onclick="cancelarSolicitud()">
                          <i class="bx bx-user-x me-2"></i> Cancelar solicitud</button>`)
                            toast_s('success', 'Se envió la solicitud correctamente.')
                          }
                        }).fail(function(jqXHR, textStatus, errorThrown) {

                          $('.container-loader').hide()
                          // loader cargando hide
                        });


                      }
                    </script>


              <?php
                  }
                }
              } ?>







            </div>
            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>






      <div class="modal fade" id="nuevoItem-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalCenterTitle">Nueva Unidad</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col mb-3">
                  <label for="n-item" class="form-label">Agregar nueva unidad</label>
                  <input type="text" id="n-item" class="form-control" />
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Cerrar
              </button>
              <button type="button" class="btn btn-primary" onclick="addNewItem()">Guardar cambios</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal condiciones necesarios -->
      <div class="modal fade" id="detalles-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detalles-data">


            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary" onclick="addCondicion('ac')">Ver lugar de ejecución</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal condiciones necesarios -->

      <!-- Modal condiciones necesarios -->
      <div class="modal fade" id="condiciones-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Condiciones adversas</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class=" mb-3">
                <label for="condicion" class="form-label">Condición adversa</label>
                <input type="text" id="condicion" class="form-control" placeholder="Condiciones que puedan retrasar o hacer que la acción no se cumpla" />
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" onclick="addCondicion('ac')">Agregar</button>
              <button type="button" class="btn btn-secondary" onclick="addCondicion('af')">Agregar y finalizar</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal condiciones necesarios -->



      <!-- Modal recuros necesarios -->
      <div class="modal fade" id="recursos-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Insumos necesarios</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class=" mb-3">
                <label for="recurso_m" class="form-label">Insumo</label>
                <input type="text" id="recurso_m" class="form-control" />
              </div>
              <!--
              <div class=" mb-3">
                <label for="recurso_disp" class="form-label">Disponibilidad</label>
                <select id="recurso_disp" class="form-control">
                  <option value="1">Listo</option>
                  <option value="0">Aun no disponible</option>
                </select>
              </div>
            -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" onclick="addRecursos('ac')">Agregar</button>
              <button type="button" class="btn btn-secondary" onclick="addRecursos('af')">Agregar y finalizar</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal recuros necesarios -->


      <!-- Modal empresas involucradas -->
      <div class="modal fade" id="empresa-modal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Empresas involucradas</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class=" mb-3">
                <label for="empresas_inv_val" class="form-label">Empresa/Institución</label>
                <select id="empresas_inv_val" class="form-control">
                  <option value="">Seleccione</option>
                  <?php

                  $stmt = mysqli_prepare($conexion, "SELECT * FROM `system_users` WHERE u_nivel = '2' AND u_ente!='$_SESSION[u_ente]' AND u_id!='$empresa_id'");
                  $stmt->execute();
                  $result = $stmt->get_result();
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo '<option class="empresas_ipt" id="ipt_' . $row['u_id'] . '" value="' . $row['u_id'] . '*' . $row['u_ente'] . '">' . $row['u_ente'] . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
              <div class=" mb-3">
                <label for="empresas_inv_resp" class="form-label">Responsabilidades</label>
                <input type="text" id="empresas_inv_resp" class="form-control" placeholder="Responsabilidades en la tarea" />
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" onclick="addEmpresaResponsable('ac')">Agregar</button>
              <button type="button" class="btn btn-secondary" onclick="addEmpresaResponsable('af')">Agregar y finalizar</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal empresas involucradas -->
      <!-- Modal  -->
      <div class="modal fade" id="modal-defecto">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modal-defecto-header"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-defecto-body">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
        <!-- Modal empresas involucradas -->



        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
      </div>
      <!-- Modal  -->



      <?php if ($modo == '1') { ?>

        <!-- Modal 
      
          -->
        <div class="modal fade" id="modal-ejecutar">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Reportar ejecución de la tarea</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body row" id="reporte_tarea_body">


                <div id="resultadosAnteriores" class="col-lg-4" style="display: none;">

                  <h5 class="mb-3">Resultados anteriores</h5>
                  <div class="report-list me-3 pe-3">
                    <div class="report-list-item rounded-2 mb-4">
                      <div class="d-flex align-items-start">
                        <div class="report-list-icon shadow-sm me-2">
                          <span class="badge badge-center bg-label-primary">1</span>
                        </div>
                        <div class="d-flex  flex-wrap gap-2">
                          <div class="d-flex flex-column me-3">
                            <span>1er Trimestre</span>
                            <h5 class="mb-0" id="rslt_t1"></h5>
                          </div>
                          <small class="text-success" id="meta_t1"></small>
                        </div>
                      </div>
                    </div>
                    <div class="report-list-item rounded-2 mb-4">
                      <div class="d-flex align-items-start">
                        <div class="report-list-icon shadow-sm me-2">
                          <span class="badge badge-center bg-label-primary">2</span>

                        </div>
                        <div class="d-flex  flex-wrap gap-2">
                          <div class="d-flex flex-column me-3">
                            <span>2do Trimestre</span>
                            <h5 class="mb-0" id="rslt_t2"></h5>
                          </div>
                          <small class="text-danger" id="meta_t2"></small>
                        </div>
                      </div>
                    </div>
                    <div class="report-list-item rounded-2 mb-4">
                      <div class="d-flex align-items-start">
                        <div class="report-list-icon shadow-sm me-2">
                          <span class="badge badge-center bg-label-primary">3</span>

                        </div>
                        <div class="d-flex  flex-wrap gap-2">
                          <div class="d-flex flex-column me-3">
                            <span>3er Trimestre</span>
                            <h5 class="mb-0" id="rslt_t3"></h5>
                          </div>
                          <small class="text-success" id="meta_t3"></small>
                        </div>
                      </div>
                    </div>
                    <div class="report-list-item rounded-2 mb-4">
                      <div class="d-flex align-items-start">
                        <div class="report-list-icon shadow-sm me-2">
                          <span class="badge badge-center bg-label-primary">4</span>

                        </div>
                        <div class="d-flex  flex-wrap gap-2">
                          <div class="d-flex flex-column me-3">
                            <span>4to Trimestre</span>
                            <h5 class="mb-0" id="rslt_t4"></h5>
                          </div>
                          <small class="text-success" id="meta_t4"></small>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>


                <style>
                  .bsg {
                    border-left: 1px solid lightgray;
                    padding-left: 1.5rem;
                  }
                </style>
                <div class="col-lg-8 bsg" id="vista_datos_registro">
                  <form enctype="multipart/form-data" id="filesForm" method="post">
                    <input type="text" id="registro" name="registro" hidden>
                    <div class="mb-3" id="section_trimestre">
                      <label for="rslt_trimestre" class="form-label">Seleccione el trimestre</label>
                      <select type="number" name="rslt_trimestre" id="rslt_trimestre" class="form-control">
                        <option value="">Seleccionar</option>
                        <option value="1">Trimestre 1</option>
                        <option value="2">Trimestre 2</option>
                        <option value="3">Trimestre 3</option>
                        <option value="4">Trimestre 4</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="rslt_cantidad" id="label_unidad" class="form-label"></label>
                      <input type="number" name="rslt_cantidad" id="rslt_cantidad" class="form-control">
                    </div>
                    <div class="mb-3">
                      <label for="photos" class="form-label">Reseña fotográfica</label>
                      <div class="input-group">
                        <input type="file" class="form-control" name="file[]" multiple accept=".jpg, .png" id="photos">
                        <label class="input-group-text" for="inputGroupFile02"><i class="bx bx-upload"></i></label>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="rslt_personas" class="form-label">Cantidad de personas atendidas</label>
                      <input type="number" name="rslt_personas" id="rslt_personas" value="0" class="form-control">
                    </div>
                    <div class="mb-3">
                      <label for="rslt_comunidades" class="form-label">Cantidad de comunidades atendidas</label>
                      <input type="number" name="rslt_comunidades" id="rslt_comunidades" value="0" class="form-control">
                    </div>
                    <div class="mb-3">
                      <label for="rslt_comunas" class="form-label">Cantidad de comunas atendidas</label>
                      <input type="number" name="rslt_comunas" id="rslt_comunas" value="0" class="form-control">
                    </div>

                    <div class="modal-footer">
                      <a class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</a>
                      <input type="submit" class="btn btn-primary" onclick="cerrarTarea()" value="Enviar">
                    </div>


                  </form>
                </div>
              </div>
            </div>
          </div>


          <!-- Overlay -->
          <div class="layout-overlay layout-menu-toggle"></div>
        </div>


        <div class="modal fade" id="add_post_responsables_modal" data-bs-backdrop="static" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Agregar otra empresa involucrada</h5>
                <button type="button" class="btn-close" onclick="cerrarModalAddResp()"></button>
              </div>
              <div class="modal-body row">

                <div class="mb-3" id="">
                  <label for="add_post_responsables" class="form-label">Seleccione la empresa</label>
                  <select id="add_post_responsables" class="form-control">
                    <option value="">Seleccionar</option>
                  </select>
                </div>
                <div class="mb-3" id="">
                  <label for="add_post_responsabilidad" class="form-label">Indique la responsabilidad</label>
                  <input id="add_post_responsabilidad" class="form-control" type="text">
                  <input id="add_post_id" hidden type="text">
                </div>


                <div class="modal-footer">
                  <a class="btn btn-outline-secondary" onclick="cerrarModalAddResp()">Cerrar</a>
                  <input type="submit" class="btn btn-primary" onclick="addPostResponsable()" value="Enviar">
                </div>
              </div>
            </div>
          </div>


          <!-- Overlay -->
          <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- Modal  -->



        <div id="loaderMesg">
          <div aria-labelledby="swal2-title" aria-describedby="swal2-html-container" class="swal2-popup swal2-toast swal2-icon-success swal2-show" tabindex="-1" role="alert" aria-live="polite" style="width: 300px; display: flex;">
            <div class="loaderMsg"></div>
            <h2 class="swal2-title" style="flex-wrap: nowrap">Actualizando mensajes</h2>
          </div>
        </div>




      <?php } ?>



      <?php if ($_SESSION["op_c"] == 1) { ?>

        <div class="cerrado" style="position: fixed; z-index: 9999; bottom: 0; margin: 15px">
          <button class="btn rounded-pill btn-danger">
            El plan al que pertenece esta operacion, esta cerrado.
          </button>
        </div>


      <?php  } ?>







      <!-- / Layout wrapper -->
      <?php require('../includes/alerts.html'); ?>
      <!-- Core JS -->
      <!-- build:js assets/vendor/js/core.js -->
      <script src="../../assets/vendor/libs/popper/popper.js"></script>
      <script src="../../assets/vendor/js/bootstrap.js"></script>
      <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
      <script src="../../assets/vendor/js/menu.js"></script>
      <script src="../../assets/js/main.js"></script>
      <script src="../../assets/js/ui-popover.js"></script>
      <script type="text/javascript" src="../../assets/vendor/calendar/caleandar.js"></script>

      <?php if ($status == '0' && $modo == '1') { ?>
        <script type="text/javascript" src="../../assets/js/mapa_n_tarea.js"></script>
      <?php } ?>
  </body>


  <script>
    <?php if ($status == '0' && $modo == '1') { ?>

      let estado_coords = {
        '23': '10.066339, -71.748222',
        '13': '10.191128, -69.763293',
        '11': '11.149074, -69.709341',
        '20': '7.985802, -72.071830',
        '14': '8.639568, -71.248777',
        '21': '9.440274, -70.538491',
        '18': '9.136696, -69.315733',
        '09': '9.429249, -68.365168',
        '06': '8.259955, -69.720057',
        '12': '8.853218, -66.498971',
        '04': '7.315931, -68.937931',
        '22': '10.340676, -68.725357',
        '08': '10.187798, -68.025907',
        '05': '10.034920, -67.193872',
        '01': '10.475818, -66.985209',
        '15': '10.307045, -66.444294',
        '24': '10.580305, -66.798019',
        '16': '9.617985, -63.130043',
        '03': '9.219595, -64.411891',
        '19': '10.526267, -63.248620',
        '10': '9.036857, -61.439642',
        '07': '6.544720, -63.508121',
        '02': '5.65, -67.6',
        '17': '10.984371, -64.032034'
      }

      function setEstado(value) {

        let cords = estado_coords[value].split(', ')

        map.invalidateSize()

        map.flyTo([cords[0], cords[1]], 14, {
          animate: true,
          duration: 1.5
        });


        if (value == '02') {
          $('#serction_amazonas').show(300)
          $('#section_fuera_estado').hide()
        } else {
          $('#serction_amazonas').hide()
          $('#section_fuera_estado').show(300)
        }
      }

      function setParroquia(value) {
        if (value == '020302' || value == '020301' || value == '020303' || value == '020304') {
          $('#section_pto').show(300)
          $('#section_fuera_estado').hide()
        } else {
          $('#section_pto').hide()
          $('#section_fuera_estado').show(300)
        }
      }





    <?php } ?>






    /* calendario */

    var settings = {};
    var calendar_div = document.getElementById('caleandar');

    function uptate_calendar() {
      $.get("../../back/ajax/go_sectores_calendar.php", "i=" + "<?php echo $operacion_id ?>", function(data) {
        let result = data.split('*')
        var events = [];
        result.forEach(element => {
          if (element != '') {
            let items = element.split('~')
            let fecha = items[1].split('-')
            let index = fecha[1] - 1;
            events.push({
              'Date': new Date(fecha[0], index, fecha[2]),
              'Title': items[0],
              'Link': 'go_tarea.php?t=' + items[2]
            })
          }
        });
        caleandar(calendar_div, events, settings);

      });
    }
    uptate_calendar()
    /* calendario */
    var medios_utilizados = []



    function getMedios(empresas = null, fecha = null) {
      $('.container-loader').show()
      $.get("../../back/ajax/go_operacion_get_medios.php", "e=" + empresas + "&fecha=" + fecha + '&op=<?php echo $_GET["i"] ?>', function(data) {
        $('#listVehiculos').html(data)
        medios_utilizados = []
        $('.container-loader').hide()
      });
    }

    getMedios()


    function detallesTarea(id) {
      $('.container-loader').show()
      $.get("../../back/ajax/go_operacion_nueva_tarea_detalles_tarea.php", "t=" + id, function(data) {
        $('#detalles-data').html(data)
        $('.container-loader').hide()
        $('#detalles-modal').modal('toggle')
      });
    }


    var empresasinvs = [];
    var recursosDisponibles = [];
    var condicionesAdversas = [];

    /* DETALLES RESPONSABILIDADES*/
    function verDetallesResponsabilidad(id) {
      $('.container-loader').show()
      $.get("../../back/ajax/go_sectores_detalles_responsabilidad.php", "r=" + id, function(data) {
        $('.container-loader').hide()
        $('#modal-defecto').modal('toggle')
        $('#modal-defecto-body').html(data)
        $('#modal-defecto-header').html('Responsabilidad de la empresa')
      });
    }
    /* DETALLES RESPONSABILIDADES*/
    /* TABLA TAREA*/
    function tabla() {
      var tarea = "<?php echo $operacion_id ?>"
      $('.container-loader').show()
      $.get("../../back/ajax/go_operacion_tabla_tareas.php", "i=" + tarea + "&m=" + "<?php echo $modo ?>", function(data) {

        $('.container-loader').hide()
        let result = data.split('~')

        $('#tareas_pendientes').html(result[0])
        $('#tareas_listas').html(result[1])

        $('#tabla').html(result[2])
      });


      var v = "<?php echo $operacion_id ?>"
      $.get("../../back/ajax/go_operacion_involucrados_pendiente.php", "i=" + tarea + "&v=<?php echo $v ?>", function(data) {
        $('#involucrados_pendiente').html(data)
      });


    }
    tabla()


    <?php if ($modo == '1' || $modo == '2') { ?>

      function setVistoMessege() {
        let t = "<?php echo $operacion_id ?>"
        $('.container-loader').show()
        $.get("../../back/ajax/go_operacion_views_mensajes.php", "i=" + t, function(data) {
          $('.container-loader').hide()
          $('#btn-notice').html('<i class="bx bx-comment-dots"></i>')
        });
      }

      function enviar() {
        let t = "<?php echo $operacion_id ?>"
        let message = $('#message').val()
        $('.container-loader').show()
        $.ajax({
          type: 'POST',
          url: '../../back/ajax/go_operacion_send_mensajes.php',
          dataType: 'html',
          data: {
            t: t,
            message: message,
            p: '0',
            ty: 'i'
          },
          cache: false,
          success: function(msg) {
            $('.container-loader').hide()

            mensajes()
            $('#message').val('')
          }
        }).fail(function(jqXHR, textStatus, errorThrown) {
          // loader cargando hide
          $('.container-loader').hide()
        });
      }


      function mensajes() {
        let t = "<?php echo $operacion_id ?>"
        $('.container-loader').show()
        $('#loaderMesg').show()
        $.ajax({
          type: 'POST',
          url: '../../back/ajax/go_operacion_mensajes.php',
          dataType: 'html',
          data: {
            t: t
          },
          cache: false,
          success: function(msg) {

            $('.container-loader').hide()
            let result = msg.split('~')

            $('#mensajes_recuperados').html(result[1])

            if (result[0] == '0') {

              $('#btn-notice').html(' <i class="bx bx-comment-dots"></i>')
            } else {
              $('#btn-notice').html(` <i class='bx bx-comment-dots bx-tada bx-flip-horizontal'></i>
                    <span class="badge rounded-circle badge-not bg-danger text-white">` + result[0] + `</span>`)
            }


            $('#loaderMesg').hide()



          }
        }).fail(function(jqXHR, textStatus, errorThrown) {
          $('#loaderMesg').hide()
          toast_s('warning', 'Fallo al actualizar, revise su conexión.')

          $('.container-loader').hide()
        });
      }

      mensajes()


      setInterval(function() {
        mensajes();
      }, 60000);



    <?php } ?>

    sessionStorage.solicitud = 0;

    function cerrarModalAddResp() {
      sessionStorage.solicitud = 0;
      $('#add_post_responsables_modal').modal('toggle')
    }
    <?php if ($status == '0') { ?>

      <?php if ($modo == '1') { ?>

        function addResponsable(id, user, solicitud) {
          $('.container-loader').show()
          $.get("../../back/ajax/go_operacion_select_responsable.php", "i=" + id, function(data) {
            $('#add_post_responsables').html(data)
            $('.container-loader').hide()
            $('#add_post_id').val(id)
            $('#add_post_responsables_modal').modal('toggle')

            if (user) {
              sessionStorage.solicitud = solicitud;
              $("#add_post_responsables" + " option[value='" + user + "']").attr("selected", true);
            } else {
              sessionStorage.solicitud = 0;
            }
          });
        }


        function addPostResponsable() {
          let add_post_responsables = $('#add_post_responsables').val()
          let add_post_responsabilidad = $('#add_post_responsabilidad').val()
          let add_post_id = $('#add_post_id').val()
          $('.container-loader').show()
          $.ajax({
            type: 'POST',
            url: '../../back/ajax/go_operacion_nuevo_responsable.php',
            dataType: 'html',
            data: {
              add_post_responsables: add_post_responsables,
              add_post_responsabilidad: add_post_responsabilidad,
              add_post_id: add_post_id
            },
            cache: false,
            success: function(msg) {
              $('.container-loader').hide()

              $('#add_post_responsables_modal').modal('toggle')

              if (sessionStorage.solicitud != 0) {
                // se procede a aceptar la solicicud
                location.href = "../../back/ajax/go_operacion_solicitud.php?a=" + sessionStorage.solicitud;
              } else {
                tabla()
                toast_s('success', 'Se agregó correctamente')
              }

            }
          }).fail(function(jqXHR, textStatus, errorThrown) {
            toast_s('warning', 'Ocurrió un error, inténtelo nuevamente ' + errorThrown)
          });


        }


        function reenviar(id) {
          $('.container-loader').show()
          $.get("../../back/ajax/go_operacion_reenviar_notificacion.php", "i=" + id, function(data) {
            $('.container-loader').hide()
            tabla()
            toast_s('success', 'Se ha reenviado la notificación')
          });
        }

        function ejecutado(id) {
          $(".container-loader").show();

          $.ajax({
            type: 'POST',
            url: '../../back/ajax/go_operacion_api_tarea.php',
            dataType: 'html',
            data: {
              tarea: id
            },
            cache: false,
            success: function(msg) {



              $('#registro').val(id)
              let resultado = msg.trim().split('*')
              $('#label_unidad').html(resultado[1])


              if (resultado[0] == '2') {
                $('#resultadosAnteriores').show()

                $('#rslt_trimestre').html(resultado[2])
                let rslt_trimestres = resultado[3].split('/')
                $('#rslt_t1').html((rslt_trimestres[0] == '' ? 'Pendiente' : rslt_trimestres[0] + ' <small>(' + resultado[1] + ')</small>'))
                $('#rslt_t2').html((rslt_trimestres[1] == '' ? 'Pendiente' : rslt_trimestres[1] + ' <small>(' + resultado[1] + ')</small>'))
                $('#rslt_t3').html((rslt_trimestres[2] == '' ? 'Pendiente' : rslt_trimestres[2] + ' <small>(' + resultado[1] + ')</small>'))
                $('#rslt_t4').html((rslt_trimestres[3] == '' ? 'Pendiente' : rslt_trimestres[3] + ' <small>(' + resultado[1] + ')</small>'))
                let metas_trimestres = resultado[4].split('/')


                if (rslt_trimestres[0] != '') {
                  let p = rslt_trimestres[0] * 100 / metas_trimestres[0]
                  if (p == 100) {

                    $('#meta_t1').removeClass('text-danger')
                    $('#meta_t1').addClass('text-success')
                  }
                  $('#meta_t1').html(p + '% de la meta')


                }

                if (rslt_trimestres[1] != '') {
                  let p = rslt_trimestres[1] * 100 / metas_trimestres[1]
                  if (p == 100) {

                    $('#meta_t2').removeClass('text-danger')
                    $('#meta_t2').addClass('text-success')
                  }
                  $('#meta_t2').html(p + '%')
                }
                if (rslt_trimestres[2] != '') {
                  let p = rslt_trimestres[2] * 100 / metas_trimestres[2]
                  if (p == 100) {

                    $('#meta_t3').removeClass('text-danger')
                    $('#meta_t3').addClass('text-success')
                  }
                  $('#meta_t3').html(p + '%')
                }
                if (rslt_trimestres[3] != '') {
                  let p = rslt_trimestres[3] * 100 / metas_trimestres[3]
                  if (p == 100) {

                    $('#meta_t4').removeClass('text-danger')
                    $('#meta_t4').addClass('text-success')
                  }
                  $('#meta_t4').html(p + '%')
                }

                $('#vista_datos_registro').removeClass('col-lg-12')
                $('#vista_datos_registro').addClass('col-lg-8')
                $('#vista_datos_registro').addClass('bsg')
                $('#section_trimestre').show()

              } else {
                $('#vista_datos_registro').removeClass('bsg')
                $('#vista_datos_registro').removeClass('col-lg-8')
                $('#vista_datos_registro').addClass('col-lg-12')
                $('#resultadosAnteriores').hide()
                $('#section_trimestre').hide()
              }

              $(".container-loader").hide();
              $('#modal-ejecutar').modal('toggle')
            }
          }).fail(function(jqXHR, textStatus, errorThrown) {
            $(".container-loader").hide();

            toast_s('warning', 'Ocurrió un error, inténtelo nuevamente ' + errorThrown)
          });




        }

        /* SEND FORMULARIO */

        $(document).ready(function(e) {
          $("#filesForm").on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $('.container-loader').show()
            $.ajax({
              type: 'POST',
              url: '../../back/ajax/go_operaciones_reporteTarea.php',
              data: formData,
              contentType: false,
              cache: false,
              processData: false,
              success: function(msg) {
                $('.container-loader').hide()
                if (msg.trim()) {
                  toast_s('success', 'Actualizado correctamente.')
                  location.reload();
                } else {
                  alert(msg)
                }
              }
            }).fail(function(jqXHR, textStatus, errorThrown) {
              alert('Uncaught Error: ' + jqXHR.responseText);
            });

          });
        }); // REPORTAR EJECUCION DE LA TAREA

        function verifica(value) {
          if (value == 'Agregar item') {
            $('#nuevoItem-modal').modal('toggle')
          }
        }

        function addNewItem() {
          if ($('#nitem').val() != '') {
            let nitem = $('#n-item').val()

            $(".container-loader").show();
            $('.container-loader').show()
            $.get("../../back/ajax/go_operacion_n_unidad.php", "nitem=" + nitem, function(data) {
              $('.container-loader').hide()
              if (data.trim() == 'ye') {

                toast_s('error', 'La unidad de medida ya existe')
              } else {
                $('#res_car_unidad').html('<option value="">Seleccione</option>')
                $('#res_car_unidad').append(data)
                $('#res_car_unidad').append('<option value="Agregar item">Agregar item</option>')
              }

              $("#res_car_unidad" + " option[value='" + nitem + "']").attr("selected", true);

              $('#n-item').val('')
              $('#nuevoItem-modal').modal('toggle')
              $(".container-loader").hide();

            });
          }
        }
        /*
        viewNewTask(\''.$row2['id_t'].'\',\''.$row2['u_id'].'\', \''.$row2['id'].'\')"><i class="bx bx-user-plus me-1"></i> Aceptar</a>';

        */


        sessionStorage.solicitud_n = 0;
        sessionStorage.user_n = 0;
        sessionStorage.nameUser = 0;
        sessionStorage.respo = 0;


        /* TABLA TAREA*/
        function viewNewTask(user, solicitud_n, nameUser, respo) {
          map.invalidateSize()

          $('#vistaNtarea').toggle();
          $('#vistaPrincipal').toggle()
          map.invalidateSize()

          if (solicitud_n) {
            sessionStorage.solicitud_n = solicitud_n;
            sessionStorage.user_n = user;
            sessionStorage.nameUser = nameUser;
            sessionStorage.respo = respo;
            addEmpresaResponsable('ac', 'modo2')

          } else {
            sessionStorage.solicitud_n = 0;
            sessionStorage.user_n = 0;
            sessionStorage.nameUser = 0;
            sessionStorage.respo = 0;
          }

        } // cambiar campos tareas con next


        function viewNewTaskCancel() {
          sessionStorage.solicitud_n = 0;
          sessionStorage.user_n = 0;
          sessionStorage.nameUser = 0;
          sessionStorage.respo = 0;
          $('#vistaNtarea').toggle();
          $('#vistaPrincipal').toggle()
          map.invalidateSize()

        }


        /* AGREGAR TAREA*/
        function guardarTarea() {

          let ubicacion = $('#ubicacion').val()
          let estado = $('#estado').val()
          let municipio = $('#municipio').val()
          let parroquia = $('#parroquia').val()
          let comuna = $('#comuna').val()
          let comunidad = $('#comunidad').val()
          let otra_comunidad = $('#otra_comunidad').val()

          let res_car_nombre = $('#nombre_o').val()
          let res_car_descripcion = $('#descripcion_o').val()
          let fecha = $('#fecha').val()
          let r_empresasinvs = '';
          let r_recursosDisponibles = '';
          let r_condicionesAdversas = '';

          let res_car_unidad = $('#res_car_unidad').val();
          let res_car_tipo_ejecucion = $('#res_car_tipo_ejecucion').val();
          let res_car_mt_1 = $('#res_car_mt_1').val();
          let res_car_mt_2 = $('#res_car_mt_2').val();
          let res_car_mt_3 = $('#res_car_mt_3').val();
          let res_car_mt_4 = $('#res_car_mt_4').val();
          let instancia = $('#instancia').val();

          let vehic = $('#utilizacion_vehiculos').val()
          let condicion_vehiculos = $('#condicion_vehiculos').val()

          let r_vehiculos = []
          medios_utilizados.forEach(element => {
            r_vehiculos.push(element);
          });


          let claves_recursos = Object.keys(recursosDisponibles)
          for (let index = 0; index < claves_recursos.length; index++) {
            let element = recursosDisponibles[claves_recursos[index]];
            r_recursosDisponibles += element[0] + '*' + element[1] + '/';
          }

          let claves_empresas = Object.keys(empresasinvs)
          for (let index = 0; index < claves_empresas.length; index++) {
            let element = empresasinvs[claves_empresas[index]];
            r_empresasinvs += element[0] + '*' + element[1] + '*' + element[2] + '/';
          }

          let claves_condiciones = Object.keys(condicionesAdversas)
          for (let index = 0; index < claves_condiciones.length; index++) {
            let element = condicionesAdversas[claves_condiciones[index]];
            r_condicionesAdversas += element[0] + '/';
          }

          /* VERIFICAR SI EXISTEN MARCADORES EN DRAW */
          if (JSON.stringify(drawnItems.toGeoJSON()) == '{"type":"FeatureCollection","features":[]}') {
            toast_s('warning', 'Error: Indique al menos una ubicación en el mapa');
            return;
          }
          /* VERIFICAR SI EXISTEN MARCADORES EN DRAW */


          if (vehic == '') {
            toast_s('warning', 'Error: campos vacíos - Utilización de vehículos');
            return;
          }

          if (vehic == 'Necesarios' && condicion_vehiculos == '') {
            toast_s('warning', 'Error: campos vacíos - Condición de los vehículos');
            return;
          }

          if (vehic == 'Necesarios' && condicion_vehiculos == 'Si') {
            if (r_vehiculos.toString() == '') {
              toast_s('warning', 'Error: Seleccione el (los) vehículo (s) utilizado (s)');
              return;
            }
          }
          if (res_car_nombre == '') {
            toast_s('warning', 'Error: campos vacíos - Nombre');
            return;
          }
          if (res_car_descripcion == '') {
            toast_s('warning', 'Error: campos vacíos - Descripción');
            return;
          }
          if (instancia == '') {
            toast_s('warning', 'Error: campos vacíos - Instancia de ejecución');
            return;
          }
          if (estado == '') {
            toast_s('warning', 'Error: campos vacíos - Estado');
            return;
          }
          if (comunidad == 'add-item') {
            if (otra_comunidad == '') {
              toast_s('warning', 'Error: campos vacíos - Nombre de la comunidad');
              return;
            }
          }


          if (estado != '02') {
            if (ubicacion == '') {
              toast_s('warning', 'Error: campos vacíos - Ubicación');
              return;
            }
          } else {

            if (instancia == 'Municipio') {
              if (municipio == '') {
                toast_s('warning', 'Error: campos vacíos - Estado');
                return;
              }
            }

            if (instancia == 'Parroquia') {
              if (municipio == '') {
                toast_s('warning', 'Error: campos vacíos - Estado');
                return;
              }
              if (parroquia == '') {
                toast_s('warning', 'Error: campos vacíos - Estado');
                return;
              }
            }

            if (parroquia == '020302' || parroquia == '020301' || parroquia == '020303' || parroquia == '020304') {
              if (instancia == 'Comuna') {
                if (municipio == '') {
                  toast_s('warning', 'Error: campos vacíos - Estado');
                  return;
                }
                if (parroquia == '') {
                  toast_s('warning', 'Error: campos vacíos - Estado');
                  return;
                }
                if (comuna == '') {
                  toast_s('warning', 'Error: campos vacíos - Estado');
                  return;
                }
              }

              if (instancia == 'Comunidad') {
                if (municipio == '') {
                  toast_s('warning', 'Error: campos vacíos - Estado');
                  return;
                }
                if (parroquia == '') {
                  toast_s('warning', 'Error: campos vacíos - Estado');
                  return;
                }
                if (comuna == '') {
                  toast_s('warning', 'Error: campos vacíos - Estado');
                  return;
                }
                if (comunidad == '') {
                  toast_s('warning', 'Error: campos vacíos - Estado');
                  return;
                }
              }

            } else {

              if (ubicacion == '' && estado != '02') {
                toast_s('warning', 'Error: campos vacíos - Ubicación');
                return;
              }
            }

          }



          if (r_recursosDisponibles == '') {
            toast_s('warning', 'Error: campos vacíos - Insumos necesarios');
            return;
          }

          if (res_car_unidad == '') {
            toast_s('warning', 'Error: campos vacíos - Unidad de medida');
            return;
          }

          if (res_car_tipo_ejecucion == '') {
            toast_s('warning', 'Error: campos vacíos - Tipo de ejecución');
            return;
          }


          if (res_car_tipo_ejecucion != '2' && fecha == '') {
            toast_s('warning', 'Error: campos vacíos - Fecha');
            return;
          }


          if (res_car_tipo_ejecucion == '2') {


            if (res_car_mt_1 == '') {
              toast_s('warning', 'Error: campos vacíos - Meta del trimestre 1');
              return;
            }
            if (res_car_mt_2 == '') {
              toast_s('warning', 'Error: campos vacíos - Meta del trimestre 2');
              return;
            }
            if (res_car_mt_3 == '') {
              toast_s('warning', 'Error: campos vacíos - Meta del trimestre 3');
              return;
            }
            if (res_car_mt_4 == '') {
              toast_s('warning', 'Error: campos vacíos - Meta del trimestre 4');
              return;
            }
          }

          var valorN = sessionStorage.solicitud_n
          $(".container-loader").show();

          $.ajax({
            type: 'POST',
            url: '../../back/ajax/go_operacion_nueva_tarea.php',
            dataType: 'html',
            data: {
              ubicacion: ubicacion,
              mapInfo: JSON.stringify(drawnItems.toGeoJSON()),
              res_car_nombre: res_car_nombre,
              res_car_descripcion: res_car_descripcion,
              fecha: fecha,
              empresasinvs: r_empresasinvs,
              recursosDisponibles: r_recursosDisponibles,
              condicionesAdversas: r_condicionesAdversas,
              i: "<?php echo $_GET["i"] ?>",
              res_car_unidad: res_car_unidad,
              res_car_tipo_ejecucion: res_car_tipo_ejecucion,
              res_car_mt_1: res_car_mt_1,
              res_car_mt_2: res_car_mt_2,
              res_car_mt_3: res_car_mt_3,
              res_car_mt_4: res_car_mt_4,
              user_n: sessionStorage.user_n,
              vehiculos: vehic,
              condicion_vehiculos: condicion_vehiculos,
              r_vehiculos: r_vehiculos.toString(),
              fechaFin: fechaFin,
              estado: estado,
              municipio: municipio,
              parroquia: parroquia,
              comuna: comuna,
              comunidad: comunidad,
              instancia: instancia,
              otra_comunidad,
              otra_comunidad

            },
            cache: false,
            success: function(msg) {

              $(".container-loader").hide();

              if (msg.trim() == 'ok') {
                $('.empresas_ipt').show()
                r_vehiculos = []
                //tabla()
                //viewNewTask()
                $('.form-control').val('')
              } else {
                toast_s('warning', 'Error: algo salio mal' + msg)
              }
              sessionStorage.solicitud_n = 0;
              sessionStorage.user_n = 0;
              sessionStorage.nameUser = 0;
              sessionStorage.respo = 0;
              if (valorN != 0) {
                // se procede a aceptar la solicicud
                location.href = "../../back/ajax/go_operacion_solicitud.php?a=" + valorN;
              } else {



                Swal.fire({
                  title: "<strong>Éxito</strong>",
                  icon: "success",
                  html: `La tarea se registro con éxito, es necesario actualizar la pagina.`,
                  confirmButtonColor: "#69a5ff",
                  confirmButtonText: `Ok`,
                }).then((result) => {
                  location.reload();
                });



              }
            }
          }).fail(function(jqXHR, textStatus, errorThrown) {
            $(".container-loader").hide();

            toast_s('warning', 'Ocurrió un error, inténtelo nuevamente ' + errorThrown)
          });
        }
        /* AGREGAR TAREA*/
        function setView(view) {
          $('.content').removeClass('active')
          $('.step').removeClass('active')
          $('.' + view).addClass('active')
        } // cambiar campo tarea
        /* Agregar y quitar empresas involucradas */
        function addEmpresaResponsable(accion, modo2) {
          let empresas_inv_id
          let empresas_inv_val
          let empresas_inv_resp
          if (modo2) {
            empresas_inv_id = sessionStorage.user_n
            empresas_inv_val = sessionStorage.nameUser
            empresas_inv_resp = sessionStorage.respo
          } else {
            empresas_inv_id = $('#empresas_inv_val').val().split('*')[0]
            empresas_inv_val = $('#empresas_inv_val').val().split('*')[1]
            empresas_inv_resp = $('#empresas_inv_resp').val()
          }
          if (empresas_inv_val == '' || empresas_inv_resp == '') {
            toast_s('warning', 'Error: campos vacíos')
            return;
          }
          $('#empresas_inv_id').attr('disabled', true)
          $('button').attr('disabled', true)
          $('#ipt_' + empresas_inv_id).hide()
          empresasinvs[empresas_inv_id] = [
            empresas_inv_id,
            empresas_inv_val,
            empresas_inv_resp
          ]

          $('#list-emp-invo').html('')
          let claves = Object.keys(empresasinvs)

          getMedios(claves, $('#fecha').val());

          for (let index = 0; index < claves.length; index++) {
            let element = empresasinvs[claves[index]];
            $('#list-emp-invo').append(`
          <tag class="tagify__tag d-flex justify-content-between" style="padding: 2px 8px;min-width: 22%">
            <div >
              <div class="tagify__tag__avatar-wrap m--4">
                <img onerror="this.style.visibility='hidden'" width="20px" src="../../assets/img/avatars/` + element[0] + `.png">
              </div>
              <span class="tagify__tag-text">` + element[1] + `</span>
            </div>
           <i onclick="quitarEmpresa('` + element[0] + `')" class="bx bx-trash-alt cursor" style="font-size: 12px;"></i>
          </tag> `)
          }
          $('button').attr('disabled', false)
          $('#empresas_inv_val').val('')
          $('#empresas_inv_resp').val('')
          toast_s('success', 'Agregado correctamente.')
          if (accion == 'af') {
            $('#empresa-modal').modal('toggle')
          }
        }

        function quitarEmpresa(id) {

          delete empresasinvs[id];

          $('#list-emp-invo').html('')
          let claves = Object.keys(empresasinvs)


          getMedios(claves);
          for (let index = 0; index < claves.length; index++) {
            let element = empresasinvs[claves[index]];
            $('#list-emp-invo').append(`
                <tag class="tagify__tag d-flex justify-content-between"  style="padding: 2px 8px;min-width: 22%">
                  <div >
                    <div class="tagify__tag__avatar-wrap m--4">
                      <img onerror="this.style.visibility='hidden'" width="20px" src="../../assets/img/avatars/` + element[0] + `.png">
                    </div>
                    <span class="tagify__tag-text">` + element[1] + `</span>
                  </div>
                 <i onclick="quitarEmpresa('` + element[0] + `')" class="bx bx-trash-alt cursor" style="font-size: 12px;"></i>
                </tag> `)
          }

          $('#ipt_' + id).show()

          toast_s('success', 'Se eliminó correctamente.')
        }


        /* AGREGAR / QUITAR VEHICULO */
        function vehiculo(id, op) {

          if (medios_utilizados.indexOf(id) != -1) {
            // se eliminar y se remplaza la clase del button

            delete medios_utilizados[id];

            $('#btn_' + id).addClass('btn-secondary')
            $('#btn_' + id).removeClass('btn-primary')
            $('#btn_' + id).html('<span class="tf-icons bx bx-minus"></span>')
          } else {
            // Se agrega
            medios_utilizados[id] = id

            if (op == 's') {
              Swal.fire({
                title: "Atención",
                text: "El vehículo que agregó se está empleando para una acción en la fecha seleccionada",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#69a5ff",
                confirmButtonText: "Ok"
              })
            }

            $('#btn_' + id).removeClass('btn-secondary')
            $('#btn_' + id).addClass('btn-primary')
            $('#btn_' + id).html('<span class="tf-icons bx bx-check"></span>')

          }

        }
        /* AGREGAR / QUITAR VEHICULO */




        /* Agregar y quitar empresas involucradas */
        /* Agregar y quitar condicion adversas */
        function addCondicion(accion) {
          let condicion = $('#condicion').val()

          if (recurso_m == '') {
            toast_s('warning', 'Error: campos vacíos')
            return;
          }

          $('button').attr('disabled', true)


          condicionesAdversas[condicion] = [
            condicion
          ]

          $('#list-cond-adver').html('')
          let claves = Object.keys(condicionesAdversas)
          for (let index = 0; index < claves.length; index++) {
            let element = condicionesAdversas[claves[index]];
            let icon

            $('#list-cond-adver').append(`
                <tag class="tagify__tag d-flex justify-content-between" style="padding: 2px 8px;min-width: 22%">
                  <div >
                    <span class="tagify__tag-text  me-3" >` + element[0] + `</span>
                  </div>
                 <i onclick="quitarCondicion('` + element[0] + `')" class=" bx bx-trash-alt cursor" style="font-size: 12px;"></i>
                </tag> `)
          }

          $('button').attr('disabled', false)
          $('#condicion').val('')

          toast_s('success', 'Agregado correctamente.')
          if (accion == 'af') {
            $('#condiciones-modal').modal('toggle')
          }
        }

        function quitarCondicion(id) {

          delete condicionesAdversas[id];

          $('#list-cond-adver').html('')
          let claves = Object.keys(condicionesAdversas)
          for (let index = 0; index < claves.length; index++) {
            let element = condicionesAdversas[claves[index]];
            $('#list-cond-adver').append(`
                <tag class="tagify__tag d-flex justify-content-between"  style="padding: 2px 8px;min-width: 22%">
                  <div >
                    <span class="tagify__tag-text">` + element[0] + `</span>
                  </div>
                 <i onclick="quitarCondicion('` + element[0] + `')" class="bx bx-trash-alt cursor" style="font-size: 12px;"></i>
                </tag> `)
          }
          toast_s('success', 'Se eliminó correctamente.')
        }
        /* Agregar y quitar condicion adversas */
        /* Agregar y quitar recursos */
        function addRecursos(accion) {
          let recurso_m = $('#recurso_m').val()
          let recurso_disp = 1
          //let recurso_disp = $('#recurso_disp').val()

          if (recurso_m == '' || recurso_disp == '') {
            toast_s('warning', 'Error: campos vacíos')
            return;
          }

          $('button').attr('disabled', true)


          recursosDisponibles[recurso_m] = [
            recurso_m,
            recurso_disp
          ]

          $('#list-recursos').html('')
          let claves = Object.keys(recursosDisponibles)
          for (let index = 0; index < claves.length; index++) {
            let element = recursosDisponibles[claves[index]];
            let icon
            if (element[1] == 0) {
              icon = 'bx-checkbox'
            } else {
              icon = 'bx-checkbox-checked'
            }
            $('#list-recursos').append(`
                <tag class="tagify__tag d-flex justify-content-between" style="padding: 2px 8px;min-width: 22%">
                  <div >
                    <div class="tagify__tag__avatar-wrap m--6">
                    <i style='vertical-align: unset;' class="bx ` + icon + `"></i></div>
                    <span class="tagify__tag-text  me-3" >` + element[0] + `</span>
                  </div>
                 <i onclick="quitarRecurso('` + element[0] + `')" class=" bx bx-trash-alt cursor" style="font-size: 12px;"></i>
                </tag> `)
          }

          $('button').attr('disabled', false)
          $('#recurso_m').val('')
          //  $('#recurso_disp').val('')

          toast_s('success', 'Agregado correctamente.')
          if (accion == 'af') {
            $('#recursos-modal').modal('toggle')
          }
        }

        function quitarRecurso(id) {

          delete recursosDisponibles[id];

          $('#list-recursos').html('')
          let claves = Object.keys(recursosDisponibles)
          for (let index = 0; index < claves.length; index++) {
            let element = recursosDisponibles[claves[index]];
            let icon
            if (element[1] == 0) {
              icon = 'bx-checkbox'
            } else {
              icon = 'bx-checkbox-checked'
            }
            $('#list-recursos').append(`
                <tag class="tagify__tag d-flex justify-content-between"  style="padding: 2px 8px;min-width: 22%">
                  <div >
                    <div class="tagify__tag__avatar-wrap m--6">
                    <i style='vertical-align: unset;' class="bx ` + icon + `"></i></div>
                    </div>
                    <span class="tagify__tag-text">` + element[0] + `</span>
                  </div>
                 <i onclick="quitarRecurso('` + element[0] + `')" class="bx bx-trash-alt cursor" style="font-size: 12px;"></i>
                </tag> `)
          }
          toast_s('success', 'Se eliminó correctamente.')
        }
        /* Agregar y quitar recursos */

        function borrarTarea(id) {

          Swal.fire({
            title: "<strong>¿Está seguro?</strong>",
            icon: "warning",
            html: `Se <b>eliminara</b>. La acción es irreversible.`,
            showCancelButton: true,
            confirmButtonColor: "#69a5ff",
            confirmButtonText: `Eliminar`,
            cancelButtonText: `Cancelar`,
          }).then((result) => {
            if (result.isConfirmed) {
              $('.container-loader').show()
              $.get("../../back/ajax/go_operacion_borrar_tarea.php", "i=" + id, function(data) {
                $('.container-loader').hide()
                if (data.trim() == 'ok') {
                  toast_s('success', 'Borrado correctamente.')
                  location.reload();
                } else if (data.trim() == 'NP') {
                  toast_s('warning', 'Acción no permitida.')
                } else {
                  alert(data)
                }
              });
            } else {
              $('.container-loader').hide()
            }
          });
        }


      <?php } ?>


      <?php if ($usuario == 'SA') { ?>


        function cerrarOperacion() {
          Swal.fire({
            title: "<strong>¿Está seguro?</strong>",
            icon: "warning",
            html: `Se <b>cerrará la operación</b> y no se podrán realizar más cambios. <strong>La acción es irreversible.</strong>`,
            showCancelButton: true,
            confirmButtonColor: "#69a5ff",
            confirmButtonText: `Cerrar Operación`,
            cancelButtonText: `Cancelar`,
          }).then((result) => {
            location.href = "../../back/ajax/go_operacion_cerrar_operacion.php?i=<?php echo $operacion_id ?>";
          });

        }

      <?php } ?>

    <?php } ?>


    function verM(m) {
      $(m).modal('toggle')
    } // mostrar modales :)


    /* BUSCADOR */
    function search(value) {
      let valoraresaltar = value.toLowerCase().trim();
      let tabla_tr = document.getElementsByTagName("tbody")[2].rows;

      if (valoraresaltar != "") {

        for (let i = 0; i < tabla_tr.length; i++) {

          let tr = tabla_tr[i];
          let textotr = tr.innerText.toLowerCase();
          tr.className = (textotr.indexOf(valoraresaltar) != -1) ? "resaltado" : "noresaltado";
          // operador ternario
        }
      } else {
        for (let i = 0; i < tabla_tr.length; i++) {
          let tr = tabla_tr[i];
          tr.classList.remove("resaltado");
        }
      }
    }


    $(document).ready(function() {
      $("#municipio").change(function() {
        $('.container-loader').show()
        $.get("../../back/ajax_selects/selec_parroquias.php", "municipio_id=" + $("#municipio").val(), function(data) {
          $("#parroquia").html(data);

          $('.container-loader').hide()
          // set view to monicipio
        });
      });

      $("#parroquia").change(function() {
        $('.container-loader').show()
        $.get("../../back/ajax_selects/selec_comunas.php", "parroquia_id=" + $("#parroquia").val(), function(data) {
          $("#comuna").html(data);
          $('.container-loader').hide()
        });
      });

      $("#comuna").change(function() {
        $('.container-loader').show()
        $.get("../../back/ajax_selects/selec_comunidades.php", "comuna_id=" + $("#comuna").val(), function(data) {
          $("#comunidad").html(data);
          $('.container-loader').hide()
          $("#comunidad").append('<option value="add-item" class="bg-primary text-white">-- Agregar comunidad --</option>');
        });
      });
    });
  </script>

  </html>
<?php
}
?>