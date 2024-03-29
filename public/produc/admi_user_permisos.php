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
    <title class="us" id="title">Permisos de usuarios</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />
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
              <!-- Users List Table -->

              <div class=" d-flex justify-content-between">

                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Administrativo /</span> Permisos</h4>


              </div>


              <div class="card h-100">


                <div class="card-header d-flex justify-content-between align-items-end ">
                  <h5 class="card-title ">Usuarios</h5>

                  <div class="d-flex">
                    <label for="resaltar" class="form-label me-2" style="    padding-top: 10px;">Buscar</label>
                    <input id="resaltar" onkeyup="search(this.value)" type="text" class="form-control" placeholder="Buscar..." />
                  </div>


                </div>


                <div class="card-body table-responsive">
                  <div class="dataTables_wrapper dt-bootstrap5">
                    <table class="datatables-users table dataTable " id="table">
                      <thead>
                        <tr>
                          <th>Usuario</th>
                          <th>Permisos</th>
                          <th>Creado</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody id="tabla"></tbody>
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
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="text-center mb-4">
                <h3>Agregar Permisos</h3>
              </div>
              <div class="alert alert-warning" role="alert">
                <h6 class="alert-heading mb-2">Atención</h6>
                <p class="mb-0">Se le dará permisos extras al usuario <b id="userserlect"></b> y podrá agregar, modificar y eliminar la información del modulo seleccionado.</p>
              </div>
              <div class="row">

              <div class="col-sm-8 fv-plugins-icon-container">
                <label class="form-label" for="modulos">Módulos</label>
                <select id="modulos" class="form-control">
                  <option style="color: lightgray;" value="">Seleccione</option>
                  

                  <?php 

                    $stmt = mysqli_prepare($conexion, "SELECT * FROM `system_modulos`");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        echo '<option value="'.$row['modulo'].'">'.$row['nombre'].'</option>';
                      }
                    }
                    $stmt->close();


                  ?>



                  <?php
                  if ($_SESSION["sa"] == '1') {
                    //echo '<option value="admi">Usuarios</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-sm-4 mb-3">
                <label class="form-label invisible d-none d-sm-inline-block">Botón</label>
                <button type="submit" class="btn btn-primary mt-1 mt-sm-0 text-nowrap" onclick="addPermisos()">Dar permisos</button>
              </div>
              </div>


            </div>
          
             
              </div>
              </div>
              </div>
              <!-- Modal empresas involucradas -->
              <!-- Overlay -->
          
            </div>
            </div>
            </div>

            <div class="modal fade" id="modal-quitarPermisos">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5>Quitar permisos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body pt-2">
                    <p>Permisos actuales del usuario <b id="user_n_eliminar"></b></p>
                    <div class="mb-3" id="list_permisos">
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


  </body>

  <script>
    function tabla() {
      $.get("../../back/ajax/admi_user_list_tabla_permisos.php", '', function(data) {
        $('#tabla').html(data)
      });
    }
    tabla()

    let usr = ''

    function modalAddPermisos(id, usr_n) {
      usr = id
      $('#userserlect').html(usr_n)
      $('#modal-defecto').modal('show')
    }


    var modulos_disponibles = {}


    <?php


    $stmt = mysqli_prepare($conexion, "SELECT * FROM `system_modulos`");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {

        $modulo = $row['modulo'];
        $nombre = $row['nombre'];

        echo "modulos_disponibles['$modulo'] = '$nombre';".PHP_EOL;
      
      }
    }
    $stmt->close();


    
    
    
    if ($_SESSION["sa"] == '1') { ?>
     // modulos_disponibles['admi'] = 'Usuarios'
    <?php } ?>

    function addPermisos() {
      let modulo = $('#modulos').val();


      Swal.fire({
        title: "¿Esta seguro?",
        icon: "warning",
        html: `Se le dará acceso al modulo <b>` + modulos_disponibles[modulo] + `</b>, pudiendo agregar, modificar y eliminar información relacionada al modulo.`,
        confirmButtonColor: "#69a5ff",
        cancelButtonText: `Cancelar`,
        showCancelButton: true,
        confirmButtonText: "Continuar",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: 'POST',
            url: '../../back/ajax/admi_user_permisos.php',
            dataType: 'html',
            data: {
              modulo: modulo,
              usr: usr,
              a: 'a'
            },
            cache: false,
            success: function(msg) {
              if (msg.trim() == 'np') {
                toast_s('error', 'Usted no tiene permisos para asignar este permiso')
                location.href="../../login/logout.php";
              } else if (msg.trim() == 'ye') {
                toast_s('error', 'El usuario ya cuenta con el permiso seleccionado')
              } else if (msg.trim() == 'ok') {
                toast_s('success', 'Actualizado correctamente')
                tabla()
                $('#modal-defecto').modal('hide')
              }

            }
          }).fail(function(jqXHR, textStatus, errorThrown) {
            toast_s('warning', 'Ocurrió un error, inténtelo nuevamente ' + errorThrown)
          });

        }
      });



    }

    function modalRemovePermisos(id, usr_n) {
      $.get("../../back/ajax/admi_user_permisos.php", 'a=cp&u=' + id, function(data) {
        $('#list_permisos').html(data)
        $('#user_n_eliminar').html(usr_n)
        $('#modal-quitarPermisos').modal('show')
      });
    }
    

    function eliminarPermiso(id) {
      $.get("../../back/ajax/admi_user_permisos.php", 'a=qp&i=' + id, function(data) {
        if (data.trim() == 'np') {
          toast_s('error', 'Usted no tiene permisos para modificar este permiso')
          location.href="../../login/logout.php";
        }else if(data.trim() == 'ok'){
          tabla()
          toast_s('success', 'Actualizado correcta')
          $('#modal-quitarPermisos').modal('hide')
        }
      });
    }










    /* BUSCADOR */
    function search(value) {
      let valoraresaltar = value.toLowerCase().trim();
      let tabla_tr = document.getElementsByTagName("tbody")[2].rows;

      if (valoraresaltar != "") {

        for (let i = 0; i < tabla_tr.length; i++) {

          let tr = tabla_tr[i];
          let textotr = tr.innerText.toLowerCase();
          tr.className = (textotr.indexOf(valoraresaltar) != -1) ? "resaltado" : "noresaltado";
          // operador ternario
        }
      } else {
        for (let i = 0; i < tabla_tr.length; i++) {
          let tr = tabla_tr[i];
          tr.classList.remove("resaltado");
        }
      }
    }
  </script>

  </html>

<?php
}
?>