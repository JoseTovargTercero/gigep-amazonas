<?php
include('../../back/config/conexion.php');
include('../../back/config/funcione_globales.php');

if ($_SESSION["u_nivel"] != '1') {
  header("Location: ../index.php");
}


if (isset($_GET['a'])) {
  $ano = $_GET['a'];
} else {
  $ano = date('Y');
}





$estrategico_ejecutado_1 =  contar("SELECT count(*) FROM go_planes WHERE tipo='2' AND cerrado='1' AND ano='$ano'");
$_estrategico_pendiente_1 =  contar("SELECT count(*) FROM go_planes WHERE tipo='2' AND cerrado='0' AND ano='$ano'");
$contingencia_ejecutado_1 = contar("SELECT count(*) FROM go_operaciones WHERE tipo_p='3' AND cerrado='1' AND ano='$ano' AND trimestre='1'");
$contingencia_pendiente_1 = contar("SELECT count(*) FROM go_operaciones WHERE tipo_p='3' AND cerrado='0' AND ano='$ano' AND trimestre='1'");

/* 1ER TRIMESTRE */


$contingencia_ejecutado_2 = contar("SELECT count(*) FROM go_operaciones WHERE tipo_p='3' AND cerrado='1' AND ano='$ano' AND trimestre='2'");
$contingencia_pendiente_2 = contar("SELECT count(*) FROM go_operaciones WHERE tipo_p='3' AND cerrado='0' AND ano='$ano' AND trimestre='2'");

/* 2do TRIMESTRE */


$contingencia_ejecutado_3 = contar("SELECT count(*) FROM go_operaciones WHERE tipo_p='3' AND cerrado='1' AND ano='$ano' AND trimestre='3'");
$contingencia_pendiente_3 = contar("SELECT count(*) FROM go_operaciones WHERE tipo_p='3' AND cerrado='0' AND ano='$ano' AND trimestre='3'");

/* 3er TRIMESTRE */


$contingencia_ejecutado_4 = contar("SELECT count(*) FROM go_operaciones WHERE tipo_p='3' AND cerrado='1' AND ano='$ano' AND trimestre='4'");
$contingencia_pendiente_4 = contar("SELECT count(*) FROM go_operaciones WHERE tipo_p='3' AND cerrado='0' AND ano='$ano' AND trimestre='4'");

/* 4to TRIMESTRE */




$estrategico_ejecutado =  $estrategico_ejecutado_1;
$_estrategico_pendiente =  $_estrategico_pendiente_1;
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
<script>
  var arr_estrategico_ejecutado = {
    0: "<?php echo $estrategico_ejecutado ?>"
  }

  var arr_estrategico_pendiente = {
    0: "<?php echo $_estrategico_pendiente ?>"
  }

  var arr_contingencia_ejecutado = {
    0: "<?php echo $contingencia_ejecutado ?>"
  }

  var arr_contingencia_pendiente = {
    0: "<?php echo $contingencia_pendiente ?>"
  }

  /* PLANES */
  var arr_sec_Servicios = {
    0: "<?php echo $sec_Servicios ?>"
  }

  var arr_sec_Económico_productivo = {
    0: "<?php echo $sec_Económico_productivo ?>"
  }

  var arr_sec_Social = {
    0: "<?php echo $sec_Social ?>"
  }
</script>




<!DOCTYPE html>

<html lang="es" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title class="go" id="title">Gestor de planes</title>
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

</head>

<body>

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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gestión Operativa /</span> Planes del
                <?php

                echo $ano;

                ?>


              </h4>

              <button type="button" type="button" data-bs-toggle="popover" data-bs-offset="0,14" data-bs-placement="left" data-bs-html="true" data-bs-content="<p><select id='ano_filtro' class='form-control'><option value=''>Seleccione</option><option value='<?php echo $y_d1 ?>'><?php echo $y_d1 ?></option><option value='<?php echo $y_d ?>'><?php echo $y_d ?></option><option value='<?php echo $y_d2 ?>'><?php echo $y_d2 ?></option></select></p> <div><button type='button' onclick='filtro_ano()' class='w-100 btn btn-sm btn-primary'>Seleccionar</button></div>" title="" data-bs-original-title="Seleccione el año" aria-describedby="popover282641" class="btn btn-icon ms-2 me-2 btn-outline-primary">
                <span class="tf-icons bx bx-calendar"></span>
              </button>

            </div>


            <section>
              <!-- CONTENIDO -->


              <div class="row ">



                <div class="col-lg-4 mb-4">
                  <div class="card" style="min-height: 225px;">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div class="d-flex flex-column">
                          <div class="card-title mb-auto">
                            <h5 class="mb-0">Planes Estratégicos</h5>
                            <small>Creado por la EPA</small>
                          </div>
                          <div class="chart2-statistics">
                            <h3 class="card-title mb-1">

                              <span id="cant_planes_est"><?php echo $estrategico_ejecutado + $_estrategico_pendiente; ?> </span>


                              <small class="text-muted">Planes</small>
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


                <div class="col-lg-4 mb-4">
                  <div class="card" style="min-height: 225px;">
                    <div class="card-body">
                      <div class="d-flex justify-content-between" style="position: relative;">
                        <div class="d-flex flex-column">
                          <div class="card-title mb-auto">
                            <h5 class="mb-0">Planes de Contingencia</h5>
                            <small>Empresas o EPA</small>
                          </div>
                          <div class="chart2-statistics">
                            <h3 class="card-title ">

                              <span id="cant_planes_cont"> <?php echo $contingencia_ejecutado + $contingencia_pendiente; ?> </span>


                              <small class="text-muted">Operaciones</small>
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


                <div class="col-lg-4">



                  <?php
                  
                  if ($plan == 'No') {
                    echo ' <div class="card bg-label-danger" style="min-height: 225px;">
                <div class="card-body d-flex justify-content-between ">


                  <div class="mb-0 d-flex flex-column justify-content-between text-center text-sm-start me-3">
                    <div class="card-title">
                      <h4 class="text-danger mb-2">Plan Sectorial ' . (isset($_GET["a"]) ? $_GET["a"] : date('Y')) . ' </h4>
                      <p class="text-body app-academy-sm-60 app-academy-xl-100">
                        No hay ningún plan registrado este año.
                      </p>
                      <div class="mb-0"><button class="btn btn-danger" onclick="n_plan()">Iniciar Plan</button></div>
                    </div>
                  </div>

                  <img class="img-fluid mb-3" style="height: 94px;" src="../../assets/img/illustrations/girl-app-academy.png" alt="girl illustration">



                </div>
                </div>';
                  } else {
                  ?>

                    <div class="card mb-3">
                      <div class="card-body">
                        <h5 class="d-flex justify-content-between align-items-center mb-3">Plan Sectorial <?php echo $ano ?>
                        </h5>
                        <div class="d-flex flex-column flex-sm-row justify-content-between text-center gap-3">
                          <?php
                          $stmt_s = mysqli_prepare($conexion, "SELECT * FROM `go_sectores` WHERE id_p = ?");
                          $stmt_s->bind_param("s", $plan);
                          $stmt_s->execute();
                          $result2 = $stmt_s->get_result();
                          if ($result2->num_rows > 0) {
                            while ($row2 = $result2->fetch_assoc()) {
                              $id_s = $row2['id_s'];
                              $sector = str_replace(' ', '_', $row2['sector']);
                              echo ' <div class="d-flex flex-column align-items-center">
                  <span><i class="bx bx-task text-primary bx-md p-3 border border-primary rounded-circle border-dashed mb-0"></i></span>
                  <p class="mt-3 mb-2" style="font-weight:600">' . $row2['sector'] . '
                  </p>
                  <h5 class="text-primary mb-0" id="sec_' . $sector . '">' . contar("SELECT count(*) FROM go_operaciones WHERE id_p='$plan' AND id_s='$id_s' AND ano='$ano'") . '
                  </h5>

            </div>';
                            }
                          }
                          $stmt_s->close();

                          ?>


                        </div>
                      </div>
                    </div>



                  <?php
                  }
                  ?>









                </div>








                <div class="col-lg-12">
                  <div class="card mb-4">
                    <div class="table-responsive mb-3">
                      <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="card-header flex-column flex-md-row">
                          <div class="head-label d-flex justify-content-between ">
                            <h5 class="card-title mb-0 text-nowrap">Gestor de planes</h5>



                            <button type="button" type="button" data-bs-toggle="popover" data-bs-offset="0,14" data-bs-placement="left" data-bs-html="true" data-bs-content="
                     <div>
            <p class='mt-2'>
                <label class='form-label'>Nombre del plan</label>
                <input id='nombre_est' class='form-control'>
              </p>
            <div>
            <button type='button' onclick='nuevo_estrategico()' class='w-100 btn btn-sm btn-primary'>Guardar</button>
          </div>" title="" data-bs-original-title="Nuevo plan estratégico" aria-describedby="popover282641" class="btn btn-sm btn-primary">
                              <span class="tf-icons bx bx-plus"></span>
                              Nuevo Plan Estratégico
                            </button>

                          </div>
                        </div>
                        <table class="table datatables-academy-course dataTable no-footer dtr-column" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" >
                          <thead class="border-top">
                            <tr>
                              <th style="width: 35%;">Operacion/Empresa</th>
                              <th style="width: 10%;">Estatus</th>
                              <th style="width: 30%;">Progreso (Tareas ejecutadas)</th> <!-- Se mide en base a la cantidad de tareas registras entre las ejecutadas-->
                              <th style="width: 20%;">Detalles</th>
                              <th style="width: 5%;">Acciones</th>
                            </tr>
                          </thead>
                          <tbody>

                            <?php
                            $stmt_s = mysqli_prepare($conexion, "SELECT * FROM `go_planes` 
                                 LEFT JOIN system_users ON system_users.u_id = go_planes.user
                                 WHERE ano = ?");
                            $stmt_s->bind_param("s", $ano);
                            $stmt_s->execute();
                            $result2 = $stmt_s->get_result();
                            if ($result2->num_rows > 0) {
                              while ($row2 = $result2->fetch_assoc()) {
                                $id = $row2['id'];
                                $tareas = contar("SELECT count(*) FROM go_tareas WHERE id_plan='$id' ");
                                $tareas_ejecutadas = contar("SELECT count(*) FROM go_tareas WHERE id_plan='$id' AND status='1'");

                                $p = obteneroPorcentaje($tareas_ejecutadas, $tareas);



                                echo ' 
                  <tr class="odd t_">
                  <td class="sorting_1">
                    <div class="d-flex align-items-center"><span class="me-3">';

                                if ($row2['tipo'] == '1') {
                                  echo ' <span class="badge bg-label-success p-2">
                        <i class="fs-3">S</i>
                        </span>';
                                } else {
                                  echo ' <span class="badge bg-label-primary p-2">
                        <i class="fs-3">E</i>
                        </span>';
                                }
                                echo '
                    </span>
                      <div><span class="text-heading text-truncate fw-medium mb-2 text-wrap" href="app-academy-course-details.html">' . $row2['nombre'] . '</span>
                        <div class="d-flex align-items-center mt-1">';


                                if (file_exists('../../assets/img/avatars/' . $_SESSION['u_id'] . '.png')) {
                                  echo '  <div class="avatar-wrapper me-2">
                          <div class="avatar avatar-xs"><img src="../../assets/img/avatars/' . $_SESSION['u_id'] . '.png" alt="Avatar" class="rounded-circle">
                          </div>
                          </div>';
                                } else {
                                  echo '<div class="bg-primary rounded-circle avatar-l me-2">' . substr($_SESSION['u_nombre'], 0, 1) . '</div>';
                                }
                                echo '<span class="text-nowrap">' . $row2['u_nombre'] . ' - <strong>EPA</strong></span>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td><span class="fw-medium text-nowrap">' . ($row2['cerrado'] == '1' ? '<span class="badge bg-label-warning me-1">Cerrado</span>' : '<span class="badge bg-label-primary me-1">Abierto</span>') . '</span></td>
                  <td>
                    <div class="d-flex align-items-center gap-3">
                      <p class="fw-medium mb-0">' . $p . '%</p>
                      <div class="progress w-100" style="height: 8px;">
                        <div class="progress-bar" style="width: ' . $p . '%" aria-valuenow="' . $p . '%" aria-valuemin="0" aria-valuemax="100"></div>
                      </div><small class="text-muted">' . $tareas_ejecutadas . '/' . $tareas . '</small>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex">
                      <div class="w-px-50 d-flex align-items-center" title="Operaciones"><i class="me-2 bx bx-analyse bx-xs  text-primary"></i>' . contar("SELECT count(*) FROM go_operaciones WHERE id_p='$id' ") . '</div>
                      <div class="w-px-50 d-flex align-items-center" title="Tareas"><i class="me-2 bx bx-task bx-xs  text-info"></i>' . $tareas . '</div>
                    </div>
                  </td>
                    <td class="text-center">';
                                if ($row2['tipo'] == '2' && $row2['cerrado'] == '0') {
                                  echo '
                        <div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                          <div class="dropdown-menu">
                          <a class="dropdown-item pointer" onclick="renombrarPlan(\'' . $id . '\')"><i class="bx bx-edit-alt me-2"></i> Cambiar nombre</a>
                          <a class="dropdown-item pointer" onclick="cerrarPlan(\''.$id.'\')" ><i class="bx bx-calendar-check me-2"></i> Cerrar Plan</a>
                        </div>
                    </div>';
                                }
                                echo '</td>
                      </tr>';
                              }
                            }
                            $stmt_s->close();

                            $tareas =  contar("SELECT count(*) FROM go_tareas WHERE id_plan='0' AND ano='$ano'");
                            if ($tareas != 0) {
                              $tareas_ejecutadas =  contar("SELECT count(*) FROM go_tareas WHERE id_plan='0' AND status='1' AND ano='$ano'");


                              $p = obteneroPorcentaje($tareas_ejecutadas, $tareas);


                              echo ' 
              <tr class="odd">
              <td class="sorting_1">
                <div class="d-flex align-items-center"><span class="me-3">';

                              echo ' <span class="badge bg-label-warning p-2">
                    <i class="fs-3">C</i>
                    </span>
                </span>



                  <div><span class="text-heading text-truncate fw-medium mb-2 text-wrap" href="app-academy-course-details.html">Planes de Contingencia</span>
                    <div class="d-flex align-items-center mt-1">';


                              echo '<div class="bg-primary rounded-circle avatar-l me-2"><i class="bx bx-user mt-1" style="font-size: 13px"></i></div>';


                              echo '<span class="text-nowrap">Múltiples usuarios - <strong>EPA/EMPRESAS</strong></span>
                    </div>
                  </div>
                </div>
              </td>
              <td><span class="badge bg-label-primary me-1">Abierto</span></td>
              <td>
                <div class="d-flex align-items-center gap-3">
                  <p class="fw-medium mb-0">' . $p . '%</p>
                  <div class="progress w-100" style="height: 8px;">
                    <div class="progress-bar" style="width: ' . $p . '%" aria-valuenow="' . $p . '%" aria-valuemin="0" aria-valuemax="100"></div>
                  </div><small class="text-muted">' . $tareas_ejecutadas . '/' . $tareas . '</small>
                </div>
              </td>
              <td>
                <div class="d-flex">
                  <div class="w-px-50 d-flex align-items-center" title="Operaciones"><i class="me-2 bx bx-analyse bx-xs  text-primary"></i>' . contar("SELECT count(*) FROM go_operaciones WHERE id_p='0' ") . '</div>
                  <div class="w-px-50 d-flex align-items-center" title="Tareas"><i class="me-2 bx bx-task bx-xs  text-info"></i>' . $tareas . '</div>
                </div>
              </td>
            </tr>';
                            }

                            ?>





                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
            </section>


            <script>
              function renombrarPlan(id) {
                $('#backDropModal').modal('toggle')
                $('#p').val(id)
              }

              function save() {
                let nuevoNombre = $('#nuevoNombre').val();
                $('.container-loader').show()

                $.ajax({
                  type: 'POST',
                  url: '../../back/ajax/go_adm_planes_actualizarPlan.php',
                  dataType: 'html',
                  data: {
                    p: $('#p').val(),
                    nuevoNombre: nuevoNombre,
                  },
                  cache: false,
                  success: function(msg) {
                  $('.container-loader').hide()

                    location.reload();
                  }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                  $('.container-loader').hide()

                  console.log('Ocurrió un error, inténtelo nuevamente ' + errorThrown)
                });




              }
            </script>


            <div class="modal fade" id="backDropModal" data-bs-backdrop="static" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered" >
                <form class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="backDropModalTitle">Renombrar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <input type="text" id="p" hidden />
                      <div class=" mb-3">
                        <label for="nuevoNombre" class="form-label">Nuevo nombre</label>
                        <input type="text" id="nuevoNombre" class="form-control" placeholder="Ingrese el nuevo nombre" />
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                      Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" onclick="save()">Actualizar</button>
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


  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="../../assets/vendor/libs/popper/popper.js"></script>
  <script src="../../assets/vendor/js/bootstrap.js"></script>
  <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../../assets/vendor/js/menu.js"></script>
  <script src="../../assets/js/main.js"></script>
  <script src="../../assets/js/ui-popover.js"></script>


  <script src="../../assets/vendor/amcharts5/index.js"></script>
  <script src="../../assets/vendor/amcharts5/flow.js"></script>
  <script src="../../assets/vendor/amcharts5/percent.js"></script>
  <script src="../../assets/vendor/amcharts5/themes/Animated.js"></script>
  <script src="../../assets/vendor/amcharts5/themes/Material.js"></script>

</body>

<script>

function cerrarPlan(id) {


  Swal.fire({
      title: "¿Esta seguro?",
      icon: "warning",
      html: `Se <strong>cerrará</strong> el plan. La acción es irreversible.`,
      confirmButtonColor: "#69a5ff",
      cancelButtonText: `Cancelar`,
      showCancelButton: true,
      confirmButtonText: "Cerrar plan",
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        
          location.href="../../back/ajax/go_adm_planes_cerrarPlan.php?p="+id;
      }
    });


}


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
      $('.container-loader').hide()

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
        $('button').attr('disabled', false);
        // $('#loader').hide();
        location.reload();
        $('.container-loader').hide()

      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      $('.container-loader').hide()

      // reintentar
      toast('r', 'Ocurrió un error, inténtelo nuevamente ' + errorThrown)
    });
  }

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

  function setdataG1(val_1, val_2) {
    series.data.setAll([{
      value: val_1,
      category: "Ejecutado"
    }, {
      value: val_2,
      category: "Pendiente"
    }]);
  }



  series.appear(1000, 100);
  // PRIMER GRAFICO //
  setdataG1(arr_estrategico_ejecutado[0], arr_estrategico_pendiente[0])





  /* SEGUNDO GRAFICO  */

  var root2 = am5.Root.new("chart_contingecias");
  root2.setThemes([
    am5themes_Animated.new(root2),
    am5themes_Material.new(root2),
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



  function setdataG2(val_1, val_2) {
    series2.data.setAll([{
      value: val_1,
      category: "Ejecutado"
    }, {
      value: val_2,
      category: "Pendiente"
    }]);
  }



  series2.appear(1000, 100);
  /* SEGUNDO GRAFICO  */
  setdataG2(arr_contingencia_ejecutado[0], arr_contingencia_pendiente[0])



  function setVals(val) {

    //  setdataG1(arr_estrategico_ejecutado[val], arr_estrategico_pendiente[val])
    //  setdataG2(arr_contingencia_ejecutado[val], arr_contingencia_pendiente[val])


    // $('#cant_planes_est').html(parseInt(arr_estrategico_ejecutado[val]) + parseInt(arr_estrategico_pendiente[val]))
    // $('#cant_planes_cont').html(parseInt(arr_estrategico_pendiente[val]) + parseInt(arr_contingencia_pendiente[val]))

    //$('#sec_Servicios').html(arr_sec_Servicios[val])
    //$('#sec_Económico_productivo').html(arr_sec_Económico_productivo[val])
    //$('#sec_Social').html(arr_sec_Social[val])


    $('.nav-link').removeClass('active')
    $('#b_' + val).addClass('active')
    /*
        if (val == '0') {
          $('.odd').show(300)
        } else {
          $('.odd').hide(300)
          $('.t_' + val).show(300)

        }
    */
  }
</script>
<script>
  function filtro_ano() {
    var ano_f = $('#ano_filtro').val()
    location.href = "go_adm_planes.php?a=" + ano_f;
  }
</script>

</html>