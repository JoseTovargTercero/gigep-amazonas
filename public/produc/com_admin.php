<?php
include('../../back/config/conexion.php');
include('../../back/config/funcione_globales.php');

if ($_SESSION["u_nivel"] != '1') {
  header("Location: ../index.php");
}



?>



</script>




<!DOCTYPE html>

<html lang="es" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title class="com" id="title">Administrador de compras</title>
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

  <!-- <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
-->
  <link rel="stylesheet" href="../../assets/vendor/calendar/theme3.css" />

  <script src="../../js/sweetalert2.all.min.js"></script>




  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>




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

              <?php
              $y_d1 = date('Y') - 1;
              $y_d = date('Y');
              $y_d2 = date('Y') + 1;
              ?>
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Compras /</span> Administrador de compras</h4>


            </div>



            <div class="row ">



              <div class="col-lg-12 mb-3">
                <div class="card app-calendar-wrapper">
                  <div class="row g-0">

                    <div class="col-lg-3">

                      <div class="border-bottom border-right p-4 my-sm-0 mb-3">
                        <div class="d-grid pi-c">
                          <h5 class="mb-0"> <i class="bx bx-plus"></i> Nueva compra</h5>
                        </div>
                      </div>


                      <form id="form" method="POST">


                        <div class="p-4 my-sm-0 mb-3 border-right">


                          <div class="mb-3">
                            <label for="nombre" class="form-label">Identificador de la compra</label>
                            <input type="text" class="form-control" id="nombre" required name="nombre">
                          </div>

                          <div class="mb-3">
                            <label for="tipoCompra" class="form-label">Tipo de compra</label>
                            <select id="tipoCompra" required name="tipoCompra" class="form-control">
                              <option value="">Seleccione</option>
                              <option value="1">Compra unica</option>
                              <option value="2">Repetir cada 15 días</option>
                              <option value="3">Repetir cada 30 días</option>
                            </select>
                          </div>

                          <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha de compra</label>
                            <input type="date" class="form-control" id="fecha" onchange="verify()" required name="fecha">
                          </div>

                          <button class="btn btn-primary w-100 mt-3" type="submit">
                            <i class="bx bx-plus me-1"></i>
                            <span class="align-middle">Agregar compra</span>
                          </button>
                        </div>
                      </form>
                    </div>
                    <div class="col-lg-9">
                      <div class="border-bottom border-left p-4 my-sm-0 mb-3">
                        <div class=" d-grid pi-c">
                          <h5 class="mb-0"> <i class="bx bx-calendar"></i> Compras programadas</h5>
                        </div>
                      </div>
                      <div class=" p-4 my-sm-0 mb-3">
                        <div id="caleandar"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card mb-3">
                  <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title mb-0">
                      <h5 class="m-0 me-2">Próximas compras</h5>
                    </div>
                  </div>
                  <div class="card-body">
                    <ul class="p-0 m-0" style="min-height: 300px; overflow-y: auto">

                      <?php
                      $pasos = 1;
                      $proximaCompra = '';
                      $proximaCompra_n = '';
                      $proximaCompra_f = '';
                      $veh = '';

                      $stmt = mysqli_prepare($conexion, "SELECT * FROM `com_compras` WHERE status='0' OR status='1' ORDER BY fecha ASC");
                      $stmt->execute();
                      $result = $stmt->get_result();
                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                          if ($pasos == 1 && $row['status'] == 0) {
                            $proximaCompra = $row['id'];
                            $proximaCompra_n = $row['nombre'];
                            $proximaCompra_f =  fechaCastellano($row['fecha']);
                            $veh = $row['veh'];
                            $pasos++;
                          }


                          $id = $row['id'];
                          $insumos = contar("SELECT count(*) FROM `com_compras_estructura` WHERE `compra_id`='$id'");
                          echo '  <li class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">';
                          if ($row['status'] == '0') {
                            echo '  <span class="avatar-initial rounded-circle bg-label-success" tittle="Abierta">A</span>';
                          } else {
                            echo '  <span class="avatar-initial rounded-circle bg-label-secondary" tittle="Cerrada">C</span>';
                          }
                          echo '</div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                          <div class="me-2">
                            <h6 class="mb-1 fw-normal">' . $row['nombre'] . '</h6>
                            <small class="text-primary fw-normal d-block">
                              <i class="bx bx-time"></i>' . fechaCastellano($row['fecha']) . '
                            </small>
                          </div>
                          <div class="user-progress">

                          <div class="dropdown">
                            <button class="btn p-0" type="button" id="deliveryPerformance" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="deliveryPerformance">';


                          if ($insumos == 0) {
                            echo '<a class="dropdown-item pointer" onclick="borrarCompra(\'' . $row['id'] . '\')"><i class="bx bx-trash me-2"></i>Eliminar</a>';
                          }
                          if ($row['status'] == 0) {
                            echo '<a class="dropdown-item pointer" onclick="cerrarCompra(\'' . $row['id'] . '\')"><i class="bx bx-lock me-2"></i>Cerrar compra</a>';
                          } elseif ($row['status'] == 1) {
                            echo '<a class="dropdown-item pointer" onclick="compraRealizada(\'' . $row['id'] . '\')"><i class="bx bx-check-circle me-2"></i>Compra realizada</a>';
                          }

                          echo '
                              <a class="dropdown-item pointer" onclick="vistaCompra(\'' . $row['id'] . '\', \'' . $row['nombre'] . '\', \'' . fechaCastellano($row['fecha']) . '\', \'' . $row['veh'] . '\')"><i class="bx bx-detail me-2"></i>Ver detalles</a>
                            </div>
                          </div>

                          </div>
                        </div>
                      </li>';
                        }
                      }
                      $stmt->close();
                      ?>
                    </ul>
                  </div>
                </div>

                <div class="card mb-3">
                  <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title mb-0">
                      <h5 class="m-0 me-2">Compras periódicas</h5>
                      <small class="text-muted">Programación automática</small>
                    </div>
                  </div>
                  <div class="card-body">
                    <ul class="p-0 m-0 " style="min-height: 300px; max-height: 500px; overflow-y: auto">

                      <?php

                      $stmt = mysqli_prepare($conexion, "SELECT * FROM `com_compras_periodicas`");
                      $stmt->execute();
                      $result = $stmt->get_result();
                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          echo '  <li class="d-flex mb-4 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                          <span class="avatar-initial rounded bg-label-primary fw-bold">' . ($row['tipo'] == '2' ? '15' : '30') . '</span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                          <div class="me-2">
                            <h6 class="mb-1 fw-normal">' . $row['nombre'] . '</h6>
                            <small class="text-primary fw-normal d-block">
                              ';

                          if ($row['status'] == '1') {
                            echo '<span class="text-muted">Pausada</span>';
                          } else {
                            echo '<i class="bx bx-time me-2"></i>' . fechaCastellano($row['fecha']);
                          }
                          echo '
                            </small>
                          </div>
                          <div class="user-progress">

                          <div class="dropdown">
                            <button class="btn p-0" type="button" id="deliveryPerformance" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="deliveryPerformance">';
                          /*
                            if ($row['status'] == '1') {
                              echo '<a class="dropdown-item pointer" onclick="accion(\'reanudar\', \''.$row['id'].'\')"><i class="bx bx-play-circle me-2"></i>Reanudar</a>';
                            }else {
                              echo '<a class="dropdown-item pointer" onclick="accion(\'pausar\', \''.$row['id'].'\')"><i class="bx bx-pause-circle me-2"></i>Pausar</a>';
                            }*/



                          echo '<a class="dropdown-item pointer" onclick="accion(\'eliminar\', \'' . $row['id'] . '\')"><i class="bx bx-trash me-2"></i>Eliminar</a>
                            </div>
                          </div>

                          </div>
                        </div>
                      </li>';
                        }
                      }
                      $stmt->close();
                      ?>
                    </ul>
                  </div>
                </div>
              </div>











              <div class="col-lg-8">
                <div class="card " id="detallesCompra">
                  <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title mb-0">
                      <h5 class="m-0 me-2">Detalles de la compra</h5>
                      <small class="text-muted">Compra seleccionada</small>
                    </div>

                    <div style="text-align: right;">
                      <h5 class="m-0 me-2" id="nombre_compra_c"></h5>
                      <small class="text-muted" id="fecha_compra_c"></small>
                    </div>
                  </div>
                  <div class="card-body">

                    <div>
                      <div class="card-header d-flex align-items-center justify-content-between border-top rounded-0  py-md-0 px-0">

                        <ul class="nav nav-pills" role="tablist">
                          <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-empresas" aria-controls="navs-empresas" aria-selected="true">
                              <span class="tf-icons bx bx-user me-1"></span>Empresas
                            </button>
                          </li>
                          <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-distribucion" aria-controls="navs-distribucion" aria-selected="false">
                              <span class="tf-icons bx bx-package me-1"></span>Distribución de biinsumosenes
                            </button>
                          </li>
                          <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-insumos" aria-controls="navs-insumos" aria-selected="false">
                              <i class='bx bx-purchase-tag-alt me-1'></i>Detalles de la compra
                            </button>
                          </li>
                        </ul>
                        <div>
                          <button class="btn btn-label-secondary my-2" data-bs-toggle="dropdown" type="button"><span><i class="bx bx-export me-1"></i>Exportar</span></button>
                          <div class="dropdown-menu dropdown-menu-end m-0">
                            <a onclick="print_pdf('navs-insumos')" class="dropdown-item">Detalles de la compra</a>
                            <a onclick="print_pdf('navs-distribucion')" class="dropdown-item">Distribución de insumos</a>
                          </div>
                        </div>
                      </div>
                      <div class="tab-content">
                        <div class="tab-pane fade show active" id="navs-empresas" role="tabpanel">
                          <table class=" table border-top dataTable no-footer d">
                            <thead>
                              <tr>
                                <th>EMPRESA</th>
                                <th class="text-center">INSUMOS</th>
                              </tr>
                            </thead>
                            <tbody id="contenido_empresa">
                            </tbody>
                          </table>
                        </div>
                        <div class="tab-pane fade" id="navs-distribucion" role="tabpanel">
                          <table class=" table border-top dataTable no-footer d">
                            <thead>
                              <tr>
                                <th>EMPRESA</th>
                                <th>INSUMO</th>
                                <th class="text-center">CANTIDAD</th>
                              </tr>
                            </thead>
                            <tbody id="contenido_insumos">
                            </tbody>
                          </table>
                        </div>
                        <div class="tab-pane fade" id="navs-insumos" role="tabpanel">
                          <table class=" table border-top dataTable no-footer d">
                            <thead>
                              <tr>
                                <th>INSUMO</th>
                                <th class="text-center">CANTIDAD</th>
                              </tr>
                            </thead>
                            <tbody id="contenido_detalles">
                            </tbody>
                          </table>
                        </div>
                      </div>




                    </div>
                    </ul>
                  </div>
                </div>
              </div>

            </div>





            <div class="modal fade" id="backDropModal" data-bs-backdrop="static" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered">
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

















            <div id="template_inv" class="mb-3" style="display: none;">
              <div class="text-center">
                <img src="../../assets/img/logo.png" class="mb-2" style="width: 30px;">
                <p>
                  <strong id="titulo">Orden de compra</strong>
                  <br> Fecha: <strong><?php echo fechaCastellano(date('Y-m-d')) ?></strong>
                </p>
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




    <div id="editor"></div>

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

    <script src="../../assets/vendor/amcharts5/index.js"></script>
    <script src="../../assets/vendor/amcharts5/flow.js"></script>
    <script src="../../assets/vendor/amcharts5/percent.js"></script>
    <script src="../../assets/vendor/amcharts5/themes/Animated.js"></script>
    <script src="../../assets/vendor/amcharts5/themes/Material.js"></script>

</body>

<script>
  function print_pdf(elem) {


    if (elem == 'navs-distribucion') {
      $('#titulo').html('Distribución de insumos')
    } else {
      $('#titulo').html('Orden de compra')
    }


    var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write('<html><head><title>' + document.title + '</title>');
    mywindow.document.write('<link rel="stylesheet" href="../../assets/vendor/css/core.css" class="template-customizer-core-css" /><link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" /></head><body >');

    mywindow.document.write(document.getElementById('template_inv').innerHTML);
    mywindow.document.write(document.getElementById(elem).innerHTML);


    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
  }


  function accion(accion, id) {
    let texto, texto2, icon

    if (accion == 'eliminar') {
      texto = 'Se eliminará la compra seleccionada. La acción no afectará a las compras previamente programadas.';
      icon = "warning"
    } else if (accion == 'reanudar') {
      texto = 'Se reanudara la compra.';
      icon = "info"
    } else {
      texto = 'Se pausará la compra seleccionada.';
      icon = "warning"
    }


    Swal.fire({
      title: "<strong>¿Está seguro?</strong>",
      icon: icon,
      html: texto,
      showCancelButton: true,
      confirmButtonColor: "#69a5ff",
      confirmButtonText: `Continuar`,
      cancelButtonText: `Cancelar`,
    }).then((result) => {
      if (result.isConfirmed) {
        $('.container-loader').show()
        $.get("../../back/ajax/com_accion_compras_periodicas.php", "accion=" + accion + '&i=' + id, function(data) {

          $('.container-loader').hide()
          if (data.trim() == 'ok') {
            location.reload();
          } else {
            toast_s('error', 'Ocurrio un error ' + data)
          }
        });
      }
    });
  }


  function borrarCompra(id) {
    Swal.fire({
      title: "<strong>¿Está seguro?</strong>",
      icon: "warning",
      html: `La compra será eliminada con la información agregada por los usuarios.`,
      showCancelButton: true,
      confirmButtonColor: "#69a5ff",
      confirmButtonText: `Eliminar`,
      cancelButtonText: `Cancelar`,
    }).then((result) => {
      if (result.isConfirmed) {
        $('.container-loader').show()
        $.get("../../back/ajax/com_borrar_compra.php", "i=" + id, function(data) {
          $('.container-loader').hide()
          if (data.trim() == 'ok') {
            toast_s('success', 'Se eliminó correctamente')
            location.reload();
          } else {
            toast_s('error', 'Ocurrio un error ' + data)
          }
        });
      }
    });
  }


  function cerrarCompra(id) {
    Swal.fire({
      title: "<strong>¿Está seguro?</strong>",
      icon: "warning",
      html: `Se cerrará la compra y no podrá ser modificada.`,
      showCancelButton: true,
      confirmButtonColor: "#69a5ff",
      confirmButtonText: `Cerrar compra`,
      cancelButtonText: `Cancelar`,
    }).then((result) => {
      if (result.isConfirmed) {
        $('.container-loader').show()
        $.get("../../back/ajax/com_cerrar_compra.php", "i=" + id, function(data) {
          $('.container-loader').hide()
          if (data.trim() == 'ok') {
            location.reload();
          } else {
            toast_s('error', 'Ocurrio un error ' + data)
          }
        });
      }
    });
  }

  function compraRealizada(id) {
    Swal.fire({
      title: "<strong>¿Está seguro?</strong>",
      icon: "warning",
      html: `La compra se marcará como <strong>"Finalizada"</strong> y se notificará a lo usuarios involucrados.`,
      showCancelButton: true,
      confirmButtonColor: "#69a5ff",
      confirmButtonText: `Aceptar`,
      cancelButtonText: `Cancelar`,
    }).then((result) => {
      if (result.isConfirmed) {
        $('.container-loader').show()
        $.get("../../back/ajax/com_finalizada_compra.php", "i=" + id, function(data) {
          $('.container-loader').hide()
          if (data.trim() == 'ok') {
            location.reload();
          } else {
            toast_s('error', 'Ocurrio un error ' + data)
          }
        });
      }
    });
  }



  function infoProximaCompra(id, veh) {
    $('.container-loader').show()
    $.get("../../back/ajax/go_com_admin.php", "i=" + id + '&v=1' + '&veh=' + veh, function(data) {
      $('#contenido_empresa').html(data);
    });
    $.get("../../back/ajax/go_com_admin.php", "i=" + id + '&v=2' + '&veh=' + veh, function(data) {
      $('#contenido_insumos').html(data);
    });
    $.get("../../back/ajax/go_com_admin.php", "i=" + id + '&v=3' + '&veh=' + veh, function(data) {
      $('.container-loader').hide()
      $('#contenido_detalles').html(data);
    });
  }


  /* calendario */
  var settings = {
    LinkColor: '#333', //(string - color) font color of event titles.
  }
  var calendar_div = document.getElementById('caleandar');

  function uptate_calendar() {
    var events = [];
    $.get("../../back/ajax/go_com_calendar.php", "i=" + "7", function(data) {
      let result = data.split(';')

      result.forEach(element => {
        if (element != '') {
          let item = element.split('~')
          let fecha = item[0].split('-')
          let index = fecha[1] - 1;
          //  alert(fecha[0] +'-'+ index +'-'+ fecha[2])


          events.push({
            'Date': new Date(fecha[0], index, fecha[2]),
            'Title': item[1],
            'Link': function() {
              vistaCompra(item[2], item[1], item[0], item[3])
            },
          })
        }
      });
      caleandar(calendar_div, events, settings);
    });
  }
  uptate_calendar()
  /* calendario */


  function vistaCompra(id, nombre, fecha, veh) {
    infoProximaCompra(id, veh)

    $('#nombre_compra_c').html(nombre);
    $('#fecha_compra_c').html(fecha);
    document.querySelector('#detallesCompra').scrollIntoView();
  }
  vistaCompra("<?php echo $proximaCompra ?>", "<?php echo $proximaCompra_n ?>", "<?php echo $proximaCompra_f ?>", "<?php echo $veh ?>")









  $(document).ready(function(e) {
    $("#form").on('submit', function(e) {
      e.preventDefault();
      let formData = new FormData(this);


      if ($('#nombre').val() == '' || $('#tipoCompra').val() == '' || $('#fecha').val() == '') {
        toast_s('warning', 'Rellene todos los campos')
        return
      }
      $('button').attr('disabled', true);
      $('.container-loader').show();

      $.ajax({
        type: 'POST',
        url: '../../back/ajax/com_nueva_compra.php',
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function(msg) {
          $('button').attr('disabled', false);
          $('.from-control').val('');
          $('.container-loader').hide();
          toast_s('success', 'Se agrego correctamente')

          location.reload();
        }
      }).fail(function(jqXHR, textStatus, errorThrown) {
        $('.container-loader').hide();
        $('button').attr('disabled', false);

        if (jqXHR.status === 0) {
          alert('En este momento no tienes conexión a internet, inténtalo nuevamente.', '../assets/img/illustrations/mantenimiento.png')

        } else if (jqXHR.status == 404) {
          alert('Requested page not found [404]');
        } else if (jqXHR.status == 500) {
          alert('Internal Server Error [500].');
        } else if (textStatus === 'parsererror') {
          alert('Requested JSON parse failed.');
        } else if (textStatus === 'timeout') {
          alert('Time out error.');
        } else if (textStatus === 'abort') {
          alert('Ajax request aborted.');
        } else {
          alert('Uncaught Error: ' + jqXHR.responseText);
        }

      });

    });
  });
</script>

</html>