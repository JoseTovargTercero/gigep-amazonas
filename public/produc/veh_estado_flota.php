<?php
include('../../back/config/conexion.php');
include('../../back/config/funcione_globales.php');

if ($_SESSION["u_nivel"] != '1' && $_SESSION["u_nivel"] != '2' && $_SESSION["u_nivel"] != '3') {
  header("Location: ../index.php");
}

if ($_SESSION["u_nivel"] == 2 || $_SESSION["u_nivel"] == 3) {
  $empresa = $_SESSION['u_ente_id'];
  $extra = " AND empresa_id='$empresa' ";
  $extra_user = " AND u_id='$empresa' ";
} else {
  if (isset($_GET["empresa"])) {
    $empresa =  $_GET['empresa'];
    $extra_user = " AND u_id='$empresa' ";
  } else {
    $extra = "";
    $extra_user = "";
  }
}

?>


<!DOCTYPE html>

<html lang="es" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title class="vehiculos" id="title">Estado de la flota</title>
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


  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.css" />
  <style>
    .containerPhoto>img {
      display: flex;
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


            <h4 class="py-3 mb-4">
              <span class="text-muted fw-light">Vehículos /</span> Estado de la flota
            </h4>


            <div class="row mb-3">



              <div class="col-lg-8 ">
                <div class="row">

                  <div class="col-lg-4 mb-3">
                    <div class="card card-border-shadow-primary h-100">
                      <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                          <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-error"></i></span>
                          </div>
                          <h4 class="ms-1 mb-0" id="veh_total"></h4>
                        </div>
                        <p class="mb-1">Total de vehículos</p>
                      </div>
                    </div>
                  </div>


                  <div class="col-lg-4 mb-3">
                    <div class="card card-border-shadow-success h-100">
                      <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                          <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bxs-truck"></i></span>
                          </div>
                          <h4 class="ms-1 mb-0" id="veh_activos"></h4>
                        </div>
                        <p class="mb-1">Vehículos activos</p>
                      </div>
                    </div>
                  </div>



                  <div class="col-lg-4 mb-3">
                    <div class="card card-border-shadow-danger h-100">
                      <div class="card-body">
                        <div class="d-flex align-items-center mb-2 pb-1">
                          <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-error"></i></span>
                          </div>
                          <h4 class="ms-1 mb-0" id="veh_averiados"></h4>
                        </div>
                        <p class="mb-1">Vehículos averiados o con fallas</p>
                      </div>
                    </div>
                  </div>



                  <div class="col-lg-12 mb-3">
                    <div class="card h-100">
                      <div class="card-header">
                        <h5>Gastos de reparación</h5>
                      </div>
                      <div class="card-body">
                        <div id="chartdiv" style="height: 40vh; width: 100%;"></div>
                        <div class="overMark"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


              <div class="col-lg-4 mb-4">
                <div class="card h-100">
                  <div class="card-header d-flex justify-content-between mb-0 pb-0">
                    <h5>Vehículos averiados</h5>
                    <div class="dropdown">
                      <button class="btn p-0" type="button" id="deliveryPerformance" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="deliveryPerformance">


                        <?php
                        $stmt2 = mysqli_prepare($conexion, "SELECT * FROM veh_reporte_fallas WHERE vehiculo=? AND status='0'");


                        $stmt = mysqli_prepare($conexion, "SELECT id, marca, modelo FROM `veh_vehiculos` WHERE id!='' $extra");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                            $i = $row['id'];
                            $stmt2->bind_param('s', $i);
                            $stmt2->execute();
                            $result2 = $stmt2->get_result();
                            if ($result2->num_rows > 0) {
                              echo '<a class="dropdown-item pointer" onclick="verVehiculoAv(\'' . $i . '\')"><i class="bx bx-detail me-2"></i>' . $row['marca'] . ' - ' . $row['modelo'] . '</a>';
                            }
                          }
                        }

                        echo "
                      </div>
                      </div>
                      </div>
                      ";
                        $stmt->close();

                        $contador = 1;

                        $total_vehiculos = 0;
                        $vehiculos_activos = 0;
                        $vehiculos_inactivos = 0;
                        $stmt = mysqli_prepare($conexion, "SELECT * FROM `veh_vehiculos`
                          LEFT JOIN system_users ON system_users.u_id = veh_vehiculos.empresa_id
                          WHERE id!='' $extra");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                            $id = $row['id'];

                            $stmt2->bind_param('s', $id);
                            $stmt2->execute();
                            $result2 = $stmt2->get_result();
                            if ($result2->num_rows > 0) {
                              $vehiculos_inactivos++;
                              $status = '0';
                              $contador++;
                            } else {
                              $status = '1';
                              $vehiculos_activos++;
                            }

                            $total_vehiculos++;

                            if ($status != '1') {

                              echo '<div id="slider-' . $id . '" class="animated fadeIn sliders_items" ' . ($contador > 1 ? 'display: none' : '') . '>
                                  <div class="p-3 flex-grow-0">
                                    <div class="d-flex">
                                      <div class="avatar flex-shrink-0 me-3">';
                              if (file_exists('../../assets/img/avatars/' . $row['empresa_id'] . '.png')) {
                                echo '  <img src="../../assets/img/avatars/' . $row['empresa_id'] . '.png" alt class="w-px-40 h-px-40 rounded-circle" />';
                              } else {
                                echo '  <span class="avatar-initial rounded-circle bg-label-danger">' . substr($row['u_ente'], 0, 1) . '</span>';
                              }
                              echo '
                                  </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-1">
                                      <div class="me-2">
                                        <h5 class="mb-0">' . $row['u_ente'] . '</h5>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="containerPhoto">';

                              if (file_exists('../../assets/img/vehiculos/' . $id . '.png')) {
                                echo ' <img class="images img_cover" src="../../assets/img/vehiculos/' . $id . '.png" alt="Imagen vehículo">';
                              } else {
                                echo '  <img class="images img_cover" src="../../assets/img/vehiculos/default.avif" alt="Imagen vehículo">';
                              }
                              echo '</div>
                                  <div class="p-3">
                                  <h5 class="mb-0 text-dark" style="text-wrap: nowrap">' . $row['modelo'] . '</h5>
                                  <span class="text-primary" style="text-wrap: nowrap">' . $row['marca'] . '</span>
                                    <p class="text-truncate">El vehículo se encuentra actualmente inoperativo.</p>
                                    <button class="btn btn-primary" onclick="informe(' . $id . ')">Ver informe</button>
                                  </div>
                                </div>';
                            }
                          }
                        }
                        $stmt->close();
                        $stmt2->close();

                        if ($vehiculos_inactivos == 0) { ?>
                          <div class="p-3 grid-center">

                            <img class="mb-3 mt-5" src="../../assets/img/vehiculos_ok.jpg" alt="Vehiculos funcionando" height="220px">
                            <span>Todos los vehículos están en funcionamiento!</span>

                          </div>

                        <?php } ?>



                      </div>
                    </div>
                  </div>
                </div>





                <div class="row">

                  <?php
                  $re = contar("SELECT count(*) FROM `veh_repuestos` WHERE status='0' AND tipo='1'");

                  if ($_SESSION["u_nivel"] == 1 && $re != 0) { ?>
                    <div class="col-lg-6 mb-3">
                      <div class="card h-100">
                        <div class="card-header">
                          <h5>Compra de repuestos</h5>
                        </div>
                        <div class="card-body">

                          <small class="text-light fw-semibold">Lista de repuestos necesarios</small>
                          <div class="demo-inline-spacing mt-3 mb-3">
                            <div class="list-group">

                              <?php
                              $stmt = mysqli_prepare($conexion, "SELECT veh_repuestos.id, veh_partes.insumo, veh_repuestos.cantidad, veh_vehiculos.modelo, system_users.u_ente FROM `veh_repuestos`
                        LEFT JOIN veh_partes ON veh_partes.id_i=veh_repuestos.repuesto
                        LEFT JOIN veh_reporte_fallas ON veh_reporte_fallas.id_r=veh_repuestos.falla_id
                        LEFT JOIN veh_vehiculos ON veh_vehiculos.id=veh_reporte_fallas.vehiculo
                        LEFT JOIN system_users ON system_users.u_id=veh_vehiculos.empresa_id
                         WHERE veh_repuestos.status='0' AND veh_repuestos.tipo='1'");
                              $stmt->execute();
                              $result = $stmt->get_result();
                              if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                  $id = $row['id'];
                                  echo '<label class="list-group-item d-flex w-100 justify-content-between">

                                  <span>
                                  <input class="form-check-input me-1" onclick="addRepuesto(\'' . $id . '\')" type="checkbox" value="">
                                  (' . $row['cantidad'] . ') ' . ($row['insumo'] == '' ? 'Mano de obra' : $row['insumo']) . '
                                  </span>

                                  <span>' . $row['modelo'] . ' - ' . $row['u_ente'] . '</span>



                                  </label>';
                                }
                              }
                              $stmt->close();


                              ?>
                            </div>
                          </div>


                          <div class="divider divider-primary">
                            <div class="divider-text">Datos de la compra</div>
                          </div>


                          <div class="mb-3">
                            <label for="nombre_compra">Identificador de la compra</label>
                            <input type="text" id="nombre_compra" class="form-control">
                          </div>

                          <div class="mb-3">
                            <label for="fecha">Fecha de compra</label>
                            <input type="date" id="fecha" class="form-control" onchange="verify(this.value)">
                          </div>

                          <div class="text-end"><button class="btn btn-primary" onclick="nuevaCompraRepuestos()">Guardar</button></div>



                        </div>
                      </div>
                    </div>
                  <?php } ?>



                  <?php
                  if ($re != 0 && $_SESSION['u_nivel'] == 1) {
                    $col = 'col-lg-12';
                  } else {
                    $col = 'col-lg-6';
                  }
                  ?>

                  <div class="<?php echo $col ?> mb-3" style="display: none;">
                    <div class="card h-100">
                      <div class="card-header">
                        Vehículos
                      </div>
                      <div class="card-body">


                        <div class="">
                          <table class="table" id="tableVehiculos">
                            <thead class="border-top">
                              <tr>
                                <th>Vehículo</th>
                                <th>Empresa</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>


                              <?php
                              $stmt = mysqli_prepare($conexion, "SELECT * FROM `veh_vehiculos`
                                      LEFT JOIN system_users ON system_users.u_id = veh_vehiculos.empresa_id
                                      WHERE id!='' $extra");
                              $stmt->execute();
                              $result = $stmt->get_result();
                              if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                  $id = $row['id'];
                                  $falla = contar("SELECT count(*) FROM veh_reporte_fallas WHERE vehiculo='$id' AND status='0'");

                                  echo '<tr>
                                            <td class="sorting_1">
                                            <div class="d-flex justify-content-start align-items-center user-name">
                                              <div class="avatar-wrapper">
                                                <div class="avatar me-2"><span class="avatar-initial rounded-circle bg-label-secondary"><i class="bx bxs-truck"></i></span></div>
                                              </div>
                                              <div class="d-flex flex-column"><span class="fw-medium mb-0">' . $row['modelo'] . '</span><small class=""text-muted>' . $row['marca'] . '</small></div>
                                            </div>
                                          </td>
                                          <td>' . $row['u_ente'] . '</td>
                                          <td>';
                                  if ($falla != 0) {
                                    echo '<button class="btn btn-outline-primary"  onclick="informe(' . $id . ')"><i class="bx bx-detail me-2"></i>Informe</button>';
                                  }
                                  echo '
                                          </td>
                                            </tr>';
                                }
                              }
                              $stmt->close();

                              ?>
                            </tbody>
                          </table>
                        </div>






                      </div>
                    </div>
                  </div>






                </div>







              </div>

            </div>





          </div>
          <!-- Content wrapper -->

        </div>
        <!-- / Layout page -->
      </div>

      <div class="modal fade" id="informeAveria" aria-hidden="true" aria-labelledby="modalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <div class=" d-flex w-100 justify-content-between">

                <h5 class="modal-title">Detalles de la averia</h5>

                <div><button class="btn btn-primary btn-sm" onclick="print_pdf()"><i class="bx bx-download me-2"></i> DESCARGAR</button></div>
              </div>

              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="averiaDetalles">
            </div>
          </div>
        </div>
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


    <script src="../../assets/vendor/amcharts5/index.js"></script>
    <script src="../../assets/vendor/amcharts5/xy.js"></script>
    <script src="../../assets/vendor/amcharts5/themes/Animated.js"></script>
    <script src="../../assets/vendor/amcharts5/themes/Material.js"></script>



    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>
</body>


<script>
  function verVehiculoAv(id) {
    $('.sliders_items').hide()
    $('#slider-' + id).show()
  }

  function print_pdf() {



    var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write('<html><head><title>' + document.title + '</title>');
    mywindow.document.write('<link rel="stylesheet" href="../../assets/vendor/css/core.css" media="print" /><link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" /></head><body >');

    mywindow.document.write(document.getElementById('averiaDetalles').innerHTML);


    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
  }















  let infoGraf = [];

  var repuestosComprar = []

  function addRepuesto(repuesto) {
    if (repuestosComprar[repuesto]) {
      delete repuestosComprar[repuesto]
    } else {
      repuestosComprar[repuesto] = repuesto;
    }

  }



  function nuevaCompraRepuestos() {

    let nombre_compra = $('#nombre_compra').val();
    let fecha = $('#fecha').val();
    var respuestos = []

    if (repuestosComprar.length < 1) {
      toast_s('error', 'Seleccione los repuestos que se agregaran a la compra')
      return
    }

    if (nombre_compra == '') {
      toast_s('error', 'Campo vacío: Identificador de la compra')
      return
    }
    if (fecha == '') {
      toast_s('error', 'Campo vacío: Fecha de compra')
      return
    }
    repuestosComprar.forEach(element => {
      respuestos.push(element)
    });

    $(".container-loader").show();
    $('button').attr('disabled', true);

    $.ajax({
      type: 'POST',
      url: '../../back/ajax/veh_nueva_compra.php',
      dataType: 'html',
      data: {
        nombre_compra: nombre_compra,
        fecha: fecha,
        respuestos: respuestos.toString()
      },
      cache: false,
      success: function(msg) {
        $(".container-loader").hide();
        $('button').attr('disabled', false);


        if (msg.trim() == 'ok') {
          location.reload();
          toast_s('success', 'Se agrego correctamente')
        } else {
          alert(msg)
        }
      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      $(".container-loader").hide();
      $('button').attr('disabled', false);


      toast_s('warning', 'Ocurrió un error, inténtelo nuevamente ' + errorThrown)
    });






  }
</script>



<?php
$totalCost = 0;
$stmta = mysqli_prepare($conexion, "SELECT * FROM `veh_reporte_fallas` ORDER BY reporte DESC");
$stmta->execute();
$resulta = $stmta->get_result();
if ($resulta->num_rows > 0) {
  while ($row = $resulta->fetch_assoc()) {
    $id = $row['id_r'];
    if ($row['costo_reparacion'] != '') {
      $totalCost += $row['costo_reparacion'];
    }

    if ($row['costo_reparacion'] != '') {
      echo '   <script>
                                    infoGraf.push(["' . $row['reporte'] . '", ' . $row['costo_reparacion'] . '])
                                  </script>';
    }
  }
}
$stmta->close();
?>
<script>
  $('#veh_total').html("<?php echo $total_vehiculos ?>")
  $('#veh_total2').html("<?php echo $total_vehiculos ?>")
  $('#veh_activos').html("<?php echo $vehiculos_activos ?>")
  $('#veh_act_2').html("<?php echo $vehiculos_activos ?>")
  $('#veh_averiados').html("<?php echo $vehiculos_inactivos ?>")



  function informe(id) {
    $('.container-loader').show()
    $.get("../../back/ajax/veh_estado_flota_back.php", "v=" + id, function(data) {
      $('#averiaDetalles').html(data)
      $('#informeAveria').modal('show')
      $('.container-loader').hide()
    });
  }


  var table = $('#tableVehiculos').DataTable({
    language: {
      "decimal": "",
      "emptyTable": "No hay información",
      "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
      "infoFiltered": "(Filtrado de _MAX_ total entradas)",
      "infoPostFix": "",
      "thousands": ",",
      "lengthMenu": "Mostrar _MENU_ Entradas",
      "loadingRecords": "Cargando...",
      "processing": "Procesando...",
      "search": "Buscar:",
      "zeroRecords": "Sin resultados encontrados",
      "paginate": {
        "first": "Primero",
        "last": "Ultimo",
        "next": "Siguiente",
        "previous": "Anterior"
      }
    }
  });














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
</script>

</html>