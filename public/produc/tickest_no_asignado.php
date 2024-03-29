<?php
include('../../back/config/conexion.php');
include('../config/funcione_globales.php');
if ($_SESSION["u_nivel"] != 4) {
  header("Location: ../index.php");
} else {




?>
  <!DOCTYPE html>
  <html lang="es" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title class="noa" id="title">Tickets</title>
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
    <link rel="stylesheet" href="../../assets/css/tags.css" />
    <script src="../../js/sweetalert2.all.min.js"></script>
  </head>

  <body>
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





            <div class="container-xxl flex-grow-1 container-p-y">


              <!-- Users List Table -->
              <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-end ">
                  <h5 class="card-title ">Tickets abiertos</h5>
                </div>



                <div class="card-body table-responsive">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates itaque reiciendis quisquam perspiciatis vel laborum veniam commodi consequatur. Tenetur nisi dolorum pariatur doloremque deserunt enim repudiandae veniam cupiditate nam rerum.
                </div>
              </div>
            </div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>
      <!-- Modal  -->
      <div class="modal fade" id="modal-defecto">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modal-defecto-header"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-defecto-body">
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal empresas involucradas -->
        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
      </div>
      <!-- Modal  -->
      <!-- / Layout wrapper -->
      <?php require('../includes/alerts.html'); ?>
      <!-- build:js assets/vendor/js/core.js -->
      <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
      <script src="../../assets/vendor/libs/popper/popper.js"></script>
      <script src="../../assets/vendor/js/bootstrap.js"></script>
      <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
      <script src="../../assets/vendor/js/menu.js"></script>
      <script src="../../assets/js/main.js"></script>
      <script src="../../assets/js/ui-popover.js"></script>
      <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

  </body>

  <script>
 
    function tabla() {
      $.get("../../back/ajax/admi_user_list_tabla.php", '', function(data) {
        $('#tabla').html(data)
      });
    }

    tabla()

    var sn = "<?php echo $_SESSION["u_nivel"] ?>"



    function addNewUser() {

    let name_user = $('#name_user').val()
    let email_user = $('#email_user').val()
    let rol_user = $('#rol_user').val()
    let en_text = '';
    let en_select = '';
    if (sn == '1') {
      en_text = $('#en_text').val()
      en_select = $('#en_select').val()
    }

      $.ajax({
        type: 'POST',
        url: '../../back/ajax/admi_user_list_new_user.php',
        dataType: 'html',
        data: {
          name_user: name_user,
          email_user: email_user,
          rol_user: rol_user,
          en: en_text,
          en_s: en_select,
        },
        cache: false,
        success: function(msg) {
          if (msg.trim() == 'exists_u') {
            toast_s('warning', 'El usuario ya existe.')
          }else if (msg.trim() == 'exists_t_u') {
            toast_s('warning', 'Ya se ha creado una solicitud para este usuario.')
          }else if (msg.trim() == 'ok') {
            toast_s('success', 'Agregado correctamente.')
            tabla()
          }else if (msg.trim() == 'accion_denegada') {
            toast_s('warning', 'Acción denegada.')
            tabla()
          }else{
            console.log(msg)
          }

        }
      }).fail(function(jqXHR, textStatus, errorThrown) {
        toast_s('warning', 'Ocurrió un error, inténtelo nuevamente ' + errorThrown)
      });


    }


    function manejador(a, i) {
      let msg
      if (a == 'b') {
        msg = 'El usuario sera suspendido temporalmente.'
      } else if (a == 'b') {
        msg = 'El usuario sera eliminado, <strong>la acción no se puede deshacer</strong>.'
      } else if (a == 'ub') {
        msg = 'Se quitar el beto al usario.'
      }
      Swal.fire({
        title: "¿Esta seguro?",
        icon: "warning",
        html: msg,
        confirmButtonColor: "#69a5ff",
        cancelButtonText: `Cancelar`,
        showCancelButton: true,
        confirmButtonText: "Continuar",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: 'POST',
            url: '../../back/ajax/admi_user_list_manejador.php',
            dataType: 'html',
            data: {
              i: i,
              a: a
            },
            cache: false,
            success: function(msg) {
              if (msg.trim() == '') {
                toast_s('success', 'Actualizado correctamente')
                tabla()
              }
            }
          }).fail(function(jqXHR, textStatus, errorThrown) {
            toast_s('warning', 'Ocurrió un error, inténtelo nuevamente ' + errorThrown)
          });

        }
      });

    }



    <?php if ($_SESSION["u_nivel"] == '1' || $_SESSION["u_nivel"] == '4') { ?>

      $(document).ready(function() {
            function viewUserType() {
              if (sn == '1') {
                if($("#rol_user").val() == 'Empresa'){
                  $("#registroEmpresas").show(300);
                }else{
                  $("#registroEmpresas").hide(300);
                }
              }
              
              if (sn == '1' || sn == '2') {
                if ($("#rol_user").val() == 'Empleado') {
                  $("#registroEmpresasSe").show(300);
                }else{
                  $("#registroEmpresasSe").hide(300);
                }
              }
            }
            $("#rol_user").change(viewUserType);
        });

    <?php }  ?>

  </script>

  </html>

<?php
}
?>