<?php
include('../../back/config/conexion.php');
include('../../back/config/funcione_globales.php');

if ($_SESSION["u_nivel"] != '1' && $_SESSION["u_nivel"] != '2' && $_SESSION["u_nivel"] != '3') {
  header("Location: ../index.php");
}


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
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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


  <style>
    .receipt {
      width: 520px;
      background: #fff;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
      border-radius: 5px;
    }

    /* Header */
    .header {
      text-align: center;
    }

    .header .logo img {
      max-width: 163px;
      margin: 0 auto;
    }

    .header h1 {
      font-size: 18px;
      margin: 10px 0 5px;
      font-weight: bold;
      line-height: 1.2;
    }

    /* Details generales */
    .details {
      text-align: center;
      margin: 10px 0;
    }

    .details p {
      margin: 5px 0;
      font-size: 14px;
      color: #333;
    }

    .monto-total {
      font-size: 15px;
      margin-top: 8px;
    }

    /* Separadores */
    hr {
      border: none;
      border-top: 1px dotted #ccc;
      margin: 10px 0;
    }

    /* Sección de detalles */
    .section {
      margin: 5px 0;
    }

    .section p {
      margin: 3px 0;
      font-size: 14px;
    }

    .section .factura {
      text-align: right;
      margin-top: 5px;
      font-size: 12px;
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
              <span class="text-muted fw-light">Contribución consciente /</span> Contribución consciente
            </h4>

            <style>
              .loader2 {
                width: 16px;
                height: 16px;
                border-radius: 50%;
                display: block;
                margin: 15px auto;
                position: relative;
                background: #FFF;
                box-shadow: -24px 0 #FFF, 24px 0 #FFF;
                box-sizing: border-box;
                animation: shadowPulse 2s linear infinite;
              }

              @keyframes shadowPulse {
                33% {
                  background: #FFF;
                  box-shadow: -24px 0 #69a5ff, 24px 0 #FFF;
                }

                66% {
                  background: #69a5ff;
                  box-shadow: -24px 0 #FFF, 24px 0 #FFF;
                }

                100% {
                  background: #FFF;
                  box-shadow: -24px 0 #FFF, 24px 0 #69a5ff;
                }
              }
            </style>


            <div class="row">
              <!-- Customer-detail Sidebar -->
              <!--/ Customer Sidebar -->
              <!-- Customer Content -->
              <div class="col-xl-12 order-0 order-md-1">
                <!-- / Customer cards -->

                <div class="col-lg-12">
                  <div class="card">

                    <div class="card-body">
                      <div class="mb-5 text-center">
                        <label for="cod_ced" class="form-label mb-3">Cédula o código del usuario</label>
                        <div class="input-group w-50 m-auto">
                          <input type="text" class="form-control" placeholder="Cédula / Código" id="cod_ced" name="cod_ced">
                          <button class="btn btn-primary" id="btn-buscar">Buscar</button>
                        </div>
                      </div>
                      <div class="text-center animated fadeInDown hide" id="consulta-loader">
                        <span class="loader2"></span>
                        <p id="text-loader">Esperando consulta</p>
                      </div>
                    </div>
                  </div>
                </div>



                <div class="col-lg-12">
                  <div class="card">

                    <div class="card-body">


                      <div class="receipt m-auto">
                        <div class="header">
                          <div class="logo">
                            <img src="../../assets/img/gobierno/epa.png" alt="Logo Empresa Pública Amazonas">
                          </div>
                          <h1>EMPRESA PÚBLICA AMAZONAS</h1>
                        </div>
                        <div class="details">
                          <p>G-0000</p>
                          <p>Empresa Pública de Amazonas</p>
                          <p>Pago de servicios <strong>(SA-HA-GC)</strong></p>
                          <p><?php echo date('Y-m-d h:i a') ?></p>
                          <p>*Factura <strong><?php echo rand(100000, 10000000); ?></strong></p>
                        </div>
                        <hr>

                        <!-- Sección de contribución 1 -->
                        <div class="section">
                          <p><strong>Contribución conciente: SANEAMIENTO AMBIENTAL.</strong></p>
                          <p>Descripción: <strong>Recolección de desechos.</strong></p>
                          <p>Número de contrato: <strong>J01R25.</strong></p>
                          <p>Monto: <strong>20Bs</strong></p>
                          <p class="factura">F <strong>315486</strong></p>
                        </div>
                        <hr>

                        <!-- Sección de contribución 2 -->
                        <div class="section">
                          <p><strong>Contribución conciente: AGUA POTABLE.</strong></p>
                          <p>Descripción: <strong>Agua por tubería.</strong></p>
                          <p>Número de contrato: <strong>J01R25.</strong></p>
                          <p>Monto: <strong>28Bs</strong></p>
                          <p class="factura">F <strong>315486</strong></p>
                        </div>
                        <hr>

                        <!-- Sección de contribución 3 -->
                        <div class="section">
                          <p><strong>Pago del servicio: GAS DOMESTICO.</strong></p>
                          <p>Descripción: <strong>(1) bombona 27kg.</strong></p>
                          <p>Número de contrato: <strong>J01R25.</strong></p>
                          <p>Monto: <strong>60Bs</strong></p>
                          <p class="factura">F <strong>315486</strong></p>
                        </div>
                        <hr>

                        <div class="text-center">
                          <p class="monto-total"><strong>Monto total: 108 Bs</strong></p>
                        </div>


                      </div>



                    </div>
                  </div>
                </div>

              </div>
            </div>
            <!--/ Customer Content -->
          </div>
        </div>
        <script>
          $(document).ready(function() {
            $('#btn-buscar').on('click', function() {
              var $loader = $('#consulta-loader');

              // Mostrar el loader con animación
              if ($loader.is(':visible')) {
                $loader.stop().animate({
                    height: 0,
                    opacity: 0,
                  },
                  300,
                  function() {
                    $loader.hide();
                  }
                );
              } else {
                $loader.show(); // Muestra el elemento
                var height = $loader.prop('scrollHeight'); // Altura real del contenido
                $loader
                  .css({
                    height: 0,
                    opacity: 0,
                  }) // Inicializa la altura
                  .stop()
                  .animate({
                      height: height,
                      opacity: 1,
                    },
                    300
                  );
              }

              // Obtener el valor del input con ID `#cod_ced`
              var identificador = $('#cod_ced').val();

              // Verificar si el campo está vacío
              if (!identificador) {
                alert('Por favor, ingresa un valor en el campo');
                return;
              }

              // Enviar la solicitud con fetch
              fetch('https://gitcom-ve.com/back/api', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json',
                  },
                  body: JSON.stringify({
                    identificador: identificador, // Enviar el input con el nombre 'identificador'
                  }),
                })
                .then((response) => {
                  if (!response.ok) {
                    throw new Error('Error en la solicitud: ' + response.statusText);
                  }
                  return response.json();
                })
                .then((data) => {
                  // Manejar la respuesta
                  console.log('Respuesta:', data);
                })
                .catch((error) => {
                  console.error('Error:', error);
                  alert('Ocurrió un error al realizar la consulta');
                })
                .finally(() => {
                  // Ocultar el loader después de finalizar la solicitud
                  $loader.stop().animate({
                      height: 0,
                      opacity: 0,
                    },
                    300,
                    function() {
                      $loader.hide();
                    }
                  );
                });
            });
          });
        </script>


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
</script>

</html>