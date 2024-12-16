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
  <title class="epa" id="title">Facturación</title>
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

    .loader-3 {
      width: 100%;
      height: 250px;
      display: block;
      margin: auto;
      position: relative;
      background: #FFF;
      box-sizing: border-box;
    }

    .loader-3::after {
      content: '';
      width: calc(100% - 30px);
      height: calc(100% - 30px);
      top: 15px;
      left: 15px;
      position: absolute;
      background-image: linear-gradient(100deg, transparent, rgba(255, 255, 255, 0.5) 50%, transparent 80%), radial-gradient(circle 28px at 28px 28px, #DDD 99%, transparent 0), linear-gradient(#DDD 24px, transparent 0), linear-gradient(#DDD 18px, transparent 0), linear-gradient(#DDD 66px, transparent 0);
      background-repeat: no-repeat;
      background-size: 75px 130px, 55px 56px, 100% 90px, 100% 60px, 100% 56px;
      background-position: 0% 0, 0 0, 70px 5px, 70px 38px, 0px 66px;
      box-sizing: border-box;
      animation: animloader 1s linear infinite;
    }

    @keyframes animloader {
      0% {
        background-position: 0% 0, 0 0, 70px 5px, 70px 38px, 0px 66px;
      }

      100% {
        background-position: 150% 0, 0 0, 70px 5px, 70px 38px, 0px 66px;
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
              <span class="text-muted fw-light">Contribución consciente /</span> Contribución consciente
            </h4>


            <div class="row">
              <!-- Customer-detail Sidebar -->
              <!--/ Customer Sidebar -->
              <!-- Customer Content -->

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
                      <p id="text-loader">Esperando respuesta</p>
                    </div>
                    <hr>



                    <span class="loader-3 w-100"></span>
                    <section class="row mt-5 hide" id="sect_info">
                      <div class="col-lg-4">
                        <div class="user-card user-card-1 pe-2" style="border-right: 1px solid lightgray;">
                          <div class="card-body pb-0">
                            <div class="float-end"><span class="badge bg-light-danger">Pro</span></div>
                            <div class="d-flex user-about-block align-items-center mt-0 mb-3">
                              <div class="flex-shrink-0">
                                <div class="position-relative d-inline-block"><img width="70px" src="../../assets/img/icons/user.png" alt="User image">
                                  <div class="certificated-badge"><i class="fas fa-certificate text-primary bg-icon"></i> <i class="fas fa-check front-icon text-white"></i></div>
                                </div>
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1" id="info_nombre"></h6>
                                <p class="mb-0 text-muted" id="info_tipo"></p>
                              </div>
                            </div>
                          </div>
                          <ul class="list-group list-group-flush">
                            <li class="list-group-item"><span class="f-w-500"><i class='bx bx-credit-card'></i> Deuda total</span> <b class="float-end" id="info_telefono">245 bs</b></li>
                            <li class="list-group-item border-bottom-0"><span class="f-w-500"><i class="feather icon-map-pin m-r-10"></i>Parroquia</span> <b class="float-end" id="info_Parroquia"></b></li>
                            <li class="list-group-item border-bottom-0"><span class="f-w-500"><i class="feather icon-map-pin m-r-10"></i>Comuna</span> <b class="float-end" id="info_comuna"></b></li>
                            <li class="list-group-item border-bottom-0"><span class="f-w-500"><i class="feather icon-map-pin m-r-10"></i>Comunidad</span> <b class="float-end" id="info_comunidad"></b></li>
                          </ul>
                        </div>
                      </div>
                      <div class="col-lg-8">

                        <div class="d-flex justify-content-between">
                          <h3>Servicios</h3>
                          <p>Ultimo pago: <b>02/11/2024</b> </p>
                        </div>


                        <table class="mt-2 mb-4 table table-hover">
                          <thead>
                            <tr>
                              <th></th>
                              <th>Servicio</th>
                              <th>Meses vencidos</th>
                              <th>Deuda total</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td><img style="width: 40px" src="../../assets/img/icons/agua.png" alt="activity-user"></td>
                              <td>
                                <h6 class="mb-1">Agua</h6>
                                <p class="m-0">Estatus <span class="text-danger"> Deuda</span></p>
                              </td>
                              <td><span class="pie_1">1</span></td>

                              <td>
                                <h6 class="m-0">115 Bs</h6>
                              </td>

                            </tr>
                            <tr>
                              <td><img style="width: 40px" src="../../assets/img/icons/basura.png" alt="activity-user"></td>
                              <td>
                                <h6 class="mb-1">Saneamiento ambiental</h6>
                                <p class="m-0">Estatus <span class="text-danger"> Deuda</span></p>
                              </td>
                              <td><span class="pie_2">1</span></td>

                              <td>
                                <h6 class="m-0">30 Bs</h6>
                              </td>

                            </tr>

                            <tr>
                              <td><img style="width: 40px" src="../../assets/img/icons/gas.png" alt="activity-user"></td>
                              <td>
                                <h6 class="mb-1">Gas domestico</h6>
                                <p class="m-0">Mediano <span class="text-info"> (1)</span></p>
                              </td>
                              <td><span class="text-success"> Disponible</span></td>

                              <td>
                                <h6 class="m-0">110 Bs</h6>
                              </td>

                            </tr>

                          </tbody>
                        </table>

                      </div>



                      <section id="pago">


                        <style>
                          .heading {
                            font-size: 23px;
                            font-weight: 00
                          }



                          .pricing {
                            border: 2px solid #304FFE;
                            background-color: #f2f5ff
                          }

                          .business {
                            font-size: 20px;
                            font-weight: 500
                          }

                          .plan {
                            color: #aba4a4
                          }

                          .dollar {
                            font-size: 16px;
                            color: #6b6b6f
                          }

                          .amount {
                            font-size: 50px;
                            font-weight: 500
                          }

                          .year {
                            font-size: 20px;
                            color: #6b6b6f;
                            margin-top: 19px
                          }

                          .detail {
                            font-size: 22px;
                            font-weight: 500
                          }

                          .cvv {
                            height: 44px;
                            width: 73px;
                            border: 2px solid #eee
                          }

                          .cvv:focus {
                            box-shadow: none;
                            border: 2px solid #304FFE
                          }

                          .email-text {
                            height: 55px;
                            border: 2px solid #eee
                          }

                          .email-text:focus {
                            box-shadow: none;
                            border: 2px solid #304FFE
                          }

                          .payment-button {
                            height: 70px;
                            font-size: 20px
                          }
                        </style>


                      </section>



                      <div class="text-end">
                        <button class="btn btn-info mt-3" id="btn-pay"><i class='bx bx-credit-card'></i>&nbsp;&nbsp;PAGAR</button>
                      </div>
                    </section>
                  </div>
                </div>
              </div>
            </div>



            <div class="row mt-2 hide" id="pago_pro">
              <div class="mt-3  col-lg-6">

                <div class="card p-5">
                  <div>
                    <h4 class="heading">Contribución conciente</h4>
                    <p class="text-muted">Pago procesado por: <b>NARCIBEL VASQUEZ</b></p>
                  </div>
                  <div class="pricing p-3 rounded mt-4 d-flex justify-content-between">
                    <div class="images d-flex flex-row align-items-center "> <img class="bg-danger p-1 rounded me-2" style="filter: invert();" src="../../assets/img/icons/coh.png" class="rounded" width="60">
                      <div class="d-flex flex-column ml-4"> <span class="business">Servicios</span> <span class="plan">HA / SA / GC</span> </div>
                    </div> <!--pricing table-->
                    <div class="ms-4 d-flex flex-row align-items-center"> <span class="amount ml-1 mr-1">255 bs</span> <span class="year font-weight-bold">/ mes</span> </div> <!-- /pricing table-->
                  </div> <span class="detail mt-5">Detalles del pago</span>
                  <div class="credit rounded mt-4 d-flex justify-content-between align-items-center">

                    <div class="d-flex align-items-center w-100">
                      <img src="https://i.imgur.com/qHX7vY1.png" class="rounded" width="70">

                      <select class="form-control ms-3 flex-grow-1" id="">
                        <option value="" class="text-muted">Tipo de pago</option>
                        <option value="">Punto de venta</option>
                        <option value="">Biopago</option>
                        <option value="">Transferencia bancaria</option>
                        <option value="">Pago Movil</option>
                        <option value="">Divisas</option>
                      </select>
                    </div>

                  </div>

                  <h6 class="mt-4 text-primary">NUMERO DE TRANSACCIÓN</h6>
                  <div class="email mt-2"> <input type="text" class="form-control email-text" placeholder="Numero de transacción"> </div>
                  <div class="mt-3 text-center">
                    <button id="btn_imprimir" class="btn btn-primary btn-block ">Procesar el pago <i class="fa fa-long-arrow-right"></i></button>
                  </div>
                </div>
              </div>

              <div class="mt-3 col-lg-6">
                <div class="card p-3" id="c_ip">
                  <div class="header ">
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
                    <p>*Factura <strong>315486</strong></p>
                    <div class="text-center">
                      <p class="monto-total"><strong>Monto total: 255 Bs</strong></p>
                    </div>
                  </div>
                  <hr>

                  <!-- Sección de contribución 1 -->
                  <div class="section p-3">
                    <p><strong>Contribución conciente: SANEAMIENTO AMBIENTAL.</strong></p>
                    <p>Descripción: <strong>Recolección de desechos.</strong></p>
                    <p>Número de contrato: <strong>J01R25.</strong></p>
                    <p>Monto: <strong>30 bs</strong></p>
                    <p class="factura">F <strong>315486</strong></p>
                  </div>
                  <hr>

                  <!-- Sección de contribución 2 -->
                  <div class="section p-3">
                    <p><strong>Contribución conciente: AGUA POTABLE.</strong></p>
                    <p>Descripción: <strong>Agua por tubería.</strong></p>
                    <p>Número de contrato: <strong>J01R25.</strong></p>
                    <p>Monto: <strong>115 Bs</strong></p>
                    <p class="factura">F <strong>315486</strong></p>
                  </div>
                  <hr>

                  <!-- Sección de contribución 3 -->
                  <div class="section p-3">
                    <p><strong>Pago del servicio: GAS DOMESTICO.</strong></p>
                    <p>Descripción: <strong>(1) bombona 17kg.</strong></p>
                    <p>Número de contrato: <strong>J01R25.</strong></p>
                    <p>Monto: <strong>110bs </strong></p>
                    <p class="factura">F <strong>315486</strong></p>
                  </div>
                  <hr>

                  <div class="text-center">
                    <p class="monto-total"><strong>Monto total: 255 Bs</strong></p>
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

          // Obtener el valor del input con ID `#cod_ced`
          var identificador = $('#cod_ced').val();

          // Verificar si el campo está vacío
          if (!identificador) {
            toast_s('warning', 'Por favor, ingresa un valor en el campo')
            return;
          }


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

              if (data['message'] == 'No se encontraron resultados') {
                toast_s('warning', 'No se encontraron resultados')
                return;
              }
              // Manejar la respuesta
              $('.loader-3').hide(300)
              $('#sect_info').removeClass('hide')

              $('#info_nombre').html(data[0]['nombre'])
              $('#info_tipo').html(data[0]['rol_familiar'])
              //    $('#info_telefono').html(data[0]['telefono'])
              $('#info_Parroquia').html(data[0]['nombre_parroquia'])
              $('#info_comuna').html(data[0]['nombre_comuna'])
              $('#info_comunidad').html(data[0]['nombre_c_comunal'])

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


        $('#btn-pay').on('click', function() {
          $('#sect_info').addClass('hide')
          $('#pago_pro').removeClass('hide')

        });
      });






      document.getElementById("btn_imprimir").addEventListener("click", function() {
        // Capturamos el contenido del div
        const contenido = document.getElementById("c_ip").innerHTML;

        // Abrimos una nueva ventana o pestaña
        const ventana = window.open("", "_blank", "width=400,height=600");

        // Escribimos el contenido en la nueva ventana
        ventana.document.open();
        ventana.document.write(`
        <!DOCTYPE html>
        <html>
          <head>
            <title>Impresión</title>
            <style>
              /* Puedes agregar estilos personalizados aquí si es necesario */
              body {
                font-family: Arial, sans-serif;
                margin: 20px;
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
                        </head>
                        <body>
                          ${contenido}
                        </body>
                      </html>
                    `);
        ventana.document.close();


        // Forzar impresión
        ventana.print();

        // Cerrar la ventana después de un tiempo fijo (fallback para onafterprint)
        setTimeout(() => {
          if (!ventana.closed) {
            ventana.close();
            $('#pago_pro').addClass('hide')
            $('#cod_ced').val('')
            Swal.fire({
              title: "Buen trabajo",
              text: "Se proceso el pago correctamente",
              icon: "success"
            });
          }
        }, 2000); // Ajusta el tiempo según sea necesario
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
  /*
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


*/
</script>

</html>