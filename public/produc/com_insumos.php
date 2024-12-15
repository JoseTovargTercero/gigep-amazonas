<?php
include('../../back/config/conexion.php');
include('../../back/config/funcione_globales.php');
if ($_SESSION["u_nivel"] != '1' && $_SESSION["u_nivel"] != '2' && $_SESSION["u_nivel"] != '3') {
  header("Location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="es" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title class="com" id="title">Productos</title>
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
          <div class="container-xxl flex-grow-1 container-p-y ">
            <div class=" d-flex justify-content-between">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Compras /</span> Productos</h4>
            </div>
            <div class="row ">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-header d-flex justify-content-between">
                    <h5>Productos</h5>
                    <button class="btn btn-secondary add-new btn-primary ms-2" type="button" data-bs-toggle="modal" data-bs-target="#modalCenter"><span><i class="bx bx-plus me-0 me-sm-1"></i>Agregar Producto</span></button>

                  </div>
                  <div class="card-body">
                    <div class="card-datatable table-responsive">
                      <div class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <table class=" table border-top dataTable no-footer d" id="DataTables">
                          <thead>
                            <tr>
                              <th>Insumo/Categoría</th>
                              <th>Creador</th>
                              <th class="text-center"></th>
                            </tr>
                          </thead>
                          <tbody id="tbodyTable">
                          </tbody>
                        </table>
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

        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Nueva insumo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form id="form">
                <div class="modal-body">




                  <div class="mb-3">
                    <label for="nombreCategoria" class="form-label">Categoría</label>
                    <select name="categoria" id="categoria" class="form-control">
                      <option value="">Seleccione</option>

                      <?php

                      $stmt = mysqli_prepare($conexion, "SELECT * FROM `com_categorias` ORDER BY nombre");
                      $stmt->execute();
                      $result = $stmt->get_result();
                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          echo ' <option value="' . $row['id'] . '">' . $row['nombre'] . '</option>';
                        }
                      }
                      $stmt->close();
                      ?>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label for="nombreCategoria" class="form-label">Nombre del insumo</label>
                    <input type="text" id="insumos" name="insumos" class="form-control" placeholder="Ingrese el nombre" />
                  </div>







                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Cancelar
                  </button>
                  <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
              </form>
            </div>
          </div>
        </div>


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
</body>

<script>
  function borrarInsumo(id) {



    Swal.fire({
      title: "<strong>¿Está seguro?</strong>",
      icon: "warning",
      html: `Se <b>eliminará</b> el insumo. La acción es irreversible.`,
      showCancelButton: true,
      confirmButtonColor: "#69a5ff",
      confirmButtonText: `Eliminar`,
      cancelButtonText: `Cancelar`,
    }).then((result) => {
      if (result.isConfirmed) {
        $('.container-loader').show()
        $.get("../../back/ajax/com_borrar_insumo.php", "i=" + id, function(data) {
          tabla()
          $('.container-loader').hide()
          toast_s('success', 'Se eliminó correctamente')
        });
      }
    });






  }

  function tabla() {
    $.get("../../back/ajax/com_insumos.php", "", function(data) {
      $('#tbodyTable').html(data)
    });
  }
  tabla()


  $(document).ready(function(e) {
    $("#form").on('submit', function(e) {
      e.preventDefault();
      let formData = new FormData(this);

      if ($('#categoria').val() == '' || $('#insumos').val() == '') {
        toast_s('warning', 'Rellene todos los campos')
        return
      }

      $('button').attr('disabled', true);
      $('.container-loader').show();

      $.ajax({
        type: 'POST',
        url: '../../back/ajax/com_nueva_insumos.php',
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function(msg) {
          $('button').attr('disabled', false);
          $('.from-control').val('');
          $('.container-loader').hide();

          tabla();
          toast_s('success', 'Se agrego correctamente')
          $('#modalCenter').modal('toggle');
        }
      }).fail(function(jqXHR, textStatus, errorThrown) {
        $('.container-loader').hide();
        $('button').attr('disabled', false);

        if (jqXHR.status === 0) {
          alert('En este momento no tienes conexión a internet, inténtalo nuevamente.', '../assets/img/illustrations/mantenimiento.png')

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

</html>