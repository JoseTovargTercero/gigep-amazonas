<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>SIGEP</title>
  <meta name="description" content="" />
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
  <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
  <!-- Core CSS -->
  <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />
  <!-- Vendors CSS -->
  <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <!-- Page CSS -->
  <!-- Page -->
  <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />
  <link rel="stylesheet" href="../assets/css/animate.css" />
  <!-- Helpers -->
  <script src="../assets/vendor/js/helpers.js"></script>
  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="../assets/js/config.js"></script>
  <script src="../js/sweetalert2.all.min.js"></script>

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

  <!-- Content -->

  <div class="container-xxl">

    <div class="authentication-wrapper authentication-basic container-p-y  animated fadeIn">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card">

          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="index.html" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">
                  <img src="../assets/img/logo.png" alt="logo" width="40px">
                </span>
                <span class="app-brand-text demo text-body fw-bolder" style="text-transform: none;">SIGEP</span>
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-2">Bienvenido a SIGEP! 👋</h4>
            <p class="mb-4">Por favor, ingrese sus datos para empezar!</p>

            <form id="formAuthentication" class="mb-3" method="POST">
              <div class="mb-3">
                <label for="email" class="form-label">Correo</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Ingrese su correo electrónico" autofocus required />
              </div>
              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Contraseña</label>
                  <a href="auth-forgot-password-basic.html">
                    <small>Olvido su contraseña?</small>
                  </a>
                </div>
                <div class="input-group input-group-merge">
                  <input autocomplete="FALSE" type="password" id="password" name="password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember-me" />
                  <label class="form-check-label" for="remember-me"> Dispositivo del usuario.</label>
                </div>
              </div>
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100 pi-c" type="submit">

                  <span class="d-flex">
                    Entrar
                    <div id="loader" class="spinner-border spinner-border-sm text-white l-btn-login" role="status"><span class="visually-hidden">Loading...</span></div>
                  </span>

                </button>
              </div>
            </form>

            <p class="text-center">
              <?php echo date('Y'); ?> &copy; Empresa Pública de Amazonas
            </p>
          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>
  </div>

  <?php require('includes/alerts.html'); ?>




  <script src="../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/vendor/js/bootstrap.js"></script>
  <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../assets/js/main.js"></script>




  <script>
    $(document).ready(function(e) {
      $("#formAuthentication").on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $('button').attr('disabled', true);
        $('#loader').show();

        if ($('#email').val() == '' || $('#password').val() == '') {
          return
        }

        $.ajax({
          type: 'POST',
          url: '../login/validate.php',
          data: formData,
          contentType: false,
          cache: false,
          processData: false,
          success: function(msg) {
            $('button').attr('disabled', false);
            $('#loader').hide();


            if (msg.trim().indexOf('b_temp') != '-1') {
              let tiempoRestante = msg.split('*')[1]
              
              toast_s('warning', 'Se ha bloqueado temporalmente el acceso desde este dispositivo. <br><strong>Restan ' + tiempoRestante + ' minutos</strong>.')
           
              return;
            } else if (msg.trim() == 'false') {
              toast_s('warning', 'Usuario o contraseña incorrecta')
            } else if (msg.trim() == 'true') {
              window.location.href = 'produc/user_profile.php';
            } else if (msg.trim() == 'user_bloqueado') {

              Swal.fire({
                title: "Opss!",
                icon: "warning",
                html: `Usuario bloqueado, es necesario actualizar sus datos de acceso..`,
                confirmButtonColor: "#69a5ff",
                showCancelButton: false,
                confirmButtonText: "Continuar",
              })
            } else if (msg.trim() == 'user_pendiente') {

              Swal.fire({
                title: "Acción necesaria",
                icon: "info",
                html: `Verifique la bandeja de entrada de su correo y siga las instrucciones para <strong>completar la información de su usuario</strong>.`,
                confirmButtonColor: "#69a5ff",
                showCancelButton: false,
                confirmButtonText: "Continuar",
              })

            } else if (msg.trim() == 'user_ban') {

              Swal.fire({
                title: "Denegado!",
                icon: "warning",
                html: `Usuario con acceso denegado, <strong>comuníquese con el administrador.</strong>`,
                confirmButtonColor: "#69a5ff",
                showCancelButton: false,
                confirmButtonText: "Continuar",
              })

            } else {
              console.log(msg)
            }
          }
        }).fail(function(jqXHR, textStatus, errorThrown) {
          $('#loader').hide();
          $('button').attr('disabled', false);

          if (jqXHR.status === 0) {
            noticia('Opss!', 'En este momento no tienes conexión a internet, inténtalo nuevamente.', '../assets/img/illustrations/mantenimiento.png')

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
</body>

</html>
<?php
ob_end_flush();
?>