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
  <title class="cos" id="title">Facturación</title>
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
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <?php require('../includes/menu.php'); ?>
      <div class="layout-page">
        <?php require('../includes/nav.php'); ?>
        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
              <div class="col-lg-12 mb-3">
                <div class="mb-3 card">
                  <div class=" card-body">
                    <table id="tabla_pagos_pendiente" class="table table-hover table-striped align-middle mb-0">
                      <thead class="table-light">
                        <tr>
                          <th>Cliente</th>
                          <th>Fecha</th>
                          <th>Observacion</th>
                          <th>Estatus</th>
                          <th>Monto</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



  <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <!-- Encabezado -->
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Revisar pago</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <!-- Cuerpo -->
        <div class="modal-body">
          <form id="formRevisarPago">

            <!-- Comercio (solo lectura) -->
            <div class="form-group mb-3">
              <label for="comercio">Comercio</label>
              <input type="text" class="form-control" id="comercio" name="comercio" disabled>
            </div>

            <!-- Estado -->
            <div class="form-group mb-3">
              <label for="estado">Estado</label>
              <select class="form-control" id="estado" name="estado">
                <option value="">Seleccionar</option>
                <option value="Rechazado">Rechazado</option>
                <option value="Confirmado">Confirmado</option>
              </select>
            </div>
            <div class="alert alert-danger hide mb-3" id="alerta-rechazado" role="alert">
              <strong>Atención:</strong> Al seleccionar "Rechazado" el pago no se aplicará.
            </div>
            <!-- Observación -->
            <div class="form-group mb-3">
              <label for="observacion">Observación</label>
              <textarea class="form-control" id="observacion" name="observacion" rows="3"></textarea>
            </div>

          </form>
        </div>

        <!-- Footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary" id="guardarRevision">Guardar</button>
        </div>

      </div>
    </div>
  </div>

  <?php require('../includes/alerts.html'); ?>

  <script src="../../assets/vendor/libs/popper/popper.js"></script>
  <script src="../../assets/vendor/js/bootstrap.js"></script>
  <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../../assets/vendor/js/menu.js"></script>
  <script src="../../assets/js/main.js"></script>
  <script src="../../assets/js/ui-popover.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>


  <script>
    let comercio_modificar;
    let tablaPagos;

    $(document).ready(function() {
      tablaPagos = $('#tabla_pagos_pendiente').DataTable({
        paging: true,
        searching: true,
        ordering: false,
        info: false,
        lengthChange: false,
        pageLength: 5,
        dom: '<"datatable-header d-flex justify-content-between align-items-center"<"datatable-title"l><"datatable-search"f>>t<"datatable-footer"p>',
        language: {
          search: "Buscar:",
          paginate: {
            previous: '<ion-icon name="chevron-back-outline"></ion-icon>',
            next: '<ion-icon name="chevron-forward-outline"></ion-icon>'
          }
        },
        initComplete: function() {
          // Insertar título arriba a la izquierda
          $(".datatable-title").html('<h4 class="mb-2 mt-2">Pagos Pendientes por confirmar</h4>');
        }
      });
    });

    const statusColors = {
      'Pendiente': 'badge-subtle-warning',
      'Confirmado': 'badge-subtle-success',
      'Rechazado': 'badge-subtle-danger'
    };


    function actualizarTabla() {
      fetch('../../back/ajax/cos_consulta_pagos.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          }
        })
        .then(res => res.json())
        .then(data => {

          tablaPagos.clear();

          // recorrer el json y agregar filas
          data.forEach(item => {
            const cliente = `
            <td class="py-2"><strong style="white-space: nowrap;">${item.SUJETO}</strong> <br>${item.PROPETARIO}</td>
            `;
            console.log(item)
            tablaPagos.row.add([
              cliente,
              item.fecha_pago,
              item.observaciones,
              `<div class="badge ${statusColors[item.estatus]} rounded-pill"><p class="mb-0">${item.estatus}</p></div>`,
              `$${item.monto_usd}`

            ]);
          });
          // refrescar
          tablaPagos.draw();
        })
        .catch(err => {
          console.error("Error:", err);
          alert("Ocurrió un error al consultar la deuda");
        });
    }

    actualizarTabla();


    // cuando el estado cambie a Rechazado, muestra el div alerta-rechazado
    $('#estado').on('change', function() {
      if (this.value === 'Rechazado') {
        $('#alerta-rechazado').removeClass('hide');
      } else {
        $('#alerta-rechazado').addClass('hide');
      }
    });



    // agrega un listerner al boton procesar y obten el data-id y data-comercio
    $('#tabla_pagos_pendiente tbody').on('click', '.btn-procesar', function() {
      const id = $(this).data('id');
      comercio_modificar = id
      const comercio = $(this).data('comercio');

      // llena el input comercio del modal
      $('#comercio').val(comercio);
      // muestra el modal
      $('#exampleModalCenter').modal('show');
      console.log(id)
      console.log(comercio)
      // redirige a la pagina de procesar pago con el id y comercio en la url
      //window.location.href = `cos_procesar_pago.php?id=${id}&comercio=${comercio}`;
    });

    // cuando se envie el formulario formRevisarPago
    $('#guardarRevision').on('click', function(e) {
      e.preventDefault();

      const estado = $('#estado').val();
      const observacion = $('#observacion').val();

      if (estado === '') {
        alert("Por favor selecciona un estado");
        return;
      }

      // enviar los datos al servidor
      fetch('../../back/ajax/cos_revisar_pago.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            id: comercio_modificar,
            estado: estado,
            observacion: observacion
          })
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: 'Éxito',
              text: data.message
            });
            // cerrar el modal
            $('#exampleModalCenter').modal('hide');
            // limpiar el formulario
            $('#formRevisarPago')[0].reset();
            // actualizar la tabla
            actualizarTabla();
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: data.message
            });
          }
        })
        .catch(err => {
          console.error("Error:", err);
          alert("Ocurrió un error al procesar la revisión");
        });
    });
  </script>
</body>



</html>