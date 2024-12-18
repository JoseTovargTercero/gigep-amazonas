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
              <span class="text-muted fw-light">Epa /</span> Linea de comunicación
            </h4>



            <div class="row" class="text-center">
              <!-- Customer-detail Sidebar -->
              <div class="col-lg-8 m-auto" id="tarjeta_principal">
                <!-- Customer-detail Card -->
                <div class="card-body">
                  <!-- Formulario -->
                  <form>
                    <!-- Fila Nombre y Email -->
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" disabled placeholder="Tu nombre" value="Jose Ricardo Romero" required>
                      </div>
                      <div class="col-md-6">
                        <label for="email" class="form-label">Dirección de Email</label>
                        <input type="email" class="form-control" id="email" value="jose.2710.ricardo@gmail.com" disabled>
                      </div>
                    </div>
                    <!-- Fila Asunto -->
                    <div class="mb-3">
                      <label for="asunto" class="form-label">Asunto</label>
                      <input type="text" class="form-control" id="asunto" placeholder="Escribe el asunto del ticket" required>
                    </div>
                    <!-- Fila Departamento, Servicios y Prioridad -->
                    <div class="row mb-3">
                      <div class="col-md-4">
                        <label for="departamento" class="form-label">Departamento</label>
                        <select class="form-select" id="departamento">
                          <option selected>Soporte General</option>
                          <option>Facturación</option>
                          <option>Técnico</option>
                        </select>
                      </div>
                      <div class="col-md-4">
                        <label for="servicios" class="form-label">Servicios Relacionados</label>
                        <select class="form-select" id="servicios">
                          <option value="">Seleccione</option>
                          <option>Agua</option>
                          <option>Saneamiento</option>
                          <option>Gas</option>
                        </select>
                      </div>
                      <div class="col-md-4">
                        <label for="prioridad" class="form-label">Prioridad</label>
                        <select class="form-select" id="prioridad">
                          <option>Alta</option>
                          <option selected>Media</option>
                          <option>Baja</option>
                        </select>
                      </div>
                    </div>
                    <!-- Fila Mensaje -->
                    <div class="mb-3">
                      <label for="mensaje" class="form-label">Mensaje</label>
                      <textarea class="form-control" id="mensaje" rows="5" placeholder="Describe tu consulta aquí"></textarea>
                    </div>
                    <!-- Adjuntos -->
                    <div class="mb-3">
                      <label for="adjunto" class="form-label">Adjuntos</label>
                      <input class="form-control" type="file" id="adjunto" multiple>
                      <small class="text-muted">Formatos permitidos: jpg, png, doc, pdf, zip, etc.</small>
                    </div>
                    <!-- Botones -->
                    <div class="d-flex justify-content-center mt-4">
                      <button type="submit" class="btn btn-primary me-3">Enviar</button>
                      <button type="reset" class="btn btn-secondary">Cancelar</button>
                    </div>
                  </form>
                </div>
                <!-- /Plan Card -->
              </div>
              <!--/ Customer Sidebar -->
              <!-- Customer Content -->

            </div>
            <!--/ Customer Content -->
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


  <script src="../../assets/vendor/amcharts5/index.js"></script>
  <script src="../../assets/vendor/amcharts5/flow.js"></script>
  <script src="../../assets/vendor/amcharts5/percent.js"></script>
  <script src="../../assets/vendor/amcharts5/xy.js"></script>
  <script src="../../assets/vendor/amcharts5/themes/Animated.js"></script>
  <script src="../../assets/vendor/amcharts5/themes/Material.js"></script>
</body>



</html>