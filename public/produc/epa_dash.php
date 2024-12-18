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

    #tarjeta_principal {
      transition: all 0.5s ease-in-out;
      /* Ajusta la duración y el efecto de la transición según tus necesidades */
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
              <span class="text-muted fw-light">Epa /</span> Contribución consciente
            </h4>



            <div class="row" class="text-center">
              <!-- Customer-detail Sidebar -->
              <div class="col-lg-8 m-auto" id="tarjeta_principal">
                <!-- Customer-detail Card -->
                <div class="card mb-4">
                  <div class="card-body">
                    <!-- Mensaje de pago vencido -->
                    <div class="alert alert-custom text-center animated fadeIn" role="alert">
                      <img id="image" src="../../assets/img/icons/productivity.png" width="70px">
                      <h4 class="alert-heading mt-3" id="titulo">¡Atención!</h4>
                      <p id="texto">Tu aporte mensual es esencial para seguir mejorando. Te invitamos a realizar tu contribución a tiempo y así ser parte del crecimiento continuo que beneficia a todo nuestro estado.</p>

                      <button id="btn-mostrar-info" class="btn btn-danger">Realizar contribución</button>
                    </div>

                    <!-- Botón para mostrar información -->

                    <!-- Información para realizar el pago -->
                    <div id="informacion-pago" class="animated fadeIn hide">
                      <div class="row">
                        <!-- Datos de transferencia bancaria -->
                        <div class="col-lg-4 mb-4">
                          <div class="card-header bg-primary text-white">
                            <h5 class="mb-0 text-white">Datos bancarios</h5>
                          </div>
                          <div class="card-body mt-4">
                            <p><strong>Banco:</strong> Venezuela.</p>
                            <p><strong>Cuenta N°:</strong> 01234567890123456</p>
                            <p><strong>Nombre del Titular:</strong> Empresa Pública</p>
                            <p><strong>Rif:</strong> J012345678</p>
                            <p><strong>Teléfono:</strong> 0416-0131415</p>
                          </div>
                        </div>

                        <!-- Formulario de registro -->
                        <div class="col-lg-7">
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="mb-3">
                                <label for="fechaOperacion" class="form-label">Fecha de la Operación</label>
                                <input type="date" class="form-control" id="fechaOperacion" required>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="mb-3">
                                <label for="tipo_operacion" class="form-label">Tipo de Operación</label>
                                <select class="form-control" id="tipo_operacion" required>
                                  <option value="">Seleccione</option>
                                  <option value="Transferencia">Transferencia</option>
                                  <option value="Biopago">Biopago</option>
                                </select>
                              </div>
                            </div>
                          </div>



                          <div class="mb-3">
                            <label for="bancoEmisor" class="form-label">Banco Emisor</label>
                            <select type="text" class="form-control" id="bancoEmisor" placeholder="Ej: Banco XYZ" required>
                              <option value="">Selecciones</option>
                              <option value="0105 - MERCANTIL BANCO UNIVERSAL">0105 - MERCANTIL BANCO UNIVERSAL</option>
                              <option value="0102 - BANCO DE VENEZUELA S.A. BANCO UNIVERSAL">0102 - BANCO DE VENEZUELA S.A. BANCO UNIVERSAL</option>
                              <option value="0104 - VENEZOLANO DE CREDITO, S.A. BANCO UNIVERSAL">0104 - VENEZOLANO DE CREDITO, S.A. BANCO UNIVERSAL</option>
                              <option value="0108 - BANCO PROVINCIAL S.A. BANCO UNIVERSAL">0108 - BANCO PROVINCIAL S.A. BANCO UNIVERSAL</option>
                              <option value="0114 - BANCO DEL CARIBE S.A.C.A.">0114 - BANCO DEL CARIBE S.A.C.A.</option>
                              <option value="0115 - BANCO EXTERIOR, C.A.">0115 - BANCO EXTERIOR, C.A.</option>
                              <option value="0116 - BANCO OCCIDENTAL DE DESCUENTO S.A.C.A.">0116 - BANCO OCCIDENTAL DE DESCUENTO S.A.C.A.</option>
                              <option value="0128 - BANCO CARONI, C.A. BANCO UNIVERSAL">0128 - BANCO CARONI, C.A. BANCO UNIVERSAL</option>
                              <option value="0134 - BANESCO BANCO UNIVERSAL">0134 - BANESCO BANCO UNIVERSAL</option>
                              <option value="0137 - BANCO SOFITASA ">0137 - BANCO SOFITASA </option>
                              <option value="0138 - BANCO PLAZA">0138 - BANCO PLAZA</option>
                              <option value="0151 - FONDO COMUN, C.A. BANCO UNIVERSAL">0151 - FONDO COMUN, C.A. BANCO UNIVERSAL</option>
                              <option value="0156 - 100% BANCO, BANCO UNIVERSAL C.A.">0156 - 100% BANCO, BANCO UNIVERSAL C.A.</option>
                              <option value="0157 - DEL SUR BANCO UNIVERSAL, C.A.">0157 - DEL SUR BANCO UNIVERSAL, C.A.</option>
                              <option value="0163 - BANCO DEL TESORO">0163 - BANCO DEL TESORO</option>
                              <option value="0166 - BANCO AGRICOLA DE VENEZUELA C.A.">0166 - BANCO AGRICOLA DE VENEZUELA C.A.</option>
                              <option value="0168 - BANCRECER S.A. BANCO MICROFINANCIERO">0168 - BANCRECER S.A. BANCO MICROFINANCIERO</option>
                              <option value="0169 - MIBANCO BANCO DE DESARROLLO">0169 - MIBANCO BANCO DE DESARROLLO</option>
                              <option value="0171 - BANCO ACTIVO, C.A.">0171 - BANCO ACTIVO, C.A.</option>
                              <option value="0172 - BANCAMIGA BANCO UNIVERSAL">0172 - BANCAMIGA BANCO UNIVERSAL</option>
                              <option value="0174 - BANPLUS BANCO UNIVERSAL, C.A.">0174 - BANPLUS BANCO UNIVERSAL, C.A.</option>
                              <option value="0175 - BANCO BICENTENARIO BANCO UNIVERSAL C.A.">0175 - BANCO BICENTENARIO BANCO UNIVERSAL C.A.</option>
                              <option value="0177 - BANCO DE LA FUERZA ARMADA NACIONAL BOLIVARIANA">0177 - BANCO DE LA FUERZA ARMADA NACIONAL BOLIVARIANA</option>
                              <option value="0191 - BANCO NACIONAL DE CREDITO, C.A.">0191 - BANCO NACIONAL DE CREDITO, C.A.</option>
                            </select>
                          </div>
                          <div class="mb-3">
                            <label for="montoTransferido" class="form-label">Monto Transferido</label>
                            <input type="number" value="250.00" step="0.01" class="form-control" id="montoTransferido" placeholder="Ej: 1500.00" required>
                          </div>
                          <div class="mb-3">
                            <label for="numeroOperacion" class="form-label">Número de Operación</label>
                            <input type="text" class="form-control" id="numeroOperacion" placeholder="Ej: 123456789" required>
                          </div>
                          <div class="mb-3">
                            <label for="voucher" class="form-label">Voucher (Foto de la Operación)</label>
                            <input type="file" class="form-control" id="voucher" accept="image/*" required>
                          </div>
                          <button type="button" id="btn_imprimar" class="btn btn-primary w-100">Enviar</button>
                        </div>
                      </div>
                    </div>

                    <!-- Formulario para cargar comprobante -->
                    <div id="comprobante-form" class="mt-4 hide">
                      <h5>Subir comprobante</h5>
                      <form>
                        <div class="mb-3">
                          <label for="archivo-comprobante" class="form-label">Selecciona el archivo del comprobante:</label>
                          <input type="file" class="form-control" id="archivo-comprobante" required>
                        </div>
                        <button type="submit" class="btn btn-success">Enviar comprobante</button>
                      </form>
                    </div>

                  </div>
                </div>
                <!-- /Plan Card -->
              </div>
              <!--/ Customer Sidebar -->
              <!-- Customer Content -->

            </div>
            <!--/ Customer Content -->
          </div>
        </div>

        <script>
          // Mostrar información de pago
          document.getElementById("btn-mostrar-info").addEventListener("click", function() {
            $('.alert-custom').addClass('hide');

            // Agregar animación al ancho del div
            $('#tarjeta_principal').removeClass('col-lg-8').addClass('col-lg-11');

            $('#informacion-pago').removeClass('hide');
          });
        </script>


      </div>





      <script>
        document.getElementById("btn_imprimar").addEventListener("click", function() {
          $('.alert-custom').removeClass('hide');
          // Agregar animación al ancho del div
          $('#tarjeta_principal').addClass('col-lg-8').addClass('col-lg-11');

          $('#informacion-pago').addClass('hide');
          // cambiar el src de #image
          var image = document.getElementById("image");
          image.src = "../../assets/img/icons/servicio.png";



          $('#titulo').html('Procesando')
          $('#texto').html('¡Gracias por tu compromiso! Tu contribución está al día y gracias a ti seguimos mejorando y ofreciendo un servicio de calidad. Juntos construimos un mejor futuro.')
          toast_s('info', 'Enviado correctamente. En revision.')
          $('#btn-mostrar-info').addClass('hide')


        });
      </script>

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



</html>