<?php

include("../back/config/conexion.php");

if (!$_GET['tk']) {
  define('PAGINA_INICIO', 'index');
  header('Location: ' . PAGINA_INICIO);
}

$u = $_GET['u'];
$tk = $_GET['tk'];

	
$stmt = mysqli_prepare($conexion, "SELECT * FROM system_users WHERE u_id = ? AND u_status=0");
$stmt->bind_param("i", $u);
$stmt->execute();
$result = $stmt->get_result();
  if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
    if ($tk != $row['u_token']) {

    define('PAGINA_INICIO', 'index');
    header('Location: ' . PAGINA_INICIO);
  }
}
}else {

  define('PAGINA_INICIO', 'index');
  header('Location: ' . PAGINA_INICIO);
}

?>

<!DOCTYPE html>
<html lang="es" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free">

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
  <!-- Content -->

  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register Card -->
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
            <h4 class="mb-2">Activación del usuario</h4>
            <p class="mb-4">Indique una contraseña segura</p>

            <form id="formAuthentication" class="mb-3">

              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">Contraseña</label>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>

                </div>




                <div class="progress mt-2">
                  <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="passstrength">
                  </div>
                </div>







              </div>


              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password-2">Repetir la contraseña</label>
                <div class="input-group input-group-merge">
                  <input type="password" id="password-2" class="form-control" name="password-2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password-2" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>


              <button class="btn btn-primary d-grid w-100">Verificar</button>
            </form>

            <p class="text-center">
              <?php echo date('Y'); ?> &copy; Empresa Pública de Amazonas
            </p>
          </div>
        </div>
        <!-- Register Card -->
      </div>
    </div>
  </div>



  <script src="../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/vendor/js/bootstrap.js"></script>
  <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../assets/js/main.js"></script>

  <link rel="stylesheet" href="../assets/vendor/strength/strength.css" />
  <script src="../assets/vendor/strength/strength.min.js"></script>


  <script>
    
    let u = "<?php echo $_GET['u'] ?>";
    let t = "<?php echo $_GET['tk'] ?>";


    var pass = '';
    $('#password').keyup(function(e) {
      var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
      var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
      var enoughRegex = new RegExp("(?=.{6,}).*", "g");
      if (false == enoughRegex.test($(this).val())) {
        $('#passstrength').html('');
        $('#passstrength').width('0%');
        pass = '0';
      } else if (strongRegex.test($(this).val())) {
        $('#passstrength').width('100%');
        $('#passstrength').html('Fuerte');
        pass = '100';
      } else if (mediumRegex.test($(this).val())) {
        $('#passstrength').width('50%');
        $('#passstrength').html('Media');
        pass = '50';
      } else {
        $('#passstrength').width('25%');
        $('#passstrength').html('Débil');
        pass = '25';
      }
    });




    $(document).ready(function(e) {
      $("#formAuthentication").on('submit', function(e) {

        e.preventDefault();

        let formData = new FormData(this);


        if ($('#password-2').val() == '' || $('#password').val() == '') {
          toast_s('error', 'Hay campos vacios')
          return;
        }

        if ($('#password-2').val() != $('#password').val()) {
          toast_s('error', 'Las contraseñas no coinciden')
          return;
        }

        switch (pass) {
          case '0':
            toast_s('error', 'La contraseña no es segura')
            return;
            break;
          case '25':
            toast_s('error', 'La contraseña no es segura')
            return;
            break;
          case '50':
            toast_s('error', 'La contraseña no es segura')
            return;
            break;

        }

        formData.append('u', u);
        formData.append('t', t);


        $.ajax({
          type: 'POST',
          url: '../back/ajax/activate_activate.php',
          data: formData,
          contentType: false,
          cache: false,
          processData: false,
          success: function(msg) {


            if (msg.trim() == 'acivado') {
               window.location.href='index';
            } else if (msg.trim() == 'error_t') {
              toast_s('error', 'error en el token')

            } else if (msg.trim() == 'error_n') {
              toast_s('error', 'sin peticion')

            } else if (msg.trim() == 'error_i') {
              toast_s('error', 'Error Interno')
            }else{
              console.log(msg)
            }





          }
        });

      });

    });
  </script>

</body>

</html>