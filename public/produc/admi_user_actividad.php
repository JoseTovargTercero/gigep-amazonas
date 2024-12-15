<?php
include('../../back/config/conexion.php');
include('../../back/config/funcione_globales.php');
if ($_SESSION["u_nivel"] != 1 && $_SESSION["u_nivel"] != 2) {
  header("Location: ../index.php");
} else {


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
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.css" />


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




              <div class="row">

                <div class="col-lg-12">
                  <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills mb-3" role="tablist">
                      <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#logueos" aria-controls="logueos" aria-selected="false">
                          Inicios de sesión
                        </button>
                      </li>
                      <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#actividad" aria-controls="actividad" aria-selected="true">
                          Actividad
                        </button>
                      </li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane fade" id="logueos" role="tabpanel">
                        <h5 class="card-header mb-3">Inicios de sesión</h5>



                        <ul class="timeline">


                          <?php
                          $empresa = $_SESSION["u_ente_id"];

                          if ($_SESSION["u_nivel"] == '2') {
                            $stmt = mysqli_prepare($conexion, "SELECT * FROM `system_logs`
                            LEFT JOIN system_users ON system_users.u_id = system_logs.user_id                        
                            WHERE empresa_id = '$empresa' ORDER BY id DESC LIMIT 50");
                          } elseif ($_SESSION["u_nivel"] == '1') {
                            $stmt = mysqli_prepare($conexion, "SELECT * FROM `system_logs`
                            LEFT JOIN system_users ON system_users.u_id = system_logs.user_id                        
                            ORDER BY id DESC LIMIT 50");
                          }
                          $stmt->execute();
                          $result = $stmt->get_result();
                          if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                              echo '<li class="timeline-item timeline-item-transparent">
                                <span class="timeline-point-wrapper"><span class="timeline-point timeline-point-primary"></span></span>
                                <div class="timeline-event">
                                  <div class="timeline-header border-bottom mb-3">
                                    <h6 class="mb-0">' . $row['u_nombre'] . '</h6>
                                    <span class="text-muted">' . fechaCastellano($row['fecha']) . '</span>
                                  </div>
                                  <div class="d-flex justify-content-between flex-wrap mb-2">
                                    <div>
                                      <span>' . $row['dispositivo'] . '</span>
                                    </div>
                                    <div>
                                      <span class="text-muted">' . explode(' ', $row['fecha'])[1] . '</span>
                                    </div>
                                  </div>
                                 
                                </div>
                              </li>';
                            }
                          }
                          $stmt->close();
                          ?>







                        </ul>




















                      </div>
                      <div class="tab-pane fade active show" id="actividad" role="tabpanel">



                        <h5 class="card-header mb-3">Actividad</h5>

                        <table class="table" id="table">
                          <thead class="border-top">
                            <tr>
                              <th>Usuario</th>
                              <?php
                              if ($_SESSION["u_nivel"] == '1') {
                                echo '<th>Empresa</th>';
                              }
                              ?>

                              <th>Detalles</th>
                              <th>Acción</th>
                              <th>Fecha</th>
                            </tr>
                          </thead>
                          <tbody>


                            <?php

                            if ($_SESSION["u_nivel"] == '2') {
                              $stmt = mysqli_prepare($conexion, "SELECT * FROM `system_actividad`
                                LEFT JOIN system_users ON system_users.u_id=system_actividad.user_empresa
                                 WHERE user_empresa='$empresa' ORDER BY id DESC");
                            } elseif ($_SESSION["u_nivel"] == '1') {
                              $stmt = mysqli_prepare($conexion, "SELECT * FROM `system_actividad`
                                LEFT JOIN system_users ON system_users.u_id=system_actividad.user_empresa
                                 ORDER BY id DESC");
                            }

                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {
                              while ($row = $result->fetch_assoc()) {
                                $id = $row['id'];
                                echo '<tr>
                                    <td>' . $row['name_user'] . '</td>';

                                if ($_SESSION["u_nivel"] == '1') {
                                  echo '<td>' . ($row['user_empresa'] == '0' ? 'Administrador EPA' : $row['u_ente']) . '</td>';
                                }
                                echo ' <td>' . $row['detalles'] . '</td>
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
      <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
      <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>

  </body>

  <script>
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

<?php
}
?>