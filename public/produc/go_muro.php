<?php
include('../../back/config/conexion.php');
include('../../back/config/funcione_globales.php');

$trimestre = trimestre();
$ano = date('Y');

$trimestre_pasado = trimestre();
if ($trimestre_pasado == 1 || $trimestre_pasado == 01) {
  $ano_trimstre_pasado = date('Y') - 1;
  $trimestre_pasado = 4;
} else {
  $ano_trimstre_pasado = date('Y');
  $trimestre_pasado -= 1;
}


?>
<!DOCTYPE html>

<html lang="es" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title class="go" id="title">Gestión operativa</title>
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
  <script src="../../js/sweetalert2.all.min.js"></script>
  <link rel="stylesheet" href="../../assets/vendor/calendar/theme1.css" />
  <script src="../../assets/vendor/libs/jquery/jquery.js"></script>

  <style>
    .table>:not(caption)>*>* {
      padding: 2px !important;
    }
  </style>

  <style>
    .stories-container {
      width: 100%;
      position: relative;
    }

    .stories-container .previous-btn,
    .stories-container .next-btn,
    .stories-full-view .previous-btn,
    .stories-full-view .next-btn {
      width: 30px;
      position: absolute;
      z-index: 2;
      top: 50%;
      transform: translateY(-50%);
      background: #444;
      color: #fff;
      border-radius: 50%;
      padding: 10px;
      display: flex;
      cursor: pointer;
    }

    .stories-container .previous-btn,
    .stories-container .next-btn {
      opacity: 0;
      pointer-events: none;
      transition: all 400ms ease;
    }

    .stories-container .previous-btn.active4,
    .stories-container .next-btn.active4 {
      opacity: 1;
      pointer-events: auto;
    }

    .stories-container .previous-btn,
    .stories-full-view .previous-btn {
      left: 8px;
    }

    .stories-container .next-btn,
    .stories-full-view .next-btn {
      right: 8px;
    }

    .stories-container .story {
      height: 180px;
      width: 120px;
      flex-shrink: 0;
      border-radius: 16px;
      overflow: hidden;
      position: relative;
      cursor: pointer;
    }

    .stories-container .story img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .stories-container .stories {
      display: flex;
      gap: 8px;
    }

    .stories-container .content {
      overflow-x: scroll;
      scrollbar-width: none;
      scroll-behavior: smooth;
    }

    .stories-container .content::-webkit-scrollbar {
      display: none;
    }

    .stories-container .author {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      padding: 8px 16px;
      font-size: 15px;
      font-family: "Roboto", sans-serif;
      font-weight: bold;
      color: #fff;
      background: linear-gradient(transparent, #222 130%);
    }

    .stories-full-view {
      position: fixed;
      inset: 0;
      z-index: 5;
      background: rgba(0, 0, 0, 0.9);
      display: none;
      place-items: center;
    }

    .stories-full-view.active4 {
      display: grid;
      z-index: 9999;
    }

    .stories-full-view .close-btn {
      position: absolute;
      top: 16px;
      left: 16px;
      width: 30px;
      background: #444;
      color: #fff;
      border-radius: 50%;
      padding: 10px;
      display: flex;
      z-index: 20;
      cursor: pointer;
    }

    .stories-full-view .content {
      height: 90vh;
      width: 100%;
      max-width: 700px;
      position: relative;
    }

    .stories-full-view .story {
      height: 100%;
      text-align: center;
    }

    .stories-full-view .story img {
      height: 100%;
      aspect-ratio: 10/16;
      object-fit: cover;
      border-radius: 16px;
    }

    .stories-full-view .author {
      position: absolute;
      bottom: 8px;
      left: 50%;
      transform: translateX(-50%);
      font-family: "Roboto", sans-serif;
      font-size: 18px;
      background: rgba(0, 0, 0, 0.6);
      color: #fff;
      padding: 4px 32px;
      border-radius: 8px;
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
          <div class="container-xxl flex-grow-1 container-p-y">
            <!-- 
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gestión Operativa /</span> Muro de operaciones</h4>
           -->
            <div class="row">
              <div class="col-lg-7 animated fadeInUp v-muro">




                <section class="row mb-3" id="sect_tareasRealizadas">
                  <div class="stories-container">
                    <div class="content">
                      <div class="previous-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                      </div>

                      <div class="stories"></div>
                      <div class="next-btn active4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                      </div>
                    </div>
                  </div>
                </section>

                <div class="row">
                  <div class="col-lg-12">
                    <div class=" d-flex justify-content-between">
                      <div class="input-group input-group-merge">
                        <span class="input-group-text">

                          <?php

                          if (file_exists('../../assets/img/avatars/' . $_SESSION['u_id'] . '.png')) {
                            echo ' <img src="../../assets/img/avatars/' . $_SESSION['u_id'] . '.png" alt="logo ' . $_SESSION['u_ente'] . '" class="w-px-40 rounded-circle w20 h20" title="' . $_SESSION['u_ente'] . '">';
                          } else {
                            echo '<div class="bg-primary rounded-circle avatar-l">' . substr($_SESSION['u_ente'], 0, 1) . '</div>';
                          }

                          ?>

                        </span>
                        <input data-bs-toggle="modal" data-bs-target="#nueva_operacion_modal" type="text" id="basic-icon-default-email" class="form-control" placeholder="Nueva operación" aria-label="Nueva operación" aria-describedby="basic-icon-default-email2">
                        <span id="basic-icon-default-email2" class="input-group-text"><i class="bx bx-plus"></i></span>
                      </div>
                      <button type="button" onclick="$('#calendario').toggle()" title="Ver el calendario de tareas" class="btn btn-icon ms-2 me-2 btn-outline-primary">
                        <span class="tf-icons bx bx-calendar"></span>
                      </button>
                      <button data-bs-toggle="collapse" href="#filtro_Section" role="button" aria-expanded="false" aria-controls="filtro_Section" type="button" title="Filtrar" class="btn btn-icon me-2 btn-outline-primary">
                        <span class="tf-icons bx bx-filter-alt"></span>
                      </button>
                      <button data-bs-toggle="collapse" href="#order_Section" role="button" aria-expanded="false" aria-controls="order_Section" type="button" title="Ordenar" title="Ordenar" class="btn btn-icons btn-outline-primary">
                        <span class="tf-icons bx bx-sort"></span>
                      </button>

                    </div>
                    <div class="divider m-3">
                    </div>

                    <div class="collapse mb-3 " id="filtro_Section">
                      <div class="d-grid  p-3 border rounded">

                        <table class="table table-borderless">
                          <thead>
                            <tr>
                              <th>Fecha de carga</th>
                              <th>Tipo</th>
                              <th>Características</th>
                            </tr>
                          </thead>
                          <tbody>

                            <tr>
                              <td>
                                <a onclick="filtrar('mes')" class="pointer span_filter" id="mes">Este mes <i class="mes icono_filter bx bx-filter-alt"></i> </a>
                              </td>
                              <td>
                                <a onclick="filtrar('contingencias')" class="pointer span_filter" id="contingencias ">Contingencias <i class="contingencias icono_filter bx bx-filter-alt"></i> </a>
                              </td>
                              <td>
                                <a onclick="filtrar('ejecutado')" class="pointer span_filter" id="ejecutado">Ejecutado <i class="ejecutado icono_filter bx bx-filter-alt"></i> </a>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <a onclick="filtrar('este_trimestre')" class="pointer span_filter" id="este_trimestre">Este trimestre <i class="este_trimestre icono_filter bx bx-filter-alt"></i> </a>
                              </td>
                              <td>
                                <a onclick="filtrar('estrategicos')" class="pointer span_filter" id="estrategicos">Estratégicos <i class="estrategicos icono_filter bx bx-filter-alt"></i> </a>
                              </td>
                              <td>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <a onclick="filtrar('mes_pasado')" class="pointer span_filter" id="mes_pasado">Mes pasado <i class="mes_pasado icono_filter bx bx-filter-alt"></i> </a>
                              </td>
                              <td>
                                <a onclick="filtrar('operacionales')" class="pointer span_filter" id="operacionales">Sectoriales <i class="operacionales icono_filter bx bx-filter-alt"></i> </a>
                              </td>
                              <td>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <a onclick="filtrar('trimestre_pasado')" class="pointer span_filter" id="trimestre_pasado">Trimestre pasado <i class="trimestre_pasado icono_filter bx bx-filter-alt"></i> </a>
                              </td>
                              <td>
                              </td>
                              <td>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <div class="collapse mb-3 " id="order_Section">
                      <div class="d-grid  p-3 border rounded">

                        <table class="table table-borderless">
                          <thead>
                            <tr>
                              <th>Ordenar</th>
                            </tr>
                          </thead>
                          <tbody>

                            <tr>
                              <td>
                                <a onclick="sort('fecha_a')" class="pointer span_sort" id="fecha_a">Fecha de carga (Asc)<i class="fecha_a icono_sort bx sort-a-z"></i> </a>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <a onclick="sort('fecha_d')" class="pointer span_sort" id="fecha_d ">Fecha de carga (Desc)<i class="fecha_d icono_sort bx bx-sort-z-a"></i> </a>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <a onclick="sort('tipo_a')" class="pointer span_sort" id="tipo_a">Tipo de plan (Asc)<i class="tipo_a icono_sort bx bx-sort-a-z"></i> </a>
                              </td>
                            </tr>

                            <tr>
                              <td>
                                <a onclick="sort('tipo_d')" class="pointer span_sort" id="tipo_d">Tipo de plan (Desc)<i class="tipo_d icono_sort bx bx-sort-z-a"></i> </a>
                              </td>
                            </tr>











                          </tbody>
                        </table>
                      </div>
                    </div>

                    <div>

                      <section id="operaciones">
                      </section>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-5 mb-4"> <!-- Vista derecha -->


                <div class="row padding_muro_right">

                  <div class="col-lg-12 mb-3 animated fadeInRight" id="calendario" style="display: none;">
                    <div class="card mb-3 h-100">
                      <div class="card-body">
                        <h5 h5 class="card-title">Calendario de tareas pendientes </h5>
                        <div class="demo-inline-spacing mt-4">
                          <div id="caleandar"></div>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="col-lg-6 mb-3">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between">
                          <div class="card-info">
                            <p class="card-text">Tareas creadas</p>
                            <div class="d-flex align-items-end mb-2">
                              <h4 class="card-title mb-0 me-2"> <?php echo $tareas_creadas = contar("SELECT count(*) FROM go_tareas WHERE trimestre='$trimestre' AND ano='$ano' "); ?> </h4>

                              <?php
                              $tareas_creadas_pasado = contar("SELECT count(*) FROM go_tareas WHERE trimestre='$trimestre_pasado' AND ano='$ano_trimstre_pasado' ");

                              if ($tareas_creadas_pasado == '0') {
                                echo '<small class="text-success">(+100%)</small>';
                              } else {

                                $t_r = obtenerCambioPorcentaje($tareas_creadas_pasado, $tareas_creadas);

                                if ($t_r > 0) {
                                  echo '<small class="text-success">(' . $t_r . '%)</small>';
                                } else {
                                  echo '<small class="text-danger">(-' . $t_r . '%)</small>';
                                }
                              }

                              ?>
                            </div>
                            <small>Análisis del trimestre</small>
                          </div>
                          <div class="card-icon">
                            <span class="badge bg-label-primary rounded p-2">
                              <i class="bx bx-star bx-sm"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 mb-3">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between">
                          <div class="card-info">
                            <p class="card-text">Tareas ejecutadas</p>
                            <div class="d-flex align-items-end mb-2">
                              <h4 class="card-title mb-0 me-2"> <?php echo $tareas_cerradas = contar("SELECT count(*) FROM go_tareas WHERE trimestre='$trimestre' AND ano='$ano' AND status='1'") ?> </h4>

                              <?php
                              $tareas_cerradas_pasado = contar("SELECT count(*) FROM go_tareas WHERE trimestre='$trimestre_pasado' AND ano='$ano_trimstre_pasado' AND ano='$ano' AND status='1'");

                              if ($tareas_cerradas_pasado == 0) {
                                echo '<small class="text-success">(+100%)</small>';
                              } else {

                                $tc_r = obtenerCambioPorcentaje($tareas_cerradas_pasado, $tareas_cerradas);

                                if ($tc_r > 0) {
                                  echo '<small class="text-success">(' . $tc_r . '%)</small>';
                                } else {
                                  echo '<small class="text-danger">(' . $tc_r . '%)</small>';
                                }
                              }

                              ?>

                            </div>
                            <small>Análisis del trimestre</small>
                          </div>
                          <div class="card-icon">
                            <span class="badge bg-label-primary rounded p-2">
                              <i class="bx bx-task bx-sm"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 mb-3">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between">
                          <div class="card-info">
                            <p class="card-text">Operaciones creadas</p>
                            <div class="d-flex align-items-end mb-2">
                              <h4 class="card-title mb-0 me-2"> <?php echo $op = contar("SELECT count(*) FROM go_operaciones WHERE  trimestre='$trimestre' AND ano='$ano'"); ?> </h4>

                              <?php
                              $op_pasado = contar("SELECT count(*) FROM go_operaciones WHERE trimestre='$trimestre_pasado' AND ano='$ano_trimstre_pasado' AND ano='$ano'");

                              if ($op_pasado == 0) {
                                echo '<small class="text-success">(+100%)</small>';
                              } else {

                                $op_r = obtenerCambioPorcentaje($op_pasado, $op);

                                if ($ops_r > 0) {
                                  echo '<small class="text-success">(' . $ops_r . '%)</small>';
                                } else {
                                  echo '<small class="text-danger">(' . $ops_r . '%)</small>';
                                }
                              }

                              ?>
                            </div>
                            <small>Análisis del trimestre</small>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 mb-3">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between">
                          <div class="card-info">
                            <p class="card-text">Operaciones cerradas</p>
                            <div class="d-flex align-items-end mb-2">
                              <h4 class="card-title mb-0 me-2"> <?php echo $op_cerradas = contar("SELECT count(*) FROM go_operaciones WHERE trimestre='$trimestre' AND ano='$ano' AND cerrado='1'"); ?> </h4>
                              <?php
                              $op_cerradas_pasado = contar("SELECT count(*) FROM go_operaciones WHERE trimestre='$trimestre_pasado' AND ano='$ano_trimstre_pasado' AND ano='$ano' AND cerrado='1'");

                              if ($op_cerradas_pasado == 0) {
                                echo '<small class="text-success">(+100%)</small>';
                              } else {
                                $ops_r = $op_cerradas * 100 / $op_cerradas_pasado;
                                if ($ops_r < 0) {
                                  echo '<small class="text-success">(' . $ops_r . '%)</small>';
                                } else {
                                  echo '<small class="text-danger">(-' . $ops_r . '%)</small>';
                                }
                              }

                              ?>
                            </div>
                            <small>Análisis del trimestre</small>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <hr>
                  </div>
                  <div class="col-lg-12">
                    <div class="card mb-3 h-100">
                      <div class="card-body">
                        <h5 h5 class="card-title"><?php echo ($_SESSION["u_nivel"] == '1' ? 'Operaciones de las empresas' : 'Operaciones de ' . $_SESSION["u_ente"]) ?></h5>
                        <div class="demo-inline-spacing mt-4">

                          <input id="resaltar" onkeyup="search(this.value)" type="text" class="form-control" placeholder="Buscar..." />



                          <div class="table-responsive text-nowrap">
                            <table class="table table-hover table-borderless">
                              <thead>
                                <tr>
                                  <th></th>
                                  <th></th>
                                </tr>
                              </thead>
                              <tbody class="table-border-bottom-0" id="op-user-emp">
                              </tbody>
                            </table>
                          </div>


                        </div>
                      </div>
                    </div>
                  </div>

                  <script>
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
                  </script>


                </div>



              </div>
            </div>
            <!--/ Card layout -->
          </div>
          <!-- / Content -->
          <div class="modal fade" id="nueva_operacion_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title"> <i class="bx bxs-analyse"></i> Nueva Operación</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                  <?php if ($_SESSION["u_nivel"] == '1') { ?>
                    <div class=" mb-3">
                      <label for="empresa" class="form-label">Empresa/Institución</label>
                      <select id="empresa" class="form-control">
                        <option value="">Seleccione</option>
                        <?php
                        $stmt = mysqli_prepare($conexion, "SELECT * FROM `system_users` WHERE u_nivel = '2' AND u_ente!='$_SESSION[u_ente]'");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['u_id'] . '">' . $row['u_ente'] . '</option>';
                          }
                        }
                        ?>
                      </select>
                    </div>


                  <?php } ?>


                  <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de plan</label>
                    <select class="form-select" id="tipo" <?php if ($_SESSION["u_nivel"]) {
                                                            echo 'onchange="tipoPlan(this.value)" ';
                                                          } ?>>
                      <option value="">Seleccione</option>
                      <option value="3">Plan de contingencia</option>
                      <?php
                      if ($_SESSION["u_nivel"] == '1') {
                        echo '
                        <option value="1">Plan sectorial</option>
                        <option value="2">Plan estratégico</option>
                        ';
                      }
                      ?>
                    </select>
                  </div>
                  <script>
                    function tipoPlan(val) {
                      if (val == 1) {
                        $('#section_sectorial').show(300)
                        $('#section_estrategico').hide()
                      } else if (val == 2) {
                        $('#section_sectorial').hide()
                        $('#section_estrategico').show(300)
                        }else{
                        $('#section_sectorial').hide()
                        $('#section_estrategico').hide()
                      }
                    }
                  </script>

                  <?php
                  if ($_SESSION["u_nivel"] == '1') {
                    echo '
                        <section id="section_sectorial" class="hide">

                          <div class="mb-3">
                            <label for="plan_sectorial" class="form-label">Plan Sectorial</label>
                            <select class="form-select" id="plan_sectorial" onchange="obt_sectores(this.value)">
                              <option value="">Seleccione</option>';
                    $this_year = date('Y');
                    $next_year = date('Y') + 1;

                    $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_planes` WHERE ano >= '$this_year' AND ano <= '$next_year' AND tipo='1'");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        $id = $row['id'];
                        $y =  $row['ano'];
                        echo '<option value="' . $id . '">Plan ' . $y . '</option>';
                      }
                    }
                    echo '
                            </select>
                          </div>

                          <div class="mb-3">
                          <label for="plan_sector" class="form-label">Sector</label>
                          <select class="form-select" id="plan_sector">
                            <option value="">Seleccione</option>
                          </select>
                        </div>
    
    
                      </section>';



                    echo '
                        <section id="section_estrategico" class="hide">

                          <div class="mb-3">
                            <label for="plan_estrategico" class="form-label">Plan Estratégico</label>
                            <select class="form-select" id="plan_estrategico" >
                              <option value="">Seleccione</option>';
                    $this_year = date('Y');
                    $next_year = date('Y') + 1;

                    $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_planes` WHERE ano >= '$this_year' AND ano <= '$next_year' AND tipo='2' AND cerrado='0'");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        $id = $row['id'];
                        $y =  $row['ano'];
                        echo '<option value="' . $id . '">' . $row['nombre'] . '</option>';
                      }
                    }
                    echo '
                            </select>
                          </div>

    
    
                      </section>';
                  }
                  ?>






                  <div class="mb-3">
                    <label for="nombre_o" class="form-label">Nombre de la operación</label>
                    <div class="input-group input-group-merge">
                      <input onkeyup="max_caracteres(this.value, 'res_car_nombre', 'nombre_o', 70)" type="text" class="form-control" placeholder="Nombre de la operación" id="nombre_o">
                      <span class="input-group-text" id="res_car_nombre">70</span>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="descripcion_o" class="form-label">Descripción de la operación</label>
                    <div class="input-group input-group-merge speech-to-text">
                      <textarea onkeyup="max_caracteres(this.value, 'res_car_descripcion', 'descripcion_o', 250)" class="form-control" placeholder="Describa la operación" rows="3" id="descripcion_o"></textarea>
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
                  <button type="button" class="btn btn-primary" id="n_operacion">Guardar operación</button>
                </div>
              </div>
            </div>
          </div>


          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>
    <?php require('../includes/alerts.html'); ?>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->
  <!-- Core JS -->

  <div class="stories-full-view">
    <div class="close-btn">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </div>

    <div class="content">
      <div class="previous-btn">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
      </div>

      <div class="story">
        <img src="images/3.jpg" alt="" />
        <div class="author">Author</div>
      </div>

      <div class="next-btn">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
      </div>
    </div>
  </div>

  <?php
  $contador = 0;

  $stmt = mysqli_prepare($conexion, "SELECT go_tareas.id_tarea, go_tareas.tipo_ejecucion, go_tareas.mr_4, go_tareas.mr_3, go_tareas.mr_2, go_tareas.mr_1, go_tareas.tarea, go_tareas.descripcion, go_tareas.id_tarea, system_users.u_ente FROM `go_tareas`
  LEFT JOIN system_users ON system_users.u_id = responsable_ente_id
   WHERE status='1' OR status='2' ORDER BY id_tarea DESC");
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    echo "<script>
    const allStories = [";
    while ($row = $result->fetch_assoc()) {

      $id = $row['id_tarea'];

      if ($row['tipo_ejecucion'] == '1') {
        $photo = $id . '_1';
      } else {
        if ($row['mr_4'] != '') {
          $photo = 't4_' . $id . '_1';
        } elseif ($row['mr_3'] != '') {
          $photo = 't3_' . $id . '_1';
        } elseif ($row['mr_2'] != '') {
          $photo = 't2_' . $id . '_1';
        } elseif ($row['mr_1'] != '') {
          $photo = 't1_' . $id . '_1';
        }
      }



      echo '{id: ' . $contador++ . ',
            author: "<strong>' . $row['tarea'] . '</strong><br><small class=\"text-muted\">' . trim(recortar_palabras($row['descripcion'])) . '</small><br><a href=\'go_tarea.php?t=' . $row['id_tarea'] . '\'>Ver la tarea</a>",
            imageUrl: "../../assets/img/tareas/' . $photo . '.png",
            empresa: \'' . $row['u_ente'] . '\'
            },';
    } ?>
    ];

    const stories = document.querySelector(".stories");
    const storiesFullView = document.querySelector(".stories-full-view");
    const closeBtn = document.querySelector(".close-btn");
    const storyImageFull = document.querySelector(".stories-full-view .story img");
    const storyAuthorFull = document.querySelector(
    ".stories-full-view .story .author"
    );
    const nextBtn = document.querySelector(".stories-container .next-btn");
    const previousBtn = document.querySelector(".stories-container .previous-btn");
    const storiesContent = document.querySelector(".stories-container .content");
    const nextBtnFull = document.querySelector(".stories-full-view .next-btn");
    const previousBtnFull = document.querySelector(
    ".stories-full-view .previous-btn"
    );

    let currentActive = 0;

    const createStories = () => {
    allStories.forEach((s, i) => {
    const story = document.createElement("div");
    story.classList.add("story");
    const img = document.createElement("img");
    img.src = s.imageUrl;
    const author = document.createElement("div");
    author.classList.add("author");
    author.innerHTML = s.author;

    const author2 = document.createElement("div");
    author2.classList.add("author");
    author2.innerHTML = s.empresa;


    story.appendChild(img);
    story.appendChild(author2);




    stories.appendChild(story);

    story.addEventListener("click", () => {
    showFullView(i);
    });
    });
    };

    createStories();

    const showFullView = (index) => {
    currentActive = index;
    updateFullView();
    storiesFullView.classList.add("active4");
    };

    closeBtn.addEventListener("click", () => {
    storiesFullView.classList.remove("active4");
    });

    const updateFullView = () => {
    storyImageFull.src = allStories[currentActive].imageUrl;
    storyAuthorFull.innerHTML = allStories[currentActive].author;
    };

    nextBtn.addEventListener("click", () => {
    storiesContent.scrollLeft += 300;
    });

    previousBtn.addEventListener("click", () => {
    storiesContent.scrollLeft -= 300;
    });

    storiesContent.addEventListener("scroll", () => {
    if (storiesContent.scrollLeft <= 24) { previousBtn.classList.remove("active4"); } else { previousBtn.classList.add("active4"); } let maxScrollValue=storiesContent.scrollWidth - storiesContent.clientWidth - 24; if (storiesContent.scrollLeft>= maxScrollValue) {
      nextBtn.classList.remove("active4");
      } else {
      nextBtn.classList.add("active4");
      }
      });

      nextBtnFull.addEventListener("click", () => {
      if (currentActive >= allStories.length - 1) {
      return;
      }
      currentActive++;
      updateFullView();
      });

      previousBtnFull.addEventListener("click", () => {
      if (currentActive <= 0) { return; } currentActive--; updateFullView(); }); </script>

      <?php } else { ?>
        <script>
          $('#sect_tareasRealizadas').html('<div class="col-lg-6"><div class="loader-img"></div></div><div class="col-lg-4"><div class="loader-img"></div></div><div class="col-lg-2"><div class="loader-img"></div></div> ')
        </script>
      <?php } ?>


      <!-- build:js assets/vendor/js/core.js -->
      <script src="../../assets/vendor/libs/popper/popper.js"></script>
      <script src="../../assets/vendor/js/bootstrap.js"></script>
      <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
      <script src="../../assets/vendor/js/menu.js"></script>
      <script src="../../assets/js/main.js"></script>
      <script src="../../assets/js/ui-popover.js"></script>
      <script type="text/javascript" src="../../assets/vendor/calendar/caleandar.js"></script>

      <script>
        /* calendario */

        var settings = {};
        var calendar_div = document.getElementById('caleandar');

        function uptate_calendar() {
          $.get("../../back/ajax/go_sectores_calendar.php", "i=all", function(data) {
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

        var order = false;
        var filter = false;

        function filtrar(params) {
          $('.icono_filter').hide()
          $('.' + params).show()
          $('.span_filter').removeClass('fw-bold')
          $('#' + params).addClass('fw-bold')
          filter = params;
          obt_operacion(order, filter)
        }

        function sort(params) {
          $('.icono_sort').hide()
          $('.' + params).show()
          $('.span_sort').removeClass('fw-bold')
          $('#' + params).addClass('fw-bold')
          order = params;
          obt_operacion(order, filter)
        }

        $(document).click(function(e) {
          if (!$(e.target).is('.collapse')) {
            $('.collapse').collapse('hide');
          }
        });

        /* OBTENER OPERACIONES */
        function obt_operacion(order, filter) {
          $('#operaciones').html('<span class="loader-contenido"></span>')
          $('.container-loader').show()

          $.get("../../back/ajax/go_muro_operaciones.php", "o=" + order + "&f=" + filter, function(data) {
            $('#operaciones').html(data)
            $('.container-loader').hide()

          });
        }
        obt_operacion(order, filter)
        /* END OF: OBTENER OPERACIONES */

        /* OBTENER SECTORES */
        function obt_sectores(value) {
          $('#plan_sector').html('<option value="">Seleccione</option>')
          $('.container-loader').show()
          $.get("../../back/ajax_selects/go_sectores.php", "plan=" + value, function(data) {
            $('#plan_sector').append(data)
            $('.container-loader').hide()
          });
        }
        /* END OF: OBTENER SECTORES */


        /* OBTENER OPERACIONES EMPRESA ESP */
        function obt_operation_user_emp() {
          $('.container-loader').show()
          $.get("../../back/ajax/go_muro-operaciones-user-emp.php", "", function(data) {
            $('.container-loader').hide()
            $('#op-user-emp').html(data)
          });
        }
        obt_operation_user_emp()
        /* END OF: OBTENER OPERACIONES EMPRESA ESP */

        /* NUEVA OPERACIÓN */
        $(document).ready(function() {
          function nuevo_registro() {
            let tipo = $('#tipo').val()
            let nombre_o = $('#nombre_o').val()
            let descripcion_o = $('#descripcion_o').val()
            var empresa = ''
            let plan = '0';
            let plan_sector = ''

            if (tipo == '1') {
              plan = $('#plan_sectorial').val()
              plan_sector = $('#plan_sector').val()
            } else if (tipo == '2') {
              plan = $('#plan_estrategico').val()
            }


            if (tipo == '' || nombre_o == '' || descripcion_o == '') {
              toast_s('warning', 'Error: Hay campos vacíos.')
              return;
            }

            if (tipo == '1' && plan == '' || tipo == '1' && plan_sector == '') {
              toast_s('warning', 'Error: Hay campos vacíos.')
              return;
            }

            if (tipo == '2' && plan == '') {
              toast_s('warning', 'Error: Hay campos vacíos.')
              return;
            }

            if ("<?php echo $_SESSION['u_nivel'] ?>" == '1') {
              empresa = $('#empresa').val()
              if (empresa == '') {
                toast_s('warning', 'Error: Hay campos vacíos.')
                return;
              }
            }

            $('button').attr('disabled', true);
            $('.container-loader').show();
            $('.container-loader').show()
            $.ajax({
              type: 'POST',
              url: '../../back/ajax/go_muro_nueva_operacion.php',
              dataType: 'html',
              data: {
                tipo: tipo,
                plan: plan,
                plan_sector: plan_sector,
                nombre_o: nombre_o,
                descripcion_o: descripcion_o,
                empresa: empresa
              },
              cache: false,
              success: function(msg) {
                $('.container-loader').hide()
        
                if ("<?php echo $_SESSION['u_nivel'] ?>" != '1') {
                  window.location.href = 'go_operacion?i=' + msg;
                } else {

                  //actualizar el muro de operaciones
                  obt_operacion()
                  obt_operation_user_emp()
                  toast_s('success', 'La operación se registro con exito');
                  $('#nueva_operacion_modal').modal('toggle');
                  $('button').attr('disabled', false);
                  $('#loader').hide();


                  $("#empresa" + " option[value='']").attr("selected", true);
                  $("#tipo" + " option[value='']").attr("selected", true);

                  $('#nombre_o').val('');
                  $('#descripcion_o').val('');

                  $('#section_sectorial').hide();
                  $('#section_estrategico').hide();
                }
                $('.container-loader').hide();
              }
            }).fail(function(jqXHR, textStatus, errorThrown) {
              $('.container-loader').hide()
              toast_s('warning', 'Ocurrió un error, inténtelo nuevamente ' + errorThrown)
            });
          }

          $("#n_operacion").click(nuevo_registro);
        });
        /* END OF: NUEVA OPERACIÓN */
      </script>
</body>

</html>