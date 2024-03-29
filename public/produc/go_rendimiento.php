<?php
include('../../back/config/conexion.php');
include('../../back/config/funcione_globales.php');

if ($_SESSION["u_nivel"] != '1' && $_SESSION["u_nivel"] != '2') {
  header("Location: ../index.php");
}





if ($_SESSION["u_nivel"] == 2 || $_SESSION["u_nivel"] == 3) {
  $empresa = $_SESSION['u_ente_id'];
  $extra_for_tarea = " AND responsable_ente_id='$empresa' ";
  $extra_user = " AND u_id='$empresa' ";
} else {
  if (isset($_GET["empresa"])) {
    $empresa =  $_GET['empresa'];
    $extra_user = " AND u_id='$empresa' ";
  } else {
    $extra_for_tarea = "";
    $extra_user = "";
  }
}



if (@$_SESSION['filter_t'] != '') {
  $filter_t = $_SESSION['filter_t'];
  $extra_trimestre =  "AND trimestre='" . $filter_t . "'";
} else {
  $extra_trimestre = '';
}



if (@$_SESSION['filter_a'] != '') {
  $ano = $_SESSION['filter_a'];
} else {
  $ano = date('Y');
}




$estrategico_ejecutado_1 =  contar("SELECT count(*) FROM go_planes WHERE tipo='2' AND cerrado='1' AND ano='$ano' AND trimestre='1'");
$_estrategico_pendiente_1 =  contar("SELECT count(*) FROM go_planes WHERE tipo='2' AND cerrado='0' AND ano='$ano' AND trimestre='1'");
$contingencia_ejecutado_1 = contar("SELECT count(*) FROM go_operaciones WHERE tipo_p='3' AND cerrado='1' AND ano='$ano' AND trimestre='1'");
$contingencia_pendiente_1 = contar("SELECT count(*) FROM go_operaciones WHERE tipo_p='3' AND cerrado='0' AND ano='$ano' AND trimestre='1'");

/* 1ER TRIMESTRE */


$estrategico_ejecutado_2 =  contar("SELECT count(*) FROM go_planes WHERE tipo='2' AND cerrado='1' AND ano='$ano' AND trimestre='2'");
$_estrategico_pendiente_2 =  contar("SELECT count(*) FROM go_planes WHERE tipo='2' AND cerrado='0' AND ano='$ano' AND trimestre='2'");
$contingencia_ejecutado_2 = contar("SELECT count(*) FROM go_operaciones WHERE tipo_p='3' AND cerrado='1' AND ano='$ano' AND trimestre='2'");
$contingencia_pendiente_2 = contar("SELECT count(*) FROM go_operaciones WHERE tipo_p='3' AND cerrado='0' AND ano='$ano' AND trimestre='2'");

/* 2do TRIMESTRE */


$estrategico_ejecutado_3 =  contar("SELECT count(*) FROM go_planes WHERE tipo='2' AND cerrado='1' AND ano='$ano' AND trimestre='3'");
$_estrategico_pendiente_3 =  contar("SELECT count(*) FROM go_planes WHERE tipo='2' AND cerrado='0' AND ano='$ano' AND trimestre='3'");
$contingencia_ejecutado_3 = contar("SELECT count(*) FROM go_operaciones WHERE tipo_p='3' AND cerrado='1' AND ano='$ano' AND trimestre='3'");
$contingencia_pendiente_3 = contar("SELECT count(*) FROM go_operaciones WHERE tipo_p='3' AND cerrado='0' AND ano='$ano' AND trimestre='3'");

/* 3er TRIMESTRE */


$estrategico_ejecutado_4 =  contar("SELECT count(*) FROM go_planes WHERE tipo='2' AND cerrado='1' AND ano='$ano' AND trimestre='4'");
$_estrategico_pendiente_4 =  contar("SELECT count(*) FROM go_planes WHERE tipo='2' AND cerrado='0' AND ano='$ano' AND trimestre='4'");
$contingencia_ejecutado_4 = contar("SELECT count(*) FROM go_operaciones WHERE tipo_p='3' AND cerrado='1' AND ano='$ano' AND trimestre='4'");
$contingencia_pendiente_4 = contar("SELECT count(*) FROM go_operaciones WHERE tipo_p='3' AND cerrado='0' AND ano='$ano' AND trimestre='4'");

/* 4to TRIMESTRE */




$estrategico_ejecutado =  $estrategico_ejecutado_1 + $estrategico_ejecutado_2 + $estrategico_ejecutado_3 + $estrategico_ejecutado_4;
$_estrategico_pendiente =  $_estrategico_pendiente_1 + $_estrategico_pendiente_2 + $_estrategico_pendiente_3 + $_estrategico_pendiente_4;
$contingencia_ejecutado = $contingencia_ejecutado_1 + $contingencia_ejecutado_2 + $contingencia_ejecutado_3 + $contingencia_ejecutado_4;
$contingencia_pendiente = $contingencia_pendiente_1 + $contingencia_pendiente_2 + $contingencia_pendiente_3 + $contingencia_pendiente_4;

/* ANO */




$stmt_s = mysqli_prepare($conexion, "SELECT * FROM `go_sectores` WHERE id_p = ?");



$plan = 'No';
$stmt = mysqli_prepare($conexion, "SELECT * FROM `go_planes` WHERE ano = ? AND tipo='1'");
$stmt->bind_param("s", $ano);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $plan = $row['id'];

    $stmt_s->bind_param("s", $plan);
    $stmt_s->execute();
    $result2 = $stmt_s->get_result();
    if ($result2->num_rows > 0) {
      while ($row2 = $result2->fetch_assoc()) {
        $id_s = $row2['id_s'];

        switch ($row2['sector']) {
          case 'Servicios':
            $sec_Servicios =  contar("SELECT count(*) FROM go_operaciones WHERE id_p='$plan' AND id_s='$id_s' AND ano='$ano'");
            $sec_Servicios_1 =  contar("SELECT count(*) FROM go_operaciones WHERE id_p='$plan' AND id_s='$id_s' AND ano='$ano' AND trimestre='1'");
            $sec_Servicios_2 =  contar("SELECT count(*) FROM go_operaciones WHERE id_p='$plan' AND id_s='$id_s' AND ano='$ano' AND trimestre='2'");
            $sec_Servicios_3 =  contar("SELECT count(*) FROM go_operaciones WHERE id_p='$plan' AND id_s='$id_s' AND ano='$ano' AND trimestre='3'");
            $sec_Servicios_4 =  contar("SELECT count(*) FROM go_operaciones WHERE id_p='$plan' AND id_s='$id_s' AND ano='$ano' AND trimestre='4'");

            break;
          case 'Económico productivo':
            $sec_Económico_productivo =  contar("SELECT count(*) FROM go_operaciones WHERE id_p='$plan' AND id_s='$id_s' AND ano='$ano'");
            $sec_Económico_productivo_1 =  contar("SELECT count(*) FROM go_operaciones WHERE id_p='$plan' AND id_s='$id_s' AND ano='$ano' AND trimestre='1'");
            $sec_Económico_productivo_2 =  contar("SELECT count(*) FROM go_operaciones WHERE id_p='$plan' AND id_s='$id_s' AND ano='$ano' AND trimestre='2'");
            $sec_Económico_productivo_3 =  contar("SELECT count(*) FROM go_operaciones WHERE id_p='$plan' AND id_s='$id_s' AND ano='$ano' AND trimestre='3'");
            $sec_Económico_productivo_4 =  contar("SELECT count(*) FROM go_operaciones WHERE id_p='$plan' AND id_s='$id_s' AND ano='$ano' AND trimestre='4'");
            break;
          case 'Social':
            $sec_Social =  contar("SELECT count(*) FROM go_operaciones WHERE id_p='$plan' AND id_s='$id_s' AND ano='$ano'");
            $sec_Social_1 =  contar("SELECT count(*) FROM go_operaciones WHERE id_p='$plan' AND id_s='$id_s' AND ano='$ano' AND trimestre='1'");
            $sec_Social_2 =  contar("SELECT count(*) FROM go_operaciones WHERE id_p='$plan' AND id_s='$id_s' AND ano='$ano' AND trimestre='2'");
            $sec_Social_3 =  contar("SELECT count(*) FROM go_operaciones WHERE id_p='$plan' AND id_s='$id_s' AND ano='$ano' AND trimestre='3'");
            $sec_Social_4 =  contar("SELECT count(*) FROM go_operaciones WHERE id_p='$plan' AND id_s='$id_s' AND ano='$ano' AND trimestre='4'");
            break;
        }
      }
    }
    $stmt_s->close();
  }
}

$stmt->close();





?>




<!DOCTYPE html>

<html lang="es" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title class="go" id="title">Rendimiento Operacional</title>
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

  <script src="../../assets/vendor/libs/jquery/jquery.js"></script>

  <script src="../../js/sweetalert2.all.min.js"></script>


  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <link rel="stylesheet" href="../../assets/vendor/leaflet.edgebuffer.js" />


</head>

<body>

<style>
  .mapToFront{
    height: 100vh !important;
    background-color: #000000de;
    position: fixed;
    z-index: 1900;
    width: 100%;
    display: flex;
    top: 0;
    left: 0;
  }
  .close-btn {
      position: absolute;
      top: 16px;
      left: 36px;
      width: 30px;
      background: #444;
      color: #fff;
      border-radius: 50%;
      padding: 10px;
      display: flex;
      z-index: 20;
      cursor: pointer;
    }

    .mapFront{
    background-color: #00000052;
    width: 90%;
    height: 90%;
    margin: auto;
    }
    .mapFull{
      margin: 55px 35px 45px !important;
      height: 80% !important;
    }

.hide{
  display: none !important;
}
</style>



<div class="container-loader" style="background-color: lightgray;">
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

              <?php
              $y_d1 = date('Y') - 1;
              $y_d = date('Y');
              $y_d2 = date('Y') + 1;
              ?>
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gestión Operativa /</span> Planes del <?php echo $ano; ?></h4>

              <button type="button" class="btn btn-icon ms-2 me-2 btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filtraAno">
                <span class="tf-icons bx bx-calendar"></span>
              </button>

            </div>


            <section>
              <!-- CONTENIDO -->


              <div class="row ">


                <div class="col-lg-12">

                  <div class="card-header mb-4 d-flex justify-content-between">
                    <ul class="nav nav-pills" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button id="b_0" onclick="filter('t','0')" type="button" class="nav-link">Vista anual</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button id="b_1" onclick="filter('t','1')" type="button" class="nav-link">Primer Trimestre</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button id="b_2" onclick="filter('t','2')" type="button" class="nav-link">Segundo Trimestre</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button id="b_3" onclick="filter('t','3')" type="button" class="nav-link">Tercer Trimestre</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button id="b_4" onclick="filter('t','4')" type="button" class="nav-link">Cuarto Trimestre</button>
                      </li>
                    </ul>

                    <?php if ($_SESSION["u_nivel"] == 1) {   ?>

                      <div style="width: 200px;">

                        <div class="input-group">
                          <select id="filtro_empresa" onchange="filtrarEmpresa(this.value)" class="form-control">
                            <option value="all">Todas las empresas</option>
                            <?php
                            $stmt = mysqli_prepare($conexion, "SELECT * FROM `system_users` WHERE u_nivel = '2'");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {
                              while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['u_id'] . '">' . $row['u_ente'] . '</option>';
                              }
                            }
                            ?>
                          </select>
                          <span class="input-group-text cursor-pointer"><i class="bx bx-filter-alt"></i></span>
                        </div>
                      </div>
                      <script>
                        function filtrarEmpresa(empresa) {
                          var loc = window.location;
                          var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
                          let url = loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length)) + 'go_rendimiento.php';

                          const urlParts = new URL(url);
                          if (empresa != 'all') {
                            urlParts.searchParams.append("empresa", empresa);
                          }
                          location.href = urlParts.href;
                        }
                      </script>
                      <?php
                      if (isset($_GET["empresa"])) { ?>
                        <script>
                          $("#filtro_empresa" + " option[value='<?php echo $_GET["empresa"] ?>']").attr("selected", true);
                        </script>
                      <?php } else { ?>
                        <script>
                          $("#filtro_empresa" + " option[value='']").attr("selected", true);
                        </script>
                    <?php }
                    } ?>
                  </div>
                </div>
                <div class="col-lg-7">
                  <div class="row">
                    <div class="col-lg-6 mb-3">
                      <div class="card" style="min-height: 225px;">
                        <div class="card-body">
                          <div class="d-flex justify-content-between">
                            <div class="d-flex flex-column">
                              <div class="card-title mb-auto">
                                <h5 class="mb-0">Operaciones</h5>
                                <small>Abiertas/Cerradas</small>
                              </div>
                              <div class="chart2-statistics">
                                <h3 class="card-title mb-1">
                                  <span id="cant_op"></span>
                                  <small class="text-muted">Op</small>
                                </h3>

                                </h3>
                              </div>
                            </div>

                            <div>
                              <div id="chart_estrategicos" style="min-height: 154.8px; width: 174px"></div>
                              <div class="overMark"></div>
                            </div>

                            <div class="resize-triggers">
                              <div class="expand-trigger">
                                <div style="width: 359px; height: 156px;"></div>
                              </div>
                              <div class="contract-trigger"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="col-lg-6 mb-3">
                      <div class="card" style="min-height: 225px;">
                        <div class="card-body">
                          <div class="d-flex justify-content-between" style="position: relative;">
                            <div class="d-flex flex-column">
                              <div class="card-title mb-auto">
                                <h5 class="mb-0">Operaciones</h5>
                                <small>Tipo de plan</small>
                              </div>
                              <div class="chart2-statistics">
                                <h3 class="card-title" style="display: none;">
                                  <span id="cant_op2"></span>
                                  <small class="text-muted">Op</small>
                                </h3>
                              </div>
                            </div>


                            <div>
                              <div id="chart_contingecias" style="min-height: 154.8px; width: 174px"></div>
                              <div class="overMark"></div>
                            </div>


                          </div>
                        </div>
                      </div>
                    </div>











                    <div class="col-lg-12 mb-3">
                      <div class="card">
                        <div class="row row-bordered g-0">
                          <div class="col-md-8">
                            <div class="card-header">
                              <h5 class="card-title mb-0">Tareas</h5>
                              <small class="card-subtitle">Ejecutadas/Pendientes</small>
                            </div>
                            <div class="card-body" style="position: relative;">
                              <div id="chartdiv3" style="height: 60vh; width: 100%;"></div>
                              <div class="overMark"></div>


                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="card-header d-flex justify-content-between">
                              <div>
                                <h5 class="card-title mb-0">Resultados</h5>
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="report-list">
                                <div class="report-list-item rounded-2 mb-3">
                                  <div class="d-flex align-items-start">
                                    <div class="report-list-icon shadow-sm me-2  rounded iconResult">
                                      <i class="bx bx-user"></i>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-end w-100 flex-wrap gap-2">
                                      <div class="d-flex flex-column">
                                        <span>Personas</span>
                                        <h5 class="mb-0" id="cant_p"></h5>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="report-list-item rounded-2 mb-3">
                                  <div class="d-flex align-items-start">
                                    <div class="report-list-icon shadow-sm me-2 rounded iconResult">
                                      <i class="bx bx-map-pin"></i>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-end w-100 flex-wrap gap-2">
                                      <div class="d-flex flex-column">
                                        <span>Comunidades</span>
                                        <h5 class="mb-0" id="cant_c"></h5>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="report-list-item rounded-2">
                                  <div class="d-flex align-items-start">
                                    <div class="report-list-icon shadow-sm me-2  rounded iconResult">
                                      <i class="bx bx-map-alt"></i>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-end w-100 flex-wrap gap-2">
                                      <div class="d-flex flex-column">
                                        <span>Comunas</span>
                                        <h5 class="mb-0" id="cant_cas"></h5>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!--/ Total Income -->
                    </div>


                    <?php if ($_SESSION["u_nivel"] == 1) { ?>
                      <div class="col-lg-12 mb-3">
                        <div class="card">


                          <div class="card-header">
                            <h5 class="card-title mb-0">Solicitudes de participación</h5>
                            <small class="card-subtitle">Parte responsable</small>
                          </div>
                          <div class="card-body" style="position: relative;">
                            <div id="chartdiv5" style="height: 60vh; width: 100%;"></div>
                            <div class="overMark"></div>
                          </div>
                        </div>
                        <!--/ Total Income -->
                      </div>
                    <?php } ?>



                  </div>
                </div>




                <div class="col-lg-5">

                      <style>
                        .infoTarea{
                          position: absolute;
                          z-index: 999;
                          display: flex;
                          width: -webkit-fill-available;
                          bottom: 0;
                          margin-bottom: 20px;
                        }
                        .content_info{
                          margin: auto;
                          width: 80%;
                          background-color: #0000008f;
                          padding: 10px;
                          border-radius: 5px;
                          color: white;
                          box-shadow: 0 2px 6px 0 rgb(0 0 0 / 36%)
                        }
                      </style>

                <div class="card mb-3" id="asdasd">

                <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="card-title mb-0">
                              <h5 class="m-0 me-2">Tareas ejecutadas</h5>
                            </div>



                            <div class="btn-group dropstart">


                              <button type="button" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="bx bx-dots-vertical-rounded"></i>
                              </button>




                              <div class="dropdown-menu p-2">
                              <a class="dropdown-item" onclick="mapToFront()"><i class='bx bx-fullscreen me-2'></i> Pantalla completa</a>
                              </div>
                            </div>

                          </div>



                      <div class="card-body "  style="height: 40vh">



                      <div style="height: 100%;" id="contenMap" class="mapToFront">
                        
                      <div class="close-btn" style="display: none;" id="btnclose"  onclick="removeFronMap()">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                          </svg>
                        </div>

                        <div class="infoTarea animated fadeIn hide"  id="infoMap">
                          <div class="content_info">
                                  <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-label-success">Ejecutado</span>
                                    <h6 class="d-flex align-items-center justify-content-center gap-1 mb-0">
                                      5 <span class="text-warning"><i class="bx bxs-user me-1"></i></span><span class="text-white" id="map_personas"></span>
                                    </h6>
                                  </div>
                                  <h5 id="map_nameTarea" class="text-white"></h5>

                                  <p class="mt-2" id="map_desc"></p>
                                  <p class="d-flex align-items-center"><i class="bx bx-time-five me-2"></i> <span id="map_time"></span></p>
                          </div>
                        </div>

                        
                        <div id="map" class="rounded" style="height: 80%; width: 100%;"></div>
                        
                      </div>
                      
                      </div>
                    </div>

                  <?php if ($_SESSION["u_nivel"] == 1) { ?>
                    <div class="card mb-3">
                      <div class="card-body">
                        <h5 class="card-title mb-0">Contingencias</h5>
                        <small class="card-subtitle">Por empresas</small>


                        <div id="chartdiv4" style="height: 40vh; width: 100%;"></div>
                        <div class="overMark"></div>
                      </div>
                    </div>
                  <?php } ?>


                  <div class="card mb-3">
                    <div class="card-body">
                      <h5 h5 class="card-title">Operaciones</h5>
                      <div class="demo-inline-spacing mt-4">


                        <table class="table">
                          <tbody>

                            <?php
                            /* INICIALIZAR CONTADORES */
                            $operaciones_cerradas = 0;
                            $operaciones_abiertas = 0;
                            $operaciones_p_sectorial = 0;
                            $operaciones_p_estrategico = 0;
                            $operaciones_p_contingencia = 0;
                            $total_tareas = 0;
                            $total_tareas_ejecutadas = 0;
                            /* INICIALIZAR CONTADORES */

                            $contingenciasXempresas = array();





                            $stmt_s = mysqli_prepare($conexion, "SELECT * FROM `go_operaciones` WHERE ano = ? AND empresa_id= ? ORDER BY empresa_id ASC, data_time DESC");


                            $stmt_k = mysqli_prepare($conexion, "SELECT u_ente, u_id FROM `system_users`  WHERE u_nivel = '2' $extra_user ");
                            $stmt_k->execute();
                            $resultk = $stmt_k->get_result();
                            if ($resultk->num_rows > 0) {
                              while ($row = $resultk->fetch_assoc()) {
                                $ente = $row['u_ente'];
                                $ente_id = $row['u_id'];


                                array_push($contingenciasXempresas, [$row['u_ente'], contar("SELECT count(*) FROM go_tareas WHERE ano='$ano' AND responsable_ente_id='$ente_id' AND id_plan='0'  $extra_trimestre")]);


                                $stmt_s->bind_param("ss", $ano, $ente_id);
                                $stmt_s->execute();
                                $result2 = $stmt_s->get_result();
                                if ($result2->num_rows > 0) {
                                  while ($row2 = $result2->fetch_assoc()) {
                                    $id = $row2['id'];

                                    $tareas = contar("SELECT count(*) FROM go_tareas WHERE id_operacion='$id' AND responsable_ente_id='$ente_id'  $extra_trimestre");
                                    $tareas_ejecutadas = contar("SELECT count(*) FROM go_tareas WHERE id_operacion='$id' AND status='1' AND responsable_ente_id='$ente_id'  $extra_trimestre");


                                    $total_tareas += $tareas;
                                    $total_tareas_ejecutadas += $tareas_ejecutadas;
                                    echo ' 
                                    <tr class="odd t_">
                                    <td class="sorting_1">
                                      <div class="d-flex align-items-center"><span class="me-3">';


                                    if ($row2['tipo_p'] == '1') {
                                      echo ' <span class="badge bg-label-success p-2"><i>S</i></span>';
                                      $operaciones_p_sectorial++;
                                    } elseif ($row2['tipo_p'] == '2') {
                                      echo ' <span class="badge bg-label-primary p-2"><i>E</i></span>';
                                      $operaciones_p_estrategico++;
                                    } else {
                                      echo ' <span class="badge bg-label-warning p-2"><i>C</i></span></span>';
                                      $operaciones_p_contingencia++;
                                    }

                                    echo '</span>
                                        <div><span class="text-heading text-truncate fw-medium mb-2 text-wrap" >' . $row2['nombre'] . '<br><small class="text-muted">' . $ente . '</small></span>
                                          <div class="d-flex align-items-center mt-1">
                                          </div>
                                        </div>
                                      </div>
                                    </td>
                                    <td>
                                      <div class="d-flex">
                                        <div class="w-px-50 d-flex align-items-center" title="Tareas"><i class="me-2 bx bx-task-x bx-xs text-light"></i>' . $tareas . '</div>
                                        <div class="w-px-50 d-flex align-items-center" title="Tareas"><i class="me-2 bx bx-task bx-xs text-primary"></i>' . $tareas_ejecutadas . '</div>';
                                    if ($row2['cerrado'] == '1') {
                                      echo '<div class="w-px-50 d-flex align-items-center" title="Tareas"><i class="me-2 bx bx-check bx-xs text-success"></i></div>';
                                      $operaciones_cerradas++;
                                    } else {
                                      $operaciones_abiertas++;
                                    }
                                    echo '
                                      </div>
                                    </td>
                                  </tr>';
                                  }
                                }
                              }
                            }
                            $stmt_k->close();
                            $stmt_s->close();





                            ?>





                          </tbody>
                        </table>

                      </div>
                    </div>
                  </div>


                  <script>
                            var mapInfo = [];
                          </script>
                          
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-title">Solicitudes de participación</h5>
                    </div>
                    <div class="card-body">

                      <div class="table-responsive text-nowrap">
                        <table class="table text-nowrap">
                          <thead>
                            <tr>
                              <th>Tipo</th>
                              <th>Estatus</th>
                            </tr>
                          </thead>
                          <tbody class="table-border-bottom-0">

                            <?php

                            $solicitudesXempresas = array();

                            $stmt_r = mysqli_prepare($conexion, "SELECT fecha_ejecucion, cords, tarea, descripcion, status, atencion_personas_1, atencion_personas_2, atencion_personas_3, atencion_personas_4, atencion_comunidades_1, atencion_comunidades_2, atencion_comunidades_3, atencion_comunidades_4, atencion_comunas_1, atencion_comunas_2, atencion_comunas_3, atencion_comunas_4, atencion_personas, atencion_comunidades, atencion_comunas FROM `go_tareas` WHERE ano = ? AND responsable_ente_id= ? $extra_trimestre  ORDER BY fecha_ejecucion");


                            $tarea_pendientes = 0;
                            $tarea_ejecutadas = 0;
                            $total_personas = 0;
                            $total_comunidades = 0;
                            $total_comunas = 0;


                            $stmt_s = mysqli_prepare($conexion, "SELECT * FROM `go_solicitud_union` WHERE ano = ? AND user_1= ?  $extra_trimestre ORDER BY id DESC");
                            /* Extra la información de las solicitudes */





                            $stmt_k = mysqli_prepare($conexion, "SELECT u_ente, u_id FROM `system_users`  WHERE u_nivel = '2' $extra_user ");
                            $stmt_k->execute();
                            $resultk = $stmt_k->get_result();
                            if ($resultk->num_rows > 0) {
                              while ($row = $resultk->fetch_assoc()) {
                                $ente = $row['u_ente'];
                                $ente_id = $row['u_id'];


                                //default

                                if (file_exists('../../assets/img/avatars/' . $row['u_id'] . '.png')) {
                                  $img = '../../assets/img/avatars/' . $row['u_id'] . '.png';
                                } else {
                                  $img = '../../assets/img/avatars/default.png';
                                }



                                $cantidad = contar("SELECT count(*) FROM go_solicitud_union WHERE ano='$ano' AND user_1='$ente_id' $extra_trimestre");

                                if ($cantidad != 0) {
                                  array_push($solicitudesXempresas, [$img, $row['u_ente'], $cantidad]);
                                }



                                $stmt_r->bind_param("ss", $ano, $ente_id);
                                $stmt_r->execute();
                                $resultr = $stmt_r->get_result();
                                if ($resultr->num_rows > 0) {
                                  while ($r = $resultr->fetch_assoc()) {
                            
                                    $total_personas += $r['atencion_personas_1'] + $r['atencion_personas_2'] + $r['atencion_personas_3'] + $r['atencion_personas_4'] + $r['atencion_personas'];




                                    if ($r['status'] == '1') {
                                   
                                 
                                      $tarea = $r['tarea'];
                                      $descripcion = $r['descripcion'];
                                      $cords = $r['cords'];
                                      $fecha_ejecucion = $r['fecha_ejecucion'];
  
                                      echo '<script>
                                      mapInfo.push(["'.$tarea.'", `'.recortar_palabras($descripcion).'`, \''.$cords.'\', \''.$total_personas.'\', \''.fechaCastellano($fecha_ejecucion).'\'])
                                      </script>';
  


                                      $tarea_ejecutadas++;
                                    } else {
                                      $tarea_pendientes++;
                                    }

                                    $total_comunidades += $r['atencion_comunidades_1'] + $r['atencion_comunidades_2'] + $r['atencion_comunidades_3'] + $r['atencion_comunidades_4'] + $r['atencion_comunidades'];
                                    $total_comunas += $r['atencion_comunas_1'] + $r['atencion_comunas_2'] + $r['atencion_comunas_3'] + $r['atencion_comunas_4'] +  $r['atencion_comunas'];
                                  }
                                }


                                /* Extra la información de las solicitudes */
                                /* Extra la información de las solicitudes */
                                /* Extra la información de las solicitudes */
                                $stmt_s->bind_param("ss", $ano, $ente_id);
                                $stmt_s->execute();
                                $result2 = $stmt_s->get_result();
                                if ($result2->num_rows > 0) {
                                  while ($row2 = $result2->fetch_assoc()) {
                                    $id = $row2['id'];

                                    echo ' 
                                  <tr>
                                  <td>';

                                    if ($row2['status'] == '1') {
                                      echo '<span class="badge bg-label-secondary rounded-pill badge-center p-3 me-2"><i class="bx bx-cube bx-xs"></i></span> Aprovechar recursos';
                                    } else {
                                      echo '<span class="badge bg-label-primary rounded-pill badge-center p-3 me-2"><i class="bx bx-group bx-xs"></i></span> Parte responsable';
                                    }

                                    /*
                        <td>
                                    <div class="text-muted lh-1"><span class="text-primary fw-medium">$120</span>/499</div>
                                    <small class="text-muted">Partially Paid</small>
                                  </td>
                                  */

                                    echo '
                                    <br>

                                    <small class="text-muted" style="margin-left: 45px; font-size: 12px">' . $ente . '</small>
                                  </td>
                              
                                  <td>';
                                    if ($row2['status'] == '0') {
                                      echo '<span class="badge bg-label-secondary">Pendiente</span>';
                                    } elseif ($row2['status'] == '1') {
                                      echo '<span class="badge bg-label-success">Aprobado</span>';
                                    } else {
                                      echo '<span class="badge bg-label-danger">Rechazado</span>';
                                    }
                                    echo '</td>
                                </tr>';
                                  }
                                }
                              }
                            }

                            $stmt_k->close();
                            $stmt_s->close();
                            $stmt_r->close();
                            ?>



                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>













                </div>
            </section>


            <div class="modal fade" id="filtraAno" data-bs-backdrop="static" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered">
                <form class="modal-content" id="filtraAno">
                  <div class="modal-header">
                    <h5 class="modal-title">Filtrar por año</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <input type="text" id="p" hidden />
                    <div class=" mb-3">
                      <label for="ano_filtro" class="form-label">Indique el año</label>
                      <?php
                      $y_d1 = date('Y') - 1;
                      $y_d = date('Y');
                      $y_d2 = date('Y') + 1;
                      ?>
                      <select id="ano_filtro" class="form-control">
                        <option value="<?php echo $y_d1 ?>"><?php echo $y_d1 ?></option>
                        <option value="<?php echo $y_d ?>"><?php echo $y_d ?></option>
                        <option value="<?php echo $y_d2 ?>"><?php echo $y_d2 ?></option>
                      </select>

                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                      Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" onclick="filter()">Filtrar</button>
                  </div>
                </form>
              </div>
            </div>



          </div>
          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->


  <?php require('../includes/alerts.html'); ?>


  <!-- build:js assets/vendor/js/core.js -->
  <script src="../../assets/vendor/libs/popper/popper.js"></script>
  <script src="../../assets/vendor/js/bootstrap.js"></script>
  <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../../assets/vendor/js/menu.js"></script>
  <script src="../../assets/js/main.js"></script>
  <script src="../../assets/js/ui-popover.js"></script>
  <script type="text/javascript" src="../../assets/vendor/calendar/caleandar.js"></script>


  <script src="../../assets/vendor/amcharts5/index.js"></script>
  <script src="../../assets/vendor/amcharts5/flow.js"></script>
  <script src="../../assets/vendor/amcharts5/xy.js"></script>
  <script src="../../assets/vendor/amcharts5/percent.js"></script>
  <script src="../../assets/vendor/amcharts5/themes/Animated.js"></script>
  <script src="../../assets/vendor/amcharts5/themes/Material.js"></script>
  <script src="../../assets/vendor/amcharts5/themes/Dataviz.js"></script>


  

</body>

<script>



/*MAPA */
var map = new L.Map("map", {
  fullscreenControl: true,
}).setView([5.65, -67.6], 13);
map.attributionControl.setPrefix("");





var baseLayers = {
  Satelite: L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
    edgeBufferTiles: 5,
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
map.addLayer(baseLayers.Calles);






var overlayers = {};

var controlRight1 = L.control
  .layers(baseLayers, overlayers, {
    position: "topright", // 'topleft', 'bottomleft', 'bottomright'
    collapsed: true, // true
  })
  .addTo(map); // Primer Control Derecha

  let i = 0;
  const timer = setInterval(function() {    
    if (mapInfo.length > 0) {
      
    let geoJsonResult = JSON.parse(mapInfo[i][2]);

    
    var coords = []; //define an array to store coordinates


    var layerGroup = L.geoJSON(geoJsonResult, {
      onEachFeature: function (feature, layer) {
        layer.bindPopup('<strong>Tarea:</strong> ' + mapInfo[i][0] + '<br><strong>Descripción:</strong> ' + mapInfo[i][1]);
        coords.push(feature.geometry.coordinates);
      }
    }).addTo(map);


    layerGroup.eachLayer(function(layer){
        layer.openPopup();
    });


    coords.forEach(element => {
      map.flyTo([element[1], element[0]], 14, {
            animate: true,
            duration: 1.5
       });
    });


    
//        mapInfo.push(["'.$tarea.'", "'.$descripcion.'", \''.$cords.'\', \''.$total_personas.'\', \''.fechaCastellano($fecha_ejecucion).'\'])


    $('#infoMap').removeClass('hide')
    
    $('#map_nameTarea').html(mapInfo[i][0])
    $('#map_desc').html(mapInfo[i][1])
    $('#map_personas').html(mapInfo[i][3])
    $('#map_time').html(mapInfo[i][4])

    
    i = i + 1
  if (i === mapInfo.length) {
    clearInterval(timer);
  }

}else{
  clearInterval(timer);
}

}, 4000);


  function mapToFront() {
    $("#contenMap").addClass('mapToFront')
    $("#btnclose").show()
    $("#map").addClass('mapFull')
  map.invalidateSize()

  }

  function removeFronMap() {
    $("#contenMap").removeClass('mapToFront')
    $("#btnclose").hide()
    $("#map").removeClass('mapFull')
  map.invalidateSize()
    

  }
  $(window).on("load", removeFronMap);




/*===================================================
                        DRAW ITEM            
    ================================================
    /*MAPA */





















  function nuevo_estrategico() {

    let nombre_est = $('#nombre_est').val()


    if (nombre_est == '') {
      return;
    }

    $('.container-loader').show()
    $.ajax({
      type: 'POST',
      url: '../../back/ajax/go_adm_planes_nuevo_plan_e.php',
      dataType: 'html',
      data: {
        nombre_est: nombre_est,
        ano: "<?php echo $ano ?>"
      },
      cache: false,
      success: function(msg) {
        $('.container-loader').hide()
        if (msg.trim() == 'ok') {
          location.reload();
        } else {
          console.log(msg)
        }
      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      console.log('Ocurrió un error, inténtelo nuevamente ' + errorThrown)
    });



  }




  /* Iniciar/Registrar nuevo plan del ano */
  var ano = "<?php echo $ano ?>"

  function n_plan() {
    $('button').attr('disabled', true);

    $('.container-loader').show()
    $.ajax({
      url: '../../back/ajax/go_adm_planes_v_general_n_plan.php',
      type: 'POST',
      dataType: 'html',
      data: {
        a: ano
      },
      cache: false,
      success: function(msg) {
        $('.container-loader').hide()
        $('button').attr('disabled', false);
        // $('#loader').hide();
        location.reload();

      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      // reintentar
$('.container-loader').hide()
      toast('r', 'Ocurrió un error, inténtelo nuevamente ' + errorThrown)
    });
  }








  function grafico3() {





    // Create root element
    // https://www.amcharts.com/docs/v5/getting-started/#Root_element
    var root3 = am5.Root.new("chartdiv3");

    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root3.setThemes([
      am5themes_Animated.new(root3),
      am5themes_Material.new(root3)
    ]);

    // Create chart
    // https://www.amcharts.com/docs/v5/charts/xy-chart/
    var chart3 = root3.container.children.push(am5xy.XYChart.new(root3, {
      panX: true,
      panY: true,
      wheelX: "panX",
      wheelY: "zoomX",
      pinchZoomX: true,
      paddingLeft: 0,
      paddingRight: 1
    }));

    // Add cursor
    // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
    var cursor = chart3.set("cursor", am5xy.XYCursor.new(root3, {}));
    cursor.lineY.set("visible", false);


    // Create axes
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
    var xRenderer = am5xy.AxisRendererX.new(root3, {
      minGridDistance: 30,
      minorGridEnabled: true
    });

    xRenderer.labels.template.setAll({
      rotation: -90,
      centerY: am5.p50,
      centerX: am5.p100,
      paddingRight: 15
    });

    xRenderer.grid.template.setAll({
      location: 1
    })

    var xAxis = chart3.xAxes.push(am5xy.CategoryAxis.new(root3, {
      maxDeviation: 0.3,
      categoryField: "country",
      renderer: xRenderer,
      tooltip: am5.Tooltip.new(root3, {})
    }));

    var yRenderer = am5xy.AxisRendererY.new(root3, {
      strokeOpacity: 0.1
    })

    var yAxis = chart3.yAxes.push(am5xy.ValueAxis.new(root3, {
      maxDeviation: 0.3,
      renderer: yRenderer
    }));

    // Create series
    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
    var series3 = chart3.series.push(am5xy.ColumnSeries.new(root3, {
      name: "Series 1",
      xAxis: xAxis,
      yAxis: yAxis,
      valueYField: "value",
      sequencedInterpolation: true,
      categoryXField: "country",
      tooltip: am5.Tooltip.new(root3, {
        labelText: "{valueY}"
      })
    }));

    series3.columns.template.setAll({
      cornerRadiusTL: 5,
      cornerRadiusTR: 5,
      strokeOpacity: 0
    });
    series3.columns.template.adapters.add("fill", function(fill, target) {
      return chart3.get("colors").getIndex(series3.columns.indexOf(target));
    });

    series3.columns.template.adapters.add("stroke", function(stroke, target) {
      return chart3.get("colors").getIndex(series3.columns.indexOf(target));
    });


    // Set data
    var data = [{
      country: "Tareas ejecutadas",
      value: <?php echo $tarea_ejecutadas ?>
    }, {
      country: "Tarea pendientes",
      value: <?php echo $tarea_pendientes ?>
    }];

    xAxis.data.setAll(data);
    series3.data.setAll(data);


    // Make stuff animate on load
    // https://www.amcharts.com/docs/v5/concepts/animations/
    series3.appear(1000);
    chart3.appear(1000, 100);



  }

  grafico3()





  <?php if ($_SESSION["u_nivel"] == 1) { ?>

    function grafico4() {
      am5.ready(function() {
        var root = am5.Root.new("chartdiv4");

        root.setThemes([
          am5themes_Animated.new(root),
          am5themes_Material.new(root)
        ]);


        var chart = root.container.children.push(am5percent.PieChart.new(root, {
          layout: root.verticalLayout,
          innerRadius: am5.percent(50)
        }));

        var series = chart.series.push(am5percent.PieSeries.new(root, {
          valueField: "value",
          categoryField: "category",
          alignLabels: false
        }));

        series.labels.template.setAll({
          textType: "circular",
          forceHidden: true,
          centerX: 0,
          centerY: 0
        });


        series.data.setAll([
          <?php
          foreach ($contingenciasXempresas as $value) {
            if ($value[1] != 0) {
              echo '{ value: ' . $value[1] . ', category: "' . $value[0] . '" },' . PHP_EOL;
            }
          }
          ?>
        ]);


        var legend = chart.children.push(am5.Legend.new(root, {
          centerX: am5.percent(50),
          x: am5.percent(50),
          marginTop: 15,
          marginBottom: 15,
        }));

        legend.data.setAll(series.dataItems);

        series.appear(1000, 100);

      }); // end am5.ready()
    }

    grafico4()








    function grafico5() {
      am5.ready(function() {

        var root = am5.Root.new("chartdiv5");

        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
          am5themes_Animated.new(root),
          am5themes_Material.new(root)
        ]);

        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
          panX: false,
          panY: false,
          wheelX: "none",
          wheelY: "none",
          paddingLeft: 0
        }));

        // Add cursor
        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
        cursor.lineY.set("visible", false);

        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xRenderer = am5xy.AxisRendererX.new(root, {
          minGridDistance: 30,
          minorGridEnabled: true
        });

        var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
          maxDeviation: 0,
          categoryField: "name",
          renderer: xRenderer,
          tooltip: am5.Tooltip.new(root, {})
        }));

        xRenderer.grid.template.set("visible", false);

        var yRenderer = am5xy.AxisRendererY.new(root, {});
        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
          maxDeviation: 0,
          min: 0,
          extraMax: 0.1,
          renderer: yRenderer
        }));

        yRenderer.grid.template.setAll({
          strokeDasharray: [2, 2]
        });

        // Create series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
          name: "Series 1",
          xAxis: xAxis,
          yAxis: yAxis,
          valueYField: "value",
          sequencedInterpolation: true,
          categoryXField: "name",
          tooltip: am5.Tooltip.new(root, {
            dy: -25,
            labelText: "{valueY}"
          })
        }));


        series.columns.template.setAll({
          cornerRadiusTL: 5,
          cornerRadiusTR: 5,
          strokeOpacity: 0
        });

        series.columns.template.adapters.add("fill", (fill, target) => {
          return chart.get("colors").getIndex(series.columns.indexOf(target));
        });

        series.columns.template.adapters.add("stroke", (stroke, target) => {
          return chart.get("colors").getIndex(series.columns.indexOf(target));
        });

        // Set data
        var data = [
          <?php
          foreach ($solicitudesXempresas as $item) {
            echo '{
              name: "' . $item[1] . '",
              value: ' . $item[2] . ',
              bulletSettings: { src: "' . $item[0] . '" }
            },' . PHP_EOL;
          }

          ?>

        ];

        series.bullets.push(function() {
          return am5.Bullet.new(root, {
            locationY: 1,
            sprite: am5.Picture.new(root, {
              templateField: "bulletSettings",
              width: 50,
              height: 50,
              centerX: am5.p50,
              centerY: am5.p50,
              shadowColor: am5.color(0x000000),
              shadowBlur: 4,
              shadowOffsetX: 4,
              shadowOffsetY: 4,
              shadowOpacity: 0.6
            })
          });
        });

        xAxis.data.setAll(data);
        series.data.setAll(data);

        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        series.appear(1000);
        chart.appear(1000, 100);

      }); // end am5.ready()   
    }

    grafico5()





  <?php } ?>














  // PRIMER GRAFICO //
  var root = am5.Root.new("chart_estrategicos");
  root.setThemes([
    am5themes_Animated.new(root),
    am5themes_Material.new(root),
  ]);
  var chart2 = root.container.children.push(am5percent.PieChart.new(root, {
    layout: root.verticalLayout,
    innerRadius: am5.percent(70)
  }));
  var series = chart2.series.push(am5percent.PieSeries.new(root, {
    valueField: "value",
    categoryField: "category",
    alignLabels: false
  }));
  series.labels.template.setAll({
    textType: "circular",
    centerX: 0,
    centerY: 0,
    forceHidden: true

  });
  series.ticks.template.setAll({
    forceHidden: true
  });

  series.data.setAll([{
    value: <?php echo $operaciones_cerradas ?>,
    category: "Cerradas"
  }, {
    value: <?php echo $operaciones_abiertas ?>,
    category: "Abiertas"
  }]);


  series.appear(1000, 100);
  // PRIMER GRAFICO //





  /* SEGUNDO GRAFICO  */

  var root2 = am5.Root.new("chart_contingecias");
  root2.setThemes([
    am5themes_Animated.new(root2),
    am5themes_Material.new(root2),
    //am5themes_Dataviz.new(root2),
  ]);
  var chart2 = root2.container.children.push(am5percent.PieChart.new(root2, {
    layout: root2.verticalLayout,
    innerRadius: am5.percent(70)
  }));
  var series2 = chart2.series.push(am5percent.PieSeries.new(root2, {
    valueField: "value",
    categoryField: "category",
    alignLabels: false
  }));
  series2.labels.template.setAll({
    textType: "circular",
    centerX: 0,
    centerY: 0,
    forceHidden: true

  });
  series2.ticks.template.setAll({
    forceHidden: true
  });



  series2.data.setAll([

    {
      value: <?php echo $operaciones_p_estrategico ?>,
      category: "Estratégicos"
    }, {
      value: <?php echo $operaciones_p_contingencia ?>,
      category: "Contingencia"
    }, {
      value: <?php echo $operaciones_p_sectorial ?>,
      category: "Sectorial"
    }
  ]);



  series2.appear(1000, 100);
  /* SEGUNDO GRAFICO  */



  function filter(q, v) {
    var prop
    var query
    if (q) {
      prop = q
      query = v
    } else {
      if ($('#ano_filtro').val() == '') {
        return
      }
      prop = 'a'
      query = $('#ano_filtro').val()
    }
    location.href = "../../back/ajax/go_rendimiente_filtro.php?" + prop + "=" + query;
  }


  $("#ano_filtro" + " option[value='<?php echo $ano ?>']").attr("selected", true);



  $('#cant_op').html("<?php echo $operaciones_cerradas + $operaciones_abiertas ?>")
  $('#cant_op2').html("<?php echo $operaciones_cerradas + $operaciones_abiertas ?>")

  $('#cant_p').html("<?php echo $total_personas ?>")
  $('#cant_c').html("<?php echo $total_comunidades ?>")
  $('#cant_cas').html("<?php echo $total_comunas ?>")

  <?php

  if (@$_SESSION['filter_t'] != '') {
    echo "$('#b_" . $_SESSION['filter_t'] . "').addClass('active')";
  } else {
    echo "$('#b_0').addClass('active')";
  }


  ?>
</script>

</html>