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
  <title class="x" id="title">Cuenta</title>
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
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.css" />
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
              <span class="text-muted fw-light">Cuentas /</span> Información del perfil
            </h4>





            <div class="col-md-12">
              <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item"><a class="nav-link active"><i class="bx bx-user me-1"></i> Cuenta</a></li>
                <li class="nav-item"><a class="nav-link" href="user_security.php"><i class="bx bx-lock-alt me-1"></i> Seguridad</a></li>
                <li class="nav-item"><a class="nav-link" href="user_notification.php"><i class="bx bx-bell me-1"></i> Notificaciones</a></li>
              </ul>
              <div class="card mb-4">
                <h5 class="card-header">Detalles de la cuenta</h5>
                <!-- Account -->
                <div class="card-body">
                  <div class="d-flex align-items-start align-items-sm-center gap-4">

                    <?php

                    if (file_exists('../../assets/img/avatars/' . $_SESSION['u_id'] . '.png')) {
                      echo '  <img style="    border: 1px solid lightgray;" src="../../assets/img/avatars/' . $_SESSION['u_id'] . '.png" class="d-block rounded" alt="foto de perfil" height="100" width="100"/>';
                    } else {
                      echo '  <span style="height: 100px; width: 100px; font-size: 35px" class="avatar-initial rounded bg-label-danger grid-center fw-bold">' . substr($_SESSION['u_nombre'], 0, 1) . '</span>';
                    }
                    ?>




                    <form enctype="multipart/form-data" id="filesForm">
                      <div class="button-wrapper d-flex">
                        <label for="photo" class="btn btn-primary me-2 mb-4" tabindex="0">
                          <span class="d-none d-sm-block">Subir nueva foto</span>
                          <i class="bx bx-upload d-block d-sm-none"></i>
                          <input type="file" name="photo[]" id="photo" onchange="setFoto()" class="account-file-input" hidden="" accept="image/png, image/jpeg, image/gif">
                        </label>

                        <?php

                        if (file_exists('../../assets/img/avatars/' . $_SESSION['u_id'] . '.png')) {
                          echo ' <button type="button" class="btn btn-label-secondary account-image-reset mb-4" onclick="eliminarFoto()">
                            <i class="bx bx-reset d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Eliminar</span>
                          </button>';
                        }
                        ?>



                      </div>
                      <p class="text-muted mb-0">Formatos permitidos JPG, GIF o PNG</p>
                    </form>
                  </div>
                </div>
                <hr class="my-0">
                <div class="card-body">
                  <div class="row">
                    <div class="mb-3 col-md-6 fv-plugins-icon-container">
                      <label for="firstName" class="form-label">Nombres</label>
                      <span class="form-control"><?php echo $_SESSION["u_nombre"] ?> </span>
                      <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                    </div>

                    <div class="mb-3 col-md-6">
                      <label for="email" class="form-label">Correo</label>
                      <span class="form-control"><?php echo $_SESSION["u_e"] ?> </span>
                    </div>
                    <div class="mb-3 col-md-6">
                      <label for="organization" class="form-label">Empresa/Institución</label>
                      <span class="form-control"><?php echo $_SESSION["u_ente"] ?> </span>
                    </div>
                    <div class="mb-3 col-md-6">
                      <label class="form-label" for="phoneNumber">Numero de teléfono</label>
                      <span class="form-control"><?php echo $_SESSION["u_telefono"] ?> </span>

                    </div>


                  </div>

                </div>
                <!-- /Account -->
              </div>
              <div class="card">
                <h5 class="card-header">Ultimas acciones</h5>
                <div class="card-body">
                  <div class="mb-3 col-12 mb-0">
                    <div class="alert alert-warning">
                      <h6 class="alert-heading fw-medium mb-1">Todas sus acciones son monitorizadas con fines de seguridad.</h6>
                    </div>
                  </div>






                  <table class="table" id="table">
                    <thead class="border-top">
                      <tr>
                        <th>Detalles</th>
                        <th>Acción</th>
                        <th>Fecha</th>
                      </tr>
                    </thead>
                    <tbody>


                      <?php



                      $stmt = mysqli_prepare($conexion, "SELECT * FROM `system_actividad` WHERE user='$user' ORDER BY id DESC");
                      $stmt->execute();
                      $result = $stmt->get_result();
                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          $id = $row['id'];
                          echo '<tr>
                                    <td>' . $row['detalles'] . '</td>
                                    <td>' . user_type_action($row['accion']) . '</td>
                                    <td>' . fechaCastellano($row['fecha']) . explode(' ', $row['fecha'])[1] . '</td>
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
  <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>
</body>

<script>
  function setFoto() {
    if ($('#photo').val() != '') {
      var Form = new FormData($('#filesForm')[0]);
      $('.container-loader').show()
      $.ajax({
        url: "../../back/ajax/users_foto.php",
        type: "post",
        data: Form,
        processData: false,
        contentType: false,
        success: function(data) {
          location.reload();
          $('.container-loader').hide()
        }
      });
    }
  }




  function eliminarFoto() {
    $('.container-loader').show()
    Swal.fire({
      title: "¿Esta seguro?",
      icon: "warning",
      html: `Se <strong>eliminará</strong> su foto de perfil.`,
      confirmButtonColor: "#69a5ff",
      cancelButtonText: `Cancelar`,
      showCancelButton: true,
      confirmButtonText: "Eliminar",
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {

        location.href = "../../back/ajax/user_foto_delete.php";
        $('.container-loader').hide()
      }
    });
  }






  var table = $('#table').DataTable({
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
</script>

</html>