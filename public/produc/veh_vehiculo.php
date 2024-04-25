<?php
include('../../back/config/conexion.php');
include('../../back/config/funcione_globales.php');

if ($_SESSION["u_nivel"] != '1' && $_SESSION["u_nivel"] != '2' && $_SESSION["u_nivel"] != '3') {
  header("Location: ../index.php");
}


$id = $_GET["i"];




$stmt = mysqli_prepare($conexion, "SELECT * FROM `veh_vehiculos`
  LEFT JOIN system_users ON system_users.u_id=veh_vehiculos.empresa_id
   WHERE id = ?");
$stmt->bind_param('s', $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {


    $tipo_vehiculo = $row["tipo_vehiculo"]; // LISTO
    $marca = $row["marca"]; // LISTO
    $modelo = $row["modelo"]; // LISTO
    $ano = $row["ano"]; // LISTO
    $valor = $row["valor"]; // LISTO
    $tipo_combustible = $row["tipo_combustible"];
    $capacidad_tanque = $row["capacidad_tanque"];
    $liga_frenos = $row["liga_frenos"];
    $cantidad_liga_frenos = $row["cantidad_liga_frenos"];
    $aceite_motor = $row["aceite_motor"];
    $marca_aceite = $row["marca_aceite"];
    $cantidad_aceite = $row["cantidad_aceite"];
    $unidad_medida = $row["unidad_medida"];
    $frecuencia_cambio = $row["frecuencia_cambio"];
    $cant_ejes = $row["cant_ejes"];
    $cant_cauchos = $row["cant_cauchos"];
    $ancho = $row["ancho"];
    $perfil = $row["perfil"];
    $radial = $row["radial"];
    $indice_carga = $row["indice_carga"];
    $indice_velocidad = $row["indice_velocidad"];
    $empresa = $row["empresa_id"]; // LISTO
    $nombreEmpresa = $row["u_ente"]; // LISTO
    $placa = $row["placa"]; //LISTO


  }
}
$stmt->close();


$in = 0;

$stmta = mysqli_prepare($conexion, "SELECT * FROM `veh_reporte_fallas` WHERE vehiculo = ? AND status='0'");
$stmta->bind_param('s', $id);
$stmta->execute();
$resulta = $stmta->get_result();
if ($resulta->num_rows > 0) {
  while ($row = $resulta->fetch_assoc()) {

    if ($row['gravedad'] == '1' || $in == 1) {
      $in = 1;
    } else {
      $in = 2;
    }
  }
}
$stmta->close();




?>



</script>




<!DOCTYPE html>

<html lang="es" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title class="vehiculos" id="title">Vehículos</title>
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

  <script src="../../assets/vendor/libs/jquery/jquery.js"></script>

  <link rel="stylesheet" href="../../assets/vendor/calendar/theme3.css" />

  <script src="../../js/sweetalert2.all.min.js"></script>
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

  <style>
    .imagenGrande {
      z-index: 9999;
      position: fixed;
      background-color: #000000c2;
      width: 100%;
      height: 100vh;
      display: none;
    }

    .cerrar {
      height: 5%;
      padding: 15px;
    }

    .cerrar>i {
      color: white;
      font-size: 38px;
      font-weight: bold;
    }

    .imagenSection {
      height: 95%;
      display: grid;
      place-items: center;
    }

    .imagenSection>img {
      height: 60%;
    }

    @media only screen and (max-width: 570px) {
      .imagenSection>img {
        width: 90%;

      }
    }
  </style>

  <div class="imagenGrande animated fadeIn">
    <div class="cerrar text-end">
      <i class="bx bx-x pointer" onclick="$('.imagenGrande').hide()"></i>
    </div>
    <div class="imagenSection">
      <img class="imagenVehiculo" src="../../assets/img/vehiculos/<?php echo $id ?>.png" alt class="rounded-circle" />
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


            <h4 class="py-3 mb-4">
              <span class="text-muted fw-light">Vehículos /</span> Vehículo
            </h4>


            <div class="row">
              <!-- Customer-detail Sidebar -->
              <div class="col-xl-4 col-lg-5 col-md-5 ">
                <!-- Customer-detail Card -->
                <div class="card mb-4">


                  <div class="card-body">


                    <?php if ($empresa == $_SESSION["u_ente_id"]) { ?>
                      <div class="text-end">
                        <div class="dropdown">
                          <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                            <a class="dropdown-item" onclick="$('#modal_cambiarFoto').modal('show')">Cambiar foto vehículo</a>
                          </div>
                        </div>
                      </div>
                    <?php } ?>


                    <div class="customer-avatar-section">
                      <div class="d-flex align-items-center flex-column">
                        <?php
                        if ($in == 0) {
                          $color = '#69a5ff';
                          $bg = 'bg-label-primary';
                        } elseif ($in == 1) {
                          $color = '#ff3e1d';
                          $bg = 'bg-label-danger';
                        } else {
                          $color = '#ffab00';
                          $bg = 'bg-label-warning';
                        }



                        if ($cant_cauchos == 2 || $cant_cauchos == 3) {
                          $icon = '
                          <svg data-name="019_transport" id="_019_transport" width="44" height="44" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{fill:' . $color . ';}</style></defs><path class="cls-1" d="M19,21a4,4,0,1,1,4-4A4,4,0,0,1,19,21Zm0-6a2,2,0,1,0,2,2A2,2,0,0,0,19,15Z"/><path class="cls-1" d="M5,21a4,4,0,1,1,4-4A4,4,0,0,1,5,21Zm0-6a2,2,0,1,0,2,2A2,2,0,0,0,5,15Z"/><path class="cls-1" d="M12,18H6a1,1,0,0,1,0-2h6a1,1,0,0,1,0,2Z"/><path class="cls-1" d="M13,15H11a1,1,0,0,1-.71-.29L6.59,11H4a1,1,0,0,1-.71-.29l-1-1A1,1,0,0,1,3.71,8.29l.7.71H7a1,1,0,0,1,.71.29L11.41,13h1.22l3.22-2.76A1,1,0,0,1,16.5,10h3.09A.42.42,0,0,0,20,9.59a.42.42,0,0,0-.12-.3L15.29,4.71a1,1,0,0,1,1.42-1.42l4.58,4.59A2.37,2.37,0,0,1,22,9.59,2.41,2.41,0,0,1,19.59,12H16.87l-3.22,2.76A1,1,0,0,1,13,15Z"/><path class="cls-1" d="M11,11H4A1,1,0,0,1,4,9h6.59l1.7-1.71A1,1,0,0,1,13,7h2a1,1,0,0,1,0,2H13.41l-1.7,1.71A1,1,0,0,1,11,11Z"/><path class="cls-1" d="M18,6v5h1.59a1.41,1.41,0,0,0,1-2.41Z"/></svg>
                          ';
                        } else {
                          $icon = ' <i class="bx bx-car" style="font-size: 30px;"></i>';
                        }
                        ?>
                        <div class="avatar mb-3" style="height: 95px;width: 95px;">
                          <span class="avatar-initial rounded-circle <?php echo $bg ?>">


                            <?php

                            if (file_exists('../../assets/img/vehiculos/' . $id . '.png')) {
                              echo '  <img class="imagenVehiculo" src="../../assets/img/vehiculos/' . $id . '.png" alt class="rounded-circle" /><div class="VerImagen" onclick="$(\'.imagenGrande\').show()">
                              <i class="bx bx-image-alt"></i>
                            </div>';
                            } else {
                              echo $icon;
                            }
                            ?>


                          </span>
                        </div>

                        <div class="customer-info text-center">
                          <h4 class="mb-1"><?php echo $marca . ' - ' . $modelo ?></h4>
                          <small><?php echo $tipo_vehiculo . '. Año ' . $ano ?></small><br>
                          <small class="text-muted"><?php echo $nombreEmpresa ?></small>
                        </div>




                      </div>
                    </div>
                    <div class="d-flex justify-content-around flex-wrap mt-4 py-3">
                      <div class="d-flex align-items-center gap-2">
                        <div class="avatar">
                          <div class="avatar-initial rounded bg-label-primary"><i class="bx bx-wrench bx-sm"></i>
                          </div>
                        </div>
                        <div>
                          <h5 class="mb-0" id="costo_m">$0</h5>
                          <span title="Gastos en reparación de fallas">Reparación</span>
                        </div>
                      </div>
                      <div class="d-flex align-items-center gap-2">
                        <div class="avatar">
                          <div class="avatar-initial rounded bg-label-primary"><i class="bx bx-dollar bx-sm"></i>
                          </div>
                        </div>
                        <div>
                          <h5 class="mb-0">$<?php echo number_format($valor, 0, '.', '.') ?></h5>
                          <span>Valor</span>
                        </div>
                      </div>

                    </div>

                    <hr>
                    <div class="text-center">

                      Capacidad del tanque
                      <h4 class="text-primary mb-0"><?php echo $capacidad_tanque ?>
                        Litros</h4>
                      <p class="text-muted mb-0 text-truncate"><?php echo $tipo_combustible ?></p>
                    </div>
                    <hr class="mb-4">
                    <h5 class="mb-4">Uso del vehículo en operaciones </h5>
                    <ul class="p-0 mt-2">
                      <?php
                      $totalCost = 0;
                      $stmta = mysqli_prepare($conexion, "SELECT system_users.u_ente, go_tareas.tarea, veh_vehiculos_tarea.fecha, veh_vehiculos_tarea.status FROM `veh_vehiculos_tarea`
                      LEFT JOIN go_tareas ON go_tareas.id_tarea= veh_vehiculos_tarea.tarea
                      LEFT JOIN system_users ON system_users.u_id=go_tareas.responsable_ente_id

                      WHERE vehiculo = ? AND veh_vehiculos_tarea.status='1' ORDER BY id DESC");
                      $stmta->bind_param('s', $id);
                      $stmta->execute();
                      $resulta = $stmta->get_result();
                      if ($resulta->num_rows > 0) {
                        while ($row = $resulta->fetch_assoc()) {
                          echo '<li class="d-flex mb-4 pb-1">
                                  <div class="avatar me-3">' . ($row['status'] == '1' ? '<div title="Tarea realizada" class="avatar-initial rounded bg-label-success"><i class="bx bx-check bx-sm"></i></div>' : '<div title=Tarea pendiente" class="avatar-initial rounded bg-label-danger"><i class="bx bx-info-circle bx-sm"></i></div>') . '</div>
                                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                      <small class="text-muted d-block mb-1">' . $row['u_ente'] . '</small>
                                      <h6 class="mb-0">' . $row['tarea'] . '</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                     ' . $row['fecha'] . '
                                    </div>
                                  </div>
                                </li>';
                        }
                      }
                      $stmta->close();
                      ?>

                    </ul>
                  </div>
                </div>
                <!-- /Plan Card -->
              </div>
              <!--/ Customer Sidebar -->
              <!-- Customer Content -->
              <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                <!-- / Customer cards -->
                <div class="row ">
                  <div class="col-md-4 mb-4">
                    <div class="card h-100">
                      <div class="card-body">
                        <div class="card-icon mb-3">
                          <div class="avatar ">
                            <div class="avatar-initial rounded bg-label-success"><i class="bx bx-droplet bx-sm"></i>
                            </div>
                          </div>
                        </div>
                        <div class="card-info">
                          <h4 class="card-title mb-3">Liga de frenos</h4>
                          <div class="d-flex align-items-end mb-1 gap-1">
                            <h4 class="text-success mb-0">
                              <?php
                              if ($cantidad_liga_frenos == '1') {
                                echo $cantidad_liga_frenos . ' Litro';
                              } elseif ($cantidad_liga_frenos == '2') {
                                echo $cantidad_liga_frenos . ' Litros';
                              } else {
                                echo $cantidad_liga_frenos;
                              }
                              ?>
                            </h4>
                          </div>
                          <p class="text-muted mb-0">Tipo de liga de frenos <strong><?php echo $liga_frenos ?></strong></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-4">
                    <div class="card h-100">
                      <div class="card-body">

                        <div class="text-end" style="position: absolute;right: 0;margin: -5px 13px 0 0;">
                          <div class="dropdown">
                            <button class="btn p-0" type="button" id="salesStatsID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesStatsID">
                              <a class="dropdown-item" onclick="actualizarNeumaticos()">Actualizar vida de los neumáticos</a>
                            </div>
                          </div>
                        </div>
                        <div class="card-icon mb-3">
                          <div class="avatar">
                            <div class="avatar-initial rounded bg-label-warning">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #ffab00">
                                <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 13a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm2.75-7.17A5 5 0 0 0 13 7.1v-3a7.94 7.94 0 0 1 3.9 1.62zM11 7.1a5 5 0 0 0-1.75.73L7.1 5.69A7.94 7.94 0 0 1 11 4.07zM7.83 9.25A5 5 0 0 0 7.1 11h-3a7.94 7.94 0 0 1 1.59-3.9zM7.1 13a5 5 0 0 0 .73 1.75L5.69 16.9A7.94 7.94 0 0 1 4.07 13zm2.15 3.17a5 5 0 0 0 1.75.73v3a7.94 7.94 0 0 1-3.9-1.62zm3.75.73a5 5 0 0 0 1.75-.73l2.15 2.14a7.94 7.94 0 0 1-3.9 1.62zm3.17-2.15A5 5 0 0 0 16.9 13h3a7.94 7.94 0 0 1-1.62 3.9zM16.9 11a5 5 0 0 0-.73-1.75l2.14-2.15a7.94 7.94 0 0 1 1.62 3.9z"></path>
                              </svg>
                              </i>
                            </div>
                          </div>
                        </div>
                        <div class="card-info">
                          <h4 class="card-title mb-3">Neumáticos</h4>
                          <div class="d-flex align-items-end mb-1 gap-1">
                            <h4 class="mb-0">
                              <?php echo '<span class="text-warning">' . $ancho . '/' . $perfil . ' ' . $radial . '</span> <span class="text-muted">' . $indice_carga . $indice_velocidad . '</span>'; ?>
                            </h4>
                          </div>
                          <p class="text-muted mb-0 text-truncate">Ejes: <strong><?php echo $cant_ejes ?></strong>. Neumáticos <strong><?php echo $cant_cauchos ?></strong></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-4">
                    <div class="card h-100">
                      <div class="card-body">
                        <div class="card-icon mb-3">
                          <div class="avatar">
                            <div class="avatar-initial rounded bg-label-info"><i class='bx bxs-droplet bx-sm'></i></i>
                            </div>
                          </div>
                        </div>
                        <div class="card-info">
                          <h4 class="card-title mb-3">Aceite de motor</h4>
                          <div class="d-flex align-items-end mb-1 gap-1">
                            <h4 class="text-info mb-0"><?php echo $cantidad_aceite ?> Litros <small class="text-muted"> <?php echo $aceite_motor ?></small> </h4>
                          </div>
                          <p class="text-muted mb-0">Cambio cada <strong><?php echo $frecuencia_cambio . ' ' . $unidad_medida ?></strong></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12 mb-3" id="modal_neumaticos" style="display: none;">
                    <div class="card">
                      
                      <div class="card-header d-flex justify-content-between" >
                        <div>
                        <h5 class="mb-0">Vida de los neumáticos</h5>
                        <small class="text-muted">Porcentaje de vida</small>
                        </div>

                        <button class="btn btn-secondary" onclick="$('#modal_neumaticos').hide(300)"> <i class="bx bx-x"></i> Cerrar</button>
                      </div>
                      <div class="card-body">
                        <?php
                        $totalCost = 0;
                        $stmta = mysqli_prepare($conexion, "SELECT * FROM `veh_vida_neumaticos` WHERE vehiculo = ? ORDER BY etiqueta");
                        $stmta->bind_param('s', $id);
                        $stmta->execute();
                        $resulta = $stmta->get_result();
                        if ($resulta->num_rows > 0) {
                          echo '  <div class="table-responsive">
                                <table class="table border-top">
                                  <thead>
                                    <tr>
                                      <th>Nivel de vida</th>
                                      <th>Etiqueta</th>
                                      <th></th>
                                    </tr>
                                  </thead>
                                  <tbody>';
                          while ($row = $resulta->fetch_assoc()) {
                            $id = $row['id'];
                            echo '<tr>
                                    <td>
                                      <select id="porcentaje_' . $id . '" class="form-control ">
                                      <option value="' . $row['porcentaje'] . '">' . $row['porcentaje'] . '%</option>
                                        <option value="">Seleccione</option>
                                        <option value="100">100%</option>
                                        <option value="90">90%</option>
                                        <option value="80">80%</option>
                                        <option value="70">70%</option>
                                        <option value="60">60%</option>
                                        <option value="50">50%</option>
                                        <option value="40">40%</option>
                                        <option value="30">30%</option>
                                        <option value="20">20%</option>
                                        <option value="10">10%</option>
                                      </select>
                                    </td>
                                    <td>
                                      <input type="text" id="etiqueta_' . $id . '" value="' . $row['etiqueta'] . '" class="form-control ">
                                    </td>
                                    <td>
                                      <button value="' . $row['etiqueta'] . '" onclick="vidaN(\'' . $id . '\')" class="btn btn-outline-primary ">Actualizar</button>
                                    </td>
                                  </tr>';
                          }
                        } else {
                          echo '  <div class="table-responsive">
                                <table class="table border-top">
                                  <thead>
                                    <tr>
                                      <th>Nivel de vida</th>
                                      <th>Etiqueta</th>
                                    </tr>
                                  </thead>
                                  <tbody>';

                          $nuevoI = '1';
                          for ($i = 1; $i <= $cant_cauchos; $i++) {

                            echo '
                                  <tr>
                                <td>
                                  <select id="select_' . $i . '" class="form-control ">
                                    <option value="">Seleccione</option>
                                    <option value="100">100%</option>
                                    <option value="90">90%</option>
                                    <option value="80">80%</option>
                                    <option value="70">70%</option>
                                    <option value="60">60%</option>
                                    <option value="50">50%</option>
                                    <option value="40">40%</option>
                                    <option value="30">30%</option>
                                    <option value="20">20%</option>
                                    <option value="10">10%</option>
                                  </select>
                                </td>
                                <td>
                                  <input type="text" id="input_' . $i . '" class="form-control ">
                                </td>

                              </tr>';
                          }
                        }
                        $stmta->close();
                        ?>
                        </tbody>
                        </table>
                      </div>
                      <div class="text-end">
                        <?php
                        if (@$nuevoI == '1') {
                          echo "<button class='mt-3 btn btn-primary' onclick='saveInfoTires()'>Actualizar</button>";
                        }
                        ?>
                        <script>
                          function vidaN(id){
                            let vida = $('#porcentaje_'+id).val();
                            let etiqueta = $('#etiqueta_'+id).val();

                            $.ajax({
                              type: 'POST',
                              url: '../../back/ajax/veh_vehiculo_actualizar_vida.php',
                              dataType: 'html',
                              data: {
                                vehiculo: "<?php echo $id ?>",
                                id: id,
                                vida: vida,
                                etiqueta: etiqueta
                              },
                              cache: false,
                              success: function(msg) {
                                $(".container-loader").hide();
                                // actualizar campos
                                if (msg.trim() == 'ok') {
                                  toast_s('success', 'Actualizado correctamente')
                                }

                              }
                            }).fail(function(jqXHR, textStatus, errorThrown) {
                              $(".container-loader").hide();
                              toast_s('warning', 'Ocurrió un error, inténtelo nuevamente ' + errorThrown)
                            });



                          }





                          function saveInfoTires() {
                            let cantineumaticos = parseInt("<?php echo $cant_cauchos ?>")
                            let neumaticos = ''
                            for (let index = 1; index <= cantineumaticos; index++) {
                              if ($('#select_' + index).val() == '' || $('#input_' + index).val() == '') {
                                toast_s('error', 'Campos vacíos')
                                return
                              }
                              neumaticos += $('#select_' + index).val() + '~' + $('#input_' + index).val() + '*'
                            }
                            neumaticos = neumaticos.substring(0, neumaticos.length - 1);
                            $(".container-loader").show();

                            $.ajax({
                              type: 'POST',
                              url: '../../back/ajax/veh_vehiculo_registrar_datos_neumaticos.php',
                              dataType: 'html',
                              data: {
                                vehiculo: "<?php echo  $id ?>",
                                neumaticos: neumaticos
                              },
                              cache: false,
                              success: function(msg) {
                                toast_s('success', 'Actualizado correctamente')
                                $(".container-loader").hide();
                                location.reload();
                              }
                            }).fail(function(jqXHR, textStatus, errorThrown) {
                              $(".container-loader").hide();

                              toast_s('warning', 'Ocurrió un error, inténtelo nuevamente ' + errorThrown)
                            });

                          }
                        </script>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-12 mb-3">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="mb-0">Histórico de fallas</h5>
                      <small class="text-muted">Histórico de fallas del vehiculo</small>
                    </div>
                    <div class="card-body">

                      <div class="table-responsive">
                        <table class="table border-top">
                          <thead>
                            <tr>
                              <th>Falla</th>
                              <th>Estatus</th>
                              <th>Reporte</th>
                              <th>Costo</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            <script>
                              let infoGraf = [];
                            </script>



                            <?php
                            $totalCost = 0;
                            $stmta = mysqli_prepare($conexion, "SELECT * FROM `veh_reporte_fallas` WHERE vehiculo = ? ORDER BY reporte DESC");
                            $stmta->bind_param('s', $id);
                            $stmta->execute();
                            $resulta = $stmta->get_result();
                            if ($resulta->num_rows > 0) {
                              while ($row = $resulta->fetch_assoc()) {
                                $id = $row['id_r'];
                                if ($row['costo_reparacion'] != '') {
                                  $totalCost += $row['costo_reparacion'];
                                }

                                if ($row['status'] == '0') {
                                  $classPulse = 'pulseOpacity';
                                } else {
                                  $classPulse = '';
                                }


                                echo '  
                                  <tr class="' . $classPulse . '">
                                  <td class="d-flex">
                                 <div class="me-2"> 
                                 ' . ($row['gravedad'] == '2' ? '<span title="La falla saca al vehículo de funcionamiento" class="badge bg-label-danger fw-bold">!</span>' : '<span title="La falla no saca al vehículo de funcionamiento" class="badge bg-label-warning fw-bold">!</span>') . '
                                 </div>
                                  <span>' . $row['falla'] . '</span>
                                  </td>
                                  <td>' . ($row['status'] == '0' ? '<span class="badge bg-label-danger text-uppercase">PENDIENTE</span>' : '<span class="badge bg-label-success text-uppercase">SOLUCIONADO</span>') . '</td>
                                  <td>' . fechaCastellano($row['reporte']) . '</td>
                                
                               
                                  <td>' . ($row['costo_reparacion'] == '' ? '' : '$' . $row['costo_reparacion']) . '</td>
                                  <td>';


                                if ($row['costo_reparacion'] != '') {
                                  echo '   <script>
                                    infoGraf.push(["' . $row['reporte'] . '", ' . $row['costo_reparacion'] . '])
                                  </script>';
                                }


                                if ($row['status'] == '0') {
                                  echo ' <div class="btn-group dropstart">
                                            <button type="button" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu p-2">';

                                  if ($empresa == $_SESSION["u_ente_id"]) {
                                    echo ' <a class="dropdown-item" onclick="repo_solucion(\'' . $id . '\')"><i class="bx bx-check-circle me-2"></i> Reportar solución de la falla</a>';
                                  }

                                  echo ' <a class="dropdown-item" onclick="ver_repuestos(\'' . $id . '\')"><i class="bx bx-wrench me-2"></i> Ver repuestos necesarios</a>
                                            </div>
                                          </div>';
                                }
                                echo '
                                  </td>
                                </tr>
                              ';
                              }
                            }
                            $stmta->close();
                            ?>




                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>



                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="mb-0">Costos de reparación</h5>
                      <small class="text-muted">Histórico de gastos en reparación de fallas</small>
                    </div>
                    <div class="card-body">
                      <div id="chartdiv" style="height: 60vh; width: 100%;"></div>
                      <div class="overMark"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--/ Customer Content -->
          </div>
        </div>


        <div class="modal fade" id="modal_repuestos" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

              <div class="modal-body" id="list_respuestos">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                  Cerrar
                </button>
              </div>
            </div>
          </div>
        </div>




        <script>
          function actualizarNeumaticos() {
            $('#modal_neumaticos').show(300)
          }
        </script>



        <?php if ($empresa == $_SESSION["u_ente_id"]) { ?>
          <div class="modal fade" id="modal_cambiarFoto" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <form class="modal-content" id="formElem" enctype="multipart/form-data">
                <div class="modal-header">
                  <h5 class="modal-title">Cambiar foto del vehículo</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                  <div class="mb-3">
                    <label for="photo" class="form-label">Foto del vehículo</label>
                    <div class="input-group">
                      <input type="file" class="form-control" accept=".png, .jpg, .jpeg" id="photo" name="photo[]" required />



                      <label class="input-group-text" for="photo"><i class="bx bx-upload"></i></label>

                    </div>
                  </div>


                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Actualizar</button>
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
              </form>
            </div>
          </div>



          <script>
            $(document).ready(function(e) {
              $("#formElem").on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                let id = "<?php echo $_GET["i"] ?>";
                formData.append('id', id);

                $(".container-loader").show();

                $.ajax({
                  type: 'POST',
                  url: '../../back/ajax/veh_foto_vehiculo.php',
                  data: formData,
                  contentType: false,
                  cache: false,
                  processData: false,
                  success: function(msg) {
                    $('#modal_cambiarFoto').modal('hide')
                    toast_s('success', 'Actualizado correctamente')
                    location.reload();
                    $(".container-loader").hide();
                  }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                  $(".container-loader").hide();

                  toast_s('warning', 'Ocurrió un error, inténtelo nuevamente ' + errorThrown)
                });




              })
            });
          </script>
        <?php } ?>


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
  <script src="../../assets/vendor/amcharts5/xy.js"></script>
  <script src="../../assets/vendor/amcharts5/themes/Animated.js"></script>
  <script src="../../assets/vendor/amcharts5/themes/Material.js"></script>
</body>

<script>
  $('#costo_m').html("$<?php echo $totalCost ?>");


  async function repo_solucion(id) {

    const {
      value: costo
    } = await Swal.fire({
      title: "Indique el costo de la reparación",
      input: "number",
      inputLabel: "Costo ($)",
      showCancelButton: true,
      confirmButtonColor: "#69a5ff",
      cancelButtonText: `Cancelar`,
      inputValidator: (value) => {
        if (!value) {
          return "¡Es necesario indicar el costo!";
        }
      }
    });
    if (costo) {
      $('.container-loader').show()
      $.get("../../back/ajax/veh_vehiculo.php", "v=1&i=" + id + "&c=" + costo, function(data) {
        $('.container-loader').hide()
        toast_s('success', 'Actualizado correctamente')
        location.reload();
      });
    }

  }











  function ver_repuestos(id) {
    $('.container-loader').show()
    $.get("../../back/ajax/veh_vehiculo.php", "v=2&i=" + id, function(data) {
      $('.container-loader').hide()
      $('#list_respuestos').html(data)
      $('#modal_repuestos').modal('show')
    });
  }











  function nuevoVehiculoSection() {
    $('#nuevoVehiculoSec').toggle();
    $('#tablaSection').toggle();
  }


  function tabla() {

    $.get("../../back/ajax/veh_lista.php", "", function(data) {

      $('#tbodyTable').html(data)
    });
  }
  tabla()



  /*GRAFICO*/
  // Create root element
  // https://www.amcharts.com/docs/v5/getting-started/#Root_element
  var root = am5.Root.new("chartdiv");


  root.setThemes([
    am5themes_Animated.new(root),
    am5themes_Material.new(root)
  ]);


  var chart = root.container.children.push(
    am5xy.XYChart.new(root, {
      panX: true,
      panY: true,
      wheelX: "panX",
      wheelY: "zoomX"
    })
  );

  chart.get("colors").set("step", 1);


  var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
  cursor.lineY.set("visible", false);


  var xAxis = chart.xAxes.push(
    am5xy.DateAxis.new(root, {
      maxDeviation: 0.3,
      baseInterval: {
        timeUnit: "day",
        count: 1
      },
      renderer: am5xy.AxisRendererX.new(root, {}),
      tooltip: am5.Tooltip.new(root, {})
    })
  );

  var yAxis = chart.yAxes.push(
    am5xy.ValueAxis.new(root, {
      maxDeviation: 0.3,
      renderer: am5xy.AxisRendererY.new(root, {})
    })
  );


  var series = chart.series.push(am5xy.LineSeries.new(root, {
    name: "Series 1",
    xAxis: xAxis,
    yAxis: yAxis,
    valueYField: "value",
    valueXField: "date",
    tooltip: am5.Tooltip.new(root, {
      labelText: "{valueY}"
    })
  }));
  series.strokes.template.setAll({
    strokeWidth: 2,
    strokeDasharray: [3, 3]
  });

  series.bullets.push(function() {
    var container = am5.Container.new(root, {
      templateField: "bulletSettings"
    });
    var circle0 = container.children.push(am5.Circle.new(root, {
      radius: 5,
      fill: am5.color(0xff0000)
    }));
    var circle1 = container.children.push(am5.Circle.new(root, {
      radius: 5,
      fill: am5.color(0xff0000)
    }));

    circle1.animate({
      key: "radius",
      to: 20,
      duration: 1000,
      easing: am5.ease.out(am5.ease.cubic),
      loops: Infinity
    });
    circle1.animate({
      key: "opacity",
      to: 0,
      from: 1,
      duration: 1000,
      easing: am5.ease.out(am5.ease.cubic),
      loops: Infinity
    });

    return am5.Bullet.new(root, {
      sprite: container
    })
  })


  // Set data
  var data = []

  const reversedInfo = infoGraf.reverse();

  reversedInfo.forEach(element => {
    let pref = element[0].split(' ')[0]
    let items_f = pref.split('-')

    data.push({
      date: new Date(items_f[0], items_f[1] - 1, items_f[2]).getTime(),
      value: parseInt(element[1]),
    })
  });



  series.data.setAll(data);


  // Make stuff animate on load
  // https://www.amcharts.com/docs/v5/concepts/animations/#Forcing_appearance_animation
  series.appear(1000);
  chart.appear(1000, 100);
  /*GRAFICO*/
</script>

</html>