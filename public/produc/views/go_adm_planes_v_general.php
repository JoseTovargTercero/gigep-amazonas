<?php
include('../../../back/config/conexion.php');
require('../../../back/config/funcione_globales.php');

if ($_SESSION["u_nivel"] != '1') {
  header("Location: ../index.php");
}




$ano = $_GET["a"];






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
<script>
  var arr_estrategico_ejecutado = {
    0: "<?php echo $estrategico_ejecutado ?>",
    1: "<?php echo $estrategico_ejecutado_1 ?>",
    2: "<?php echo $estrategico_ejecutado_2 ?>",
    3: "<?php echo $estrategico_ejecutado_3 ?>",
    4: "<?php echo $estrategico_ejecutado_4 ?>",
  }

  var arr_estrategico_pendiente = {
    0: "<?php echo $_estrategico_pendiente ?>",
    1: "<?php echo $_estrategico_pendiente_1 ?>",
    2: "<?php echo $_estrategico_pendiente_2 ?>",
    3: "<?php echo $_estrategico_pendiente_3 ?>",
    4: "<?php echo $_estrategico_pendiente_4 ?>",
  }

  var arr_contingencia_ejecutado = {
    0: "<?php echo $contingencia_ejecutado ?>",
    1: "<?php echo $contingencia_ejecutado_1 ?>",
    2: "<?php echo $contingencia_ejecutado_2 ?>",
    3: "<?php echo $contingencia_ejecutado_3 ?>",
    4: "<?php echo $contingencia_ejecutado_4 ?>",
  }

  var arr_contingencia_pendiente = {
    0: "<?php echo $contingencia_pendiente ?>",
    1: "<?php echo $contingencia_pendiente_1 ?>",
    2: "<?php echo $contingencia_pendiente_2 ?>",
    3: "<?php echo $contingencia_pendiente_3 ?>",
    4: "<?php echo $contingencia_pendiente_4 ?>",
  }

  /* PLANES */
  var arr_sec_Servicios = {
    0: "<?php echo $sec_Servicios ?>",
    1: "<?php echo $sec_Servicios_1 ?>",
    2: "<?php echo $sec_Servicios_2 ?>",
    3: "<?php echo $sec_Servicios_3 ?>",
    4: "<?php echo $sec_Servicios_4 ?>",
  }

  var arr_sec_Económico_productivo = {
    0: "<?php echo $sec_Económico_productivo ?>",
    1: "<?php echo $sec_Económico_productivo_1 ?>",
    2: "<?php echo $sec_Económico_productivo_2 ?>",
    3: "<?php echo $sec_Económico_productivo_3 ?>",
    4: "<?php echo $sec_Económico_productivo_4 ?>",
  }

  var arr_sec_Social = {
    0: "<?php echo $sec_Social ?>",
    1: "<?php echo $sec_Social_1 ?>",
    2: "<?php echo $sec_Social_2 ?>",
    3: "<?php echo $sec_Social_3 ?>",
    4: "<?php echo $sec_Social_4 ?>",
  }
</script>



<html style="overflow: hidden;">

<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="../../../assets/vendor/fonts/boxicons.css" />
  <link rel="stylesheet" href="../../../assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../../../assets/css/demo.css" />
  <link rel="stylesheet" href="../../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="../../../assets/vendor/libs/apex-charts/apex-charts.css" />

  <script src="../../../assets/js/config.js"></script>
  <link rel="stylesheet" href="../../../assets/css/animate.css" />

</head>

<body>


  <div class="row ">


    <div class="col-lg-12">

      <div class="card-header mb-4">
        <ul class="nav nav-pills" role="tablist">
          <li class="nav-item" role="presentation">
            <button id="b_0" onclick="setVals('0')" type="button" class="nav-link active">Vista anual</button>
          </li>
          <li class="nav-item" role="presentation">
            <button id="b_1" onclick="setVals('1')" type="button" class="nav-link">Primer Trimestre</button>
          </li>
          <li class="nav-item" role="presentation">
            <button id="b_2" onclick="setVals('2')" type="button" class="nav-link">Segundo Trimestre</button>
          </li>
          <li class="nav-item" role="presentation">
            <button id="b_3" onclick="setVals('3')" type="button" class="nav-link">Tercer Trimestre</button>
          </li>
          <li class="nav-item" role="presentation">
            <button id="b_4" onclick="setVals('4')" type="button" class="nav-link">Cuarto Trimestre</button>
          </li>
        </ul>
      </div>


    </div>


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
          <h4 class="text-danger mb-2">Plan Sectorial '.$_GET["a"].' </h4>
          <p class="text-body app-academy-sm-60 app-academy-xl-100">
            No hay ningún plan registrado este año.
          </p>
          <div class="mb-0"><button class="btn btn-danger" onclick="n_plan()">Iniciar Plan</button></div>
        </div>
      </div>

      <img class="img-fluid mb-3" style="height: 94px;" src="../../../assets/img/illustrations/girl-app-academy.png" alt="girl illustration">



    </div>
     </div>';
      } else {
      ?>

        <div class="card mb-3">
          <div class="card-body">
            <h5 class="d-flex justify-content-between align-items-center mb-3">Plan Sectorial <?php echo $_GET["a"] ?>
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
                <p class='mt-2'>
                    <label class='form-label'>Trimestre</label>
                    <select id='trimestre_est' class='form-control'>
                      <option value=''>Seleccione</option>
                      <option value='1'>1er Trimestre</option>
                      <option value='2'>2do Trimestre</option>
                      <option value='3'>3er Trimestre</option>
                      <option value='4'>4to Trimestre</option>
                    </select>
                  </p>
                <div>
                <p class='mt-2'>
                    <label class='form-label'>Nombre del plan</label>
                    <input id='nombre_est' class='form-control'>
                  </p>
                <div>
                <button type='button' onclick='nuevo_estrategico()' class='w-100 btn btn-sm btn-primary'>Guardar</button>
              </div>" title="" data-bs-original-title="Nuevo plan estratégico" aria-describedby="popover282641"  class="btn btn-sm btn-primary" >
                <span class="tf-icons bx bx-plus"></span>
                 Nuevo Plan Estratégico
              </button>

              </div>
            </div>
            <table class="table datatables-academy-course dataTable no-footer dtr-column" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 1273px;">
              <thead class="border-top">
                <tr>
                  <th style="width: 35%;">Operacion/Empresa</th>
                  <th style="width: 10%;">Creado</th>
                  <th style="width: 30%;">Progreso (Tareas ejecutadas)</th> <!-- Se mide en base a la cantidad de tareas registras entre las ejecutadas-->
                  <th style="width: 25%;">Detalles</th>
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
                      <tr class="odd t_'.$row2['trimestre'].'">
                      <td class="sorting_1">
                        <div class="d-flex align-items-center"><span class="me-3">';

                          if ($row2['tipo'] == '1') {
                            echo ' <span class="badge bg-label-success p-2">
                            <i class="fs-3">S</i>
                            </span>';
                          }else{
                            echo ' <span class="badge bg-label-primary p-2">
                            <i class="fs-3">E</i>
                            </span>';
                          }
                        echo '
                        </span>



                          <div><span class="text-heading text-truncate fw-medium mb-2 text-wrap" href="app-academy-course-details.html">'.$row2['nombre'].'</span>
                            <div class="d-flex align-items-center mt-1">';

                            
                            if (file_exists('../../assets/img/avatars/' . $_SESSION['u_id'] . '.png')) {
                              echo '  <div class="avatar-wrapper me-2">
                              <div class="avatar avatar-xs"><img src="../../assets/img/avatars/' . $_SESSION['u_id'] . '.png" alt="Avatar" class="rounded-circle">
                              </div>
                              </div>">';
                            } else {
                              echo '<div class="bg-primary rounded-circle avatar-l me-2">' . substr($_SESSION['u_nombre'], 0, 1) . '</div>';
                            }
                             echo'<span class="text-nowrap">'.$row2['u_nombre'].' - <strong>EPA</strong></span>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td><span class="fw-medium text-nowrap">'.fechaCastellano($row2['creado']).'</span></td>
                      <td>
                        <div class="d-flex align-items-center gap-3">
                          <p class="fw-medium mb-0">'.$p.'%</p>
                          <div class="progress w-100" style="height: 8px;">
                            <div class="progress-bar" style="width: '.$p.'%" aria-valuenow="'.$p.'%" aria-valuemin="0" aria-valuemax="100"></div>
                          </div><small class="text-muted">'.$tareas_ejecutadas.'/'.$tareas.'</small>
                        </div>
                      </td>
                      <td>
                        <div class="d-flex">
                          <div class="w-px-50 d-flex align-items-center" title="Operaciones"><i class="me-2 bx bx-analyse bx-xs  text-primary"></i>'. contar("SELECT count(*) FROM go_operaciones WHERE id_p='$id' ").'</div>
                          <div class="w-px-50 d-flex align-items-center" title="Tareas"><i class="me-2 bx bx-task bx-xs  text-info"></i>'. $tareas.'</div>
                        </div>
                      </td>
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

                        
                          echo '<div class="bg-primary rounded-circle avatar-l me-2">M</div>';


                         echo'<span class="text-nowrap">Múltiples usuarios - <strong>EPA/EMPRESAS</strong></span>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td><span class="fw-medium text-nowrap"></span></td>
                  <td>
                    <div class="d-flex align-items-center gap-3">
                      <p class="fw-medium mb-0">'.$p.'%</p>
                      <div class="progress w-100" style="height: 8px;">
                        <div class="progress-bar" style="width: '.$p.'%" aria-valuenow="'.$p.'%" aria-valuemin="0" aria-valuemax="100"></div>
                      </div><small class="text-muted">'.$tareas_ejecutadas.'/'.$tareas.'</small>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex">
                      <div class="w-px-50 d-flex align-items-center" title="Operaciones"><i class="me-2 bx bx-analyse bx-xs  text-primary"></i>'. contar("SELECT count(*) FROM go_operaciones WHERE id_p='$id' ").'</div>
                      <div class="w-px-50 d-flex align-items-center" title="Tareas"><i class="me-2 bx bx-task bx-xs  text-info"></i>'. $tareas.'</div>
                    </div>
                  </td>
                </tr';
                  
              }

              ?>



             

              </tbody>
            </table>
          </div>
        </div>
      </div>



  </div>

   







    <?php require('../../includes/alerts.html'); ?>

    <script src="../../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../../../assets/js/main.js"></script>
    <script src="../../../assets/js/ui-popover.js"></script>

    <script src="../../../assets/vendor/amcharts5/index.js"></script>
    <script src="../../../assets/vendor/amcharts5/flow.js"></script>
    <script src="../../../assets/vendor/amcharts5/percent.js"></script>

    <script src="../../../assets/vendor/amcharts5/themes/Animated.js"></script>
    <script src="../../../assets/vendor/amcharts5/themes/Material.js"></script>





    <script>

                  function nuevo_estrategico() {
                    let trimestre_est = $('#trimestre_est').val()
                    let nombre_est = $('#nombre_est').val()


                    if (trimestre_est == '' || nombre_est == '') {
                      return;
                    }
                    
                    $.ajax({
                      type: 'POST',
                      url: '../../../back/ajax/go_adm_planes_nuevo_plan_e.php',
                      dataType: 'html',
                      data: {
                        trimestre_est: trimestre_est,
                        nombre_est: nombre_est,
                        ano: "<?php echo $ano ?>"
                      },
                      cache: false,
                      success: function(msg) {
                        if (msg.trim() == 'ok') {
                         location.reload();
                        }else{
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

        $.ajax({
          url: '../../../back/ajax/go_adm_planes_v_general_n_plan.php',
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

          }
        }).fail(function(jqXHR, textStatus, errorThrown) {
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
      setdataG1(arr_contingencia_ejecutado[0], arr_contingencia_pendiente[0])





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

        setdataG1(arr_estrategico_ejecutado[val], arr_estrategico_pendiente[val])
        setdataG2(arr_contingencia_ejecutado[val], arr_contingencia_pendiente[val])


        $('#cant_planes_est').html(parseInt(arr_estrategico_ejecutado[val]) + parseInt(arr_estrategico_pendiente[val]))
        $('#cant_planes_cont').html(parseInt(arr_estrategico_pendiente[val]) + parseInt(arr_contingencia_pendiente[val]))

        $('#sec_Servicios').html(arr_sec_Servicios[val]) 
        $('#sec_Económico_productivo').html(arr_sec_Económico_productivo[val]) 
        $('#sec_Social').html(arr_sec_Social[val])


        $('.nav-link').removeClass('active')
        $('#b_' + val).addClass('active')
        
        if (val == '0') {
          $('.odd').show(300)
        }else{
          $('.odd').hide(300)
          $('.t_'+val).show(300)
          
        }

      }
    </script>
</body>



</html>