<?php
include('../../back/config/conexion.php');
include('../../back/config/funcione_globales.php');
if ($_SESSION["u_nivel"] != 1 && $_SESSION["u_nivel"] != 2) {
  header("Location: ../index.php");
} else {
  if ($_SESSION["u_nivel"] == '2') {
    $empresa_id = $_SESSION["u_ente_id"];
    $extraCondition = " AND u_ente_id='$empresa_id'";
  } elseif ($_SESSION["u_nivel"] != '') {
    $extraCondition = " AND u_nivel!='1'";
  }
?>
  <!DOCTYPE html>
  <html lang="es" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title class="us" id="title">Listado de usuarios</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <script src="../../assets/vendor/js/helpers.js"></script>
    <script src="../../assets/js/config.js"></script>
    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>

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



              <div class="row g-4 mb-4">
                <div class="col-sm-6 col-xl-3">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                          <span>Administradores</span>
                          <div class="d-flex align-items-end mt-2">
                            <h4 class="mb-0 me-2">
                              <?php echo contar("SELECT count(*) FROM system_users WHERE u_nivel='2' $extraCondition"); ?>
                            </h4>
                          </div>
                          <p class="mb-0">Empresas/instituciones</p>
                        </div>
                        <div class="avatar">
                          <span class="avatar-initial rounded bg-label-primary">
                            <i class="bx bx-user bx-sm"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                          <span>Usuarios estandar</span>
                          <div class="d-flex align-items-end mt-2">
                            <h4 class="mb-0 me-2">
                              <?php
                              echo contar("SELECT count(*) FROM system_users WHERE u_nivel='3' $extraCondition");
                              ?>
                            </h4>
                          </div>
                          <p class="mb-0">Empleados </p>
                        </div>
                        <div class="avatar">
                          <span class="avatar-initial rounded bg-label-primary">
                            <i class="bx bx-user bx-sm"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                          <span>Supendidos</span>
                          <div class="d-flex align-items-end mt-2">
                            <h4 class="mb-0 me-2"> <?php
                                                    echo contar("SELECT count(*) FROM system_users WHERE u_status='2' $extraCondition");
                                                    ?></h4>
                          </div>
                          <p class="mb-0">Usuarios suspendidos</p>
                        </div>
                        <div class="avatar">
                          <span class="avatar-initial rounded bg-label-danger">
                            <i class="bx bx-user-x bx-sm"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                          <span>Pendientes</span>
                          <div class="d-flex align-items-end mt-2">
                            <h4 class="mb-0 me-2"> <?php
                                                    echo contar("SELECT count(*) FROM system_users WHERE u_status='0' $extraCondition");
                                                    ?></h4>
                          </div>
                          <p class="mb-0">Registro incompleto</p>
                        </div>
                        <div class="avatar">
                          <span class="avatar-initial rounded bg-label-warning">
                            <i class="bx bx-user-minus bx-sm"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Users List Table -->
              <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-end ">
                  <h5 class="card-title ">Lista de usuarios</h5>
                  <button type="button" data-bs-toggle="modal" data-bs-target="#addnew" class="dt-button add-new btn btn-primary">
                    <span><i class="bx bx-plus me-0 me-sm-1"></i>
                      <span class="d-none d-sm-inline-block">Agregar nuevo</span>
                    </span>
                  </button>
                </div>



                <div class="modal fade" id="addnew" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title"> Nuevo usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col mb-3">
                            <label for="name_user" class="form-label">Nombre y apellido</label>
                            <input type="text" id="name_user" class="form-control" placeholder="Ingresar nombre y apellido del usuario" />
                          </div>
                        </div>
                        <div class="row g-2">
                          <div class="col mb-3">
                            <label for="email_user" class="form-label">Correo</label>
                            <input type="text" id="email_user" onchange="(validarEmail(this.value) == false ? toast_s('error', 'El correo es incorrecto') : '')" class="form-control" placeholder="xxxx@xxx.xx" />
                          </div>
                          <div class="col mb-3">
                            <label for="telefono_user" class="form-label">Teléfono</label>

                            <input type="text" id="telefono_user" onInput="this.value = phoneFormat(this.value)" class="form-control">
                          </div>

                          <script>
                            function validarEmail(valor) {
                              if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(valor)) {
                                return true;
                              } else {
                                return false;
                              }
                            }
                          </script>

                        </div>

                        <div class="mb-3">
                          <label for="dobLarge" class="form-label">Rol</label>
                          <select id="rol_user" class="select2 form-select select2-hidden-accessible" data-select2-id="rol">

                            <?php
                            if ($_SESSION["u_nivel"] == '1') {
                              echo '<option value="" data-select2-id="2">Seleccione</option>
                                <option value="Empresa">Empresa/Institución</option>
                                <option value="Administrador">Administrador Epa</option>
                                <option value="Soporte">Soporte técnico</option>';
                            } elseif ($_SESSION["u_nivel"] == '4') {
                              echo '<option value="" data-select2-id="2">Seleccione</option>
                                <option value="Soporte">Soporte técnico</option>';
                            }
                            /* <option value="Cajero">Cajero</option>
                              <option value="Supervisor">Supervisor</option>*/
                            ?>
                            <option value="Empleado">Empleado</option>
                          </select>
                        </div>
                        <?php if ($_SESSION["u_nivel"] == '1') { ?>
                          <section id="registroEmpresas" style="display: none;">
                            <div class="row">
                              <div class="col mb-3">
                                <label for="en_text" class="form-label">Nombre de la empresa/institución</label>
                                <input type="text" id="en_text" class="form-control" placeholder="Ingresar nombre de la empresa o institución" />
                              </div>
                            </div>
                          </section>
                        <?php }
                        if ($_SESSION["u_nivel"] == '1' || $_SESSION["u_nivel"] == '4') { ?>
                          <section id="registroEmpresasSe" style="display: none;">
                            <div class="row">
                              <div class="col mb-3">
                                <label for="en_select" class="form-label">Empresa/Institución</label>
                                <select id="en_select" class="form-control">
                                  <option value="">Seleccione</option>
                                  <?php

                                  $stmt = mysqli_prepare($conexion, "SELECT * FROM `system_users` WHERE u_nivel = '2' AND u_ente!='$_SESSION[u_ente]'");
                                  $stmt->execute();
                                  $result = $stmt->get_result();
                                  if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                      echo '<option value="' . $row['u_id'] . '">' . $row['u_ente'] . '</option>';
                                    }
                                  }
                                  ?>
                                </select>

                              </div>
                            </div>
                          </section>
                        <?php } ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                          Cancelar
                        </button>
                        <button onclick="addNewUser()" type="button" class="btn btn-primary"> <i class="bx bx-plus"></i> Agregar nuevo</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body table-responsive">
                  <div class="dataTables_wrapper dt-bootstrap5">
                    <table class="datatables-users table dataTable " id="table">
                      <thead>
                        <tr>
                          <th class="sorting sorting_desc">Usuario</th>
                          <th class="sorting">Correo</th>
                          <th class="sorting">Rol</th>
                          <th class="sorting">Estatus</th>
                          <th class="sorting_disabled  text-center"></th>
                        </tr>
                      </thead>
                      <tbody id="tabla">
                      </tbody>
                    </table>

                  </div>
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
      let telefono_user = $('#telefono_user').val()
      let en_text = '';
      let en_select = '';
      if (sn == '1') {
        en_text = $('#en_text').val()
        en_select = $('#en_select').val()
      }

      if (validarEmail(email_user) == false) {
        toast_s('error', 'El correo es incorrecto')
        return;
      }
      $('.container-loader').show()
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
          telefono_user: telefono_user
        },
        cache: false,
        success: function(msg) {
          $('.container-loader').hide()
          if (msg.trim() == 'exists_u') {
            toast_s('warning', 'El usuario ya existe.')
          } else if (msg.trim() == 'exists_t_u') {
            toast_s('warning', 'Ya se ha creado una solicitud para este usuario.')
          } else if (msg.trim() == 'ok') {
            toast_s('success', 'Agregado correctamente.')
            tabla()
          } else if (msg.trim() == 'accion_denegada') {
            toast_s('warning', 'Acción denegada.')
            tabla()
          } else {
            console.log(msg)
          }


          $('#name_user').val('')
          $('#email_user').val('')
          $('#rol_user').val('')
          $('#telefono_user').val('')
          $('#addnew').modal('toggle')

        }
      }).fail(function(jqXHR, textStatus, errorThrown) {
        $('.container-loader').hide()

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
          $('.container-loader').show()
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
              $('.container-loader').hide()
            }
          }).fail(function(jqXHR, textStatus, errorThrown) {
            $('.container-loader').hide()

            toast_s('warning', 'Ocurrió un error, inténtelo nuevamente ' + errorThrown)
          });

        }
      });

    }



    <?php if ($_SESSION["u_nivel"] == '1' || $_SESSION["u_nivel"] == '4') { ?>

      $(document).ready(function() {
        function viewUserType() {
          if (sn == '1') {
            if ($("#rol_user").val() == 'Empresa') {
              $("#registroEmpresas").show(300);
            } else {
              $("#registroEmpresas").hide(300);
            }
          }

          if (sn == '1' || sn == '2') {
            if ($("#rol_user").val() == 'Empleado') {
              $("#registroEmpresasSe").show(300);
            } else {
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