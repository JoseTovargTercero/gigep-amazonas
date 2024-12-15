<?php
include('../../back/config/conexion.php');
include('../../back/config/funcione_globales.php');

if ($_SESSION["u_nivel"] != '1' && $_SESSION["u_nivel"] != '2' && $_SESSION["u_nivel"] != '3') {
  header("Location: ../index.php");
}

$user = $_SESSION["u_id"];

?>



</script>




<!DOCTYPE html>

<html lang="es" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title class="x" id="title">Seguridad</title>
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
              <span class="text-muted fw-light">Cuentas /</span> Seguridad
            </h4>





            <div class="col-md-12">
              <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item"><a class="nav-link" href="user_profile.php"><i class="bx bx-user me-1"></i> Cuenta</a></li>
                <li class="nav-item"><a class="nav-link active"><i class="bx bx-lock-alt me-1"></i> Seguridad</a></li>
                <li class="nav-item"><a class="nav-link" href="user_notification.php"><i class="bx bx-bell me-1"></i> Notificaciones</a></li>
              </ul>
              <div class="card mb-4">
                <h5 class="card-header">Cambiar contraseña</h5>
                <div class="card-body">
                  <div class="fv-plugins-bootstrap5 fv-plugins-framework">
                    <div class="row">
                      <div class="mb-3 col-md-6 form-password-toggle fv-plugins-icon-container">
                        <label class="form-label" for="currentPassword">Contraseña actual</label>
                        <div class="input-group input-group-merge has-validation">
                          <input class="form-control" type="password" name="currentPassword" id="currentPassword" placeholder="············">
                          <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="mb-3 col-md-6 form-password-toggle fv-plugins-icon-container">
                        <label class="form-label" for="newPassword">Nueva contraseña</label>
                        <div class="input-group input-group-merge has-validation">
                          <input class="form-control" type="password" onkeyup="fuerza(this.value)" id="newPassword" name="newPassword" placeholder="············">
                          <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>



                        </div>


                        <div class="progress mt-2" style="display: none;">
                          <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="passstrength">
                          </div>
                        </div>

                        <span class="infoPass text-danger" style="display: none;">La contraseña no cumple con los requisitos mínimos de seguridad</span>

                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                      </div>
                      <div class="mb-3 col-md-6 form-password-toggle fv-plugins-icon-container">
                        <label class="form-label" for="confirmPassword">Confirmar nueva ontraseña</label>
                        <div class="input-group input-group-merge has-validation">
                          <input class="form-control" type="password" name="confirmPassword" id="confirmPassword" oninput="igualarContrasenas(this.value, $('#newPassword').val())" placeholder="············">
                          <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>

                        <span class="infoPassN text-danger" style="display: none;">Las contraseñas no coinciden</span>

                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                      </div>
                      <div class="col-12 mb-4">
                        <p class="fw-medium mt-2">Requerimientos de la contraseña:</p>
                        <ul class="ps-3 mb-0">
                          <li class="mb-1">
                            Mínimo 8 caracteres: cuantos más, mejor.
                          </li>
                          <li class="mb-1">Al menos un carácter en minúscula y mayúscula.</li>
                          <li>Al menos un número y un símbolo.</li>
                        </ul>
                      </div>
                      <div class="col-12 mt-1">
                        <button type="submit" class="btn btn-primary me-2" onclick="updatePass()">Guardar cambios</button>
                      </div>
                    </div>

                  </div>
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


  <script src="../../assets/vendor/amcharts5/index.js"></script>
  <script src="../../assets/vendor/amcharts5/flow.js"></script>
  <script src="../../assets/vendor/amcharts5/percent.js"></script>
  <script src="../../assets/vendor/amcharts5/xy.js"></script>
  <script src="../../assets/vendor/amcharts5/themes/Animated.js"></script>
  <script src="../../assets/vendor/amcharts5/themes/Material.js"></script>
</body>

<script>
  function tieneSecuenciaDeNCaracteres(texto, N) {
    let max = N || 4, //cant de caracteres en secuencia inválida (4 predet).
      length = texto.length, //largo del texto
      caracterPrevio = texto[0], //guarda el caracter de la iteración anterior
      consecutivos = 1, //para ir incrementando cuando se encuentre una secuencia
      caracterActual; //el caracter que comparamos en cada iteración

    //Bucle caracter por caracter (desde el 2do hasta el fin)
    for (let i = 1; i < length; i++) {
      caracterActual = texto[i];
      if (siguienteCaracter(caracterPrevio) === caracterActual) {
        //está en secuencia con el anterior
        consecutivos++;
        if (consecutivos >= max) {
          //Máximo permitido => inválido
          return texto.substr(i - max + 1, max);
        }
      } else {
        //No está en secuencia => reiniciamos
        consecutivos = 1;
      }
      caracterPrevio = caracterActual;
    }
    //Si terminó y no encontró
    return false;
  }

  function siguienteCaracter(c) {
    //Podría mejorarlo, pero no tenía ganas de meterme a calcular módulos
    if (c === 'z') return 'a';
    if (c === 'Z') return 'A';
    if (c === '9') return '0';
    //le sumamos 1 y devolvemos
    return String.fromCodePoint(c.codePointAt() + 1);
  }


  function fuerza(value) {

    if (value == '') {
      $('.progress').hide(300);
      $('.infoPass').hide(300);

      return false;
    }
    if (tieneSecuenciaDeNCaracteres(value, 3) != false) {
      $('.infoPass').html('La contraseña no puede contener sucesiones de caracteres.');
      $('.infoPass').show(300);
      $('.progress').hide(300);
      return false;
    }

    var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
    var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
    var enoughRegex = new RegExp("(?=.{8,}).*", "g");

    if (false == enoughRegex.test(value)) {
      $('#passstrength').html('');
      $('#passstrength').width('0%');
      $('.progress').hide(300);
      $('.infoPass').html('La contraseña no cumple con los requisitos mínimos de seguridad.');
      $('.infoPass').show(300);
      return false;
    } else if (strongRegex.test(value)) {
      $('#passstrength').width('100%');
      $('#passstrength').html('Fuerte');
      $('.progress').show(300);
      $('.infoPass').hide(300);
      return true;
    } else if (mediumRegex.test(value)) {
      $('#passstrength').width('50%');
      $('#passstrength').html('Media');
      $('.progress').show(300);
      $('.infoPass').hide(300);
      return false;
    } else {
      $('#passstrength').width('25%');
      $('#passstrength').html('Debil');
      $('.progress').show(300);
      $('.infoPass').hide(300);
      return false;
    }
  }

  function igualarContrasenas(p2, p1) {
    if (p2 == '') {
      $('.infoPassN').hide(300);
      return false;
    }
    if (p2 != p1) {
      $('.infoPassN').show(300);
      return false;
    } else {
      $('.infoPassN').hide(300);
      return true;
    }
  }



  function updatePass() {

    let currentPassword = $('#currentPassword').val()
    let newPassword = $('#newPassword').val()
    let confirmPassword = $('#confirmPassword').val()


    if (currentPassword == '' || newPassword == '' || confirmPassword == '') {
      toast_s('error', 'Campos vacíos')
      return
    }
    if (igualarContrasenas(newPassword, confirmPassword) == false) {
      toast_s('error', 'Las contraseñas no coinciden')
      return
    }



    $('.container-loader').show()

    $.ajax({
      type: 'POST',
      url: '../../back/ajax/user_updatePass.php',
      dataType: 'html',
      data: {
        currentPassword: currentPassword,
        newPassword: newPassword,
        confirmPassword: confirmPassword
      },
      cache: false,
      success: function(msg) {
        $('.container-loader').hide()

        if (msg.trim() == 'error_pass') {
          toast_s('error', 'La contraseña actual no es correcta.')
        } else if (msg.trim() == 'error_diff') {
          toast_s('error', 'Las contraseñas no coinciden.')
        } else if (msg.trim() == 'ok') {
          toast_s('success', 'Se actualizó correctamente.')
          $('#currentPassword').val('')
          $('#newPassword').val('')
          $('#confirmPassword').val('')
        }
      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      // loader cargando hide
    });
  }
</script>

</html>