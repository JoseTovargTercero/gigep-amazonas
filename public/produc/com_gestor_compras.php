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
  <title class="com" id="title">Compras</title>
  <meta name="description" content="" />
  <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="../../assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../../assets/css/demo.css" />
  <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <script src="../../assets/vendor/js/helpers.js"></script>
  <link rel="stylesheet" href="../../assets/css/bs-stepper.css" />
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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Compras /</span> Compras</h4>
            </div>
            <div class="row " id="section_top"></div>
            <div class="row gy-4 mb-3">
              <div class="col-lg-8">
                <div class="card mb-3" id="vistaNuevoGrupo" style="display: none;">
                  <div class="card-body">
                    <div class="d-flex  justify-content-between">

                      <h5 class="card-title">
                        Nuevo grupo <small class="text-muted">de insumos</small>
                      </h5>
                      <button class="btn btn btn-label-secondary btn-sm" onclick="nuevoGrupoDisplay()"> <i class="bx bx-x"></i> Cancelar</button>

                    </div>

                    <div class="bs-stepper-header">
                      <div class="step" onclick="setView('view-1')" data-target="#social-links">
                        <button type="button" class="step-trigger" aria-selected="false">
                          <span class="bs-stepper-circle view-1 active_2" id="view-1_1">
                            <i class='bx bx-package'></i>
                          </span>
                          <div class="bs-stepper-label text-start">
                            <h5 class="mb-0">Grupo</h5>
                            <span class="bs-stepper-subtitle text-muted">Detalles del grupo</span>
                          </div>
                        </button>
                      </div>


                      <div class="line">
                        <i class="bx bx-chevron-right fs-2 text-muted"></i>
                      </div>
                      <div class="step" onclick="setView('view-2')" data-target="#social-links">
                        <button type="button" class="step-trigger" aria-selected="false">
                          <span class="bs-stepper-circle view-2" id="view-2_1">
                            <i class='bx bx-purchase-tag-alt'></i>
                          </span>
                          <div class="bs-stepper-label text-start">
                            <h5 class="mb-0">Insumos</h5>
                            <span class="bs-stepper-subtitle text-muted">Insumos del grupo</span>
                          </div>
                        </button>
                      </div>
                    </div>

                    <div class="bs-stepper wizard-vertical vertical wizard-vertical-icons-example mt-2">
                      <div class="bs-stepper-content">
                        <form onsubmit="return false">
                          <!-- Account Details -->
                          <div id="view-1" class="view-1 content active">
                            <div class="content-header mb-3">
                              <h6 class="mb-0">Grupo</h6>
                              <small>Detalles del grupo de insumos.</small>
                            </div>
                            <div class="row">
                              <div class="col-sm-12">
                                <div class="mb-3">
                                  <label for="nombre_grupo" class="form-label">Nombre del grupo</label>
                                  <div class="input-group input-group-merge">
                                    <input onkeyup="max_caracteres(this.value, 'res_car_nombre', 'nombre_grupo', 40)" type="text" class="form-control" placeholder="Nombre del grupo" id="nombre_grupo">
                                    <span class="input-group-text" id="res_car_nombre">40</span>
                                  </div>
                                </div>
                                <div class="mb-3">
                                  <label for="descripcion_grupo" class="form-label">Descripción del grupo</label>
                                  <div class="input-group input-group-merge speech-to-text">
                                    <textarea onkeyup="max_caracteres(this.value, 'res_car_descripcion', 'descripcion_grupo', 240)" class="form-control" placeholder="Descripción del grupo" rows="5" id="descripcion_grupo"></textarea>
                                    <span class="input-group-text" id="res_car_descripcion">
                                      240
                                    </span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev" disabled>
                                  <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                  <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                </button>
                                <button class="btn btn-primary btn-next" onclick="setView('view-2')">
                                  <span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
                                  <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                </button>
                              </div>
                            </div>
                          </div>
                          <!-- Personal Info -->
                          <div id="view-2" class="view-2 content">
                            <div class="content-header mb-3">
                              <h6 class="mb-0">Insumos</h6>
                              <small>Insumos del grupo.</small>
                            </div>
                            <div class="row g-3">



                              <div class="col-lg-6 ">
                                <div class="mb-3">
                                  <label for="categoria" class="form-label">Categoría</label>
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
                                  <label for="insumo" class="form-label">Insumo</label>
                                  <select name="insumo" id="insumo" class="form-control">
                                    <option value="">Seleccione</option>
                                  </select>
                                </div>

                                <div class="mb-3">
                                  <label for="cantidad" class="form-label">Cantidad</label>
                                  <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" max="2099" step="1">
                                </div>

                                <div class="mb-3 text-end">
                                  <button class="btn btn-info" onclick="addProducGroup()"> <i class="bx bx-plus"></i> Agregar</button>

                                </div>

                              </div>



                              <div class="col-lg-6">
                                <small class="text-light fw-medium">Lista de insumos</small>
                                <div class="demo-inline-spacing mt-3">
                                  <div class="list-group" id="listInsumos">
                                  </div>
                                </div>
                              </div>

                              <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-primary btn-prev" onclick="setView('view-1')">
                                  <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                  <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                </button>
                                <button class="btn btn-success btn-next" onclick="guardarGrupo()">
                                  <span class="align-middle d-sm-inline-block d-none me-sm-1">Finalizar</span>
                                  <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                </button>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="card mb-3">
                  <div class="card-header d-flex justify-content-between">
                    <h5>Próximas compras</h5>
                  </div>
                  <div class="card-body">
                    <div class="card-datatable table-responsive">
                      <div class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <table class=" table border-top dataTable no-footer d" id="DataTables">
                          <thead>
                            <tr>
                              <th>Compra</th>
                              <th>Fecha</th>
                              <th>Estatus</th>
                              <th class="text-center"></th>
                            </tr>
                          </thead>
                          <tbody id="tbodyTableProximasCompras">
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="card mb-3">
                  <div class="card-header d-flex justify-content-between">
                    <h5>Compras realizadas</h5>
                  </div>
                  <div class="card-body">
                    <div class="card-datatable table-responsive">
                      <div class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <table class=" table border-top dataTable no-footer d" id="DataTables">
                          <thead>
                            <tr>
                              <th>Compra</th>
                              <th>Fecha</th>
                              <th>Detalles</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $ente = $_SESSION["u_ente_id"];
                            $stmt = mysqli_prepare($conexion, "SELECT * FROM `com_compras` WHERE status='2' ORDER BY fecha ASC");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {
                              while ($row = $result->fetch_assoc()) {
                                $idC = $row['id'];
                                $user = $row['user'];
                                $productos = contar("SELECT count(*) FROM `com_compras_estructura` WHERE `compra_id`='$idC' AND user_id='$ente'");

                                echo '   <tr class="odd">

                                    <td>
                                    <div class="d-flex justify-content-start align-items-center user-name">
                                    <div class="avatar-wrapper">
                                    <div class="avatar me-2">' . ($productos == '0' ? '<span class="avatar-initial rounded-circle bg-label-danger"><i class="bx bx-x"></i></span>' : '<span class="avatar-initial rounded-circle bg-label-primary"><i class="bx bx-check"></i></span>') . '
                                    </div></div><div class="d-flex flex-column"><span class="emp_name text-truncate">' . $row['nombre'] . '</span><small class="emp_post text-truncate text-muted">' . ($productos == '0' ? '<span class="text-muted">Sin insumos </span>' : '<span class="text-muted">' . $productos . ' insumos pedidos</span>') . '</small></div></div></td>



                                    <td class="text-nowrap">' . fechaCastellano($row['fecha']) . '
                                    <br>';


                                if ($row['id_compra_periodica'] !=  '0') {
                                  echo '<small class="text-primary">' . ($row['tipo'] == '2' ? 'Compra quincenal' : 'Compra Mensual') . '</small>';
                                } else {
                                  echo '<small class="text-muted">Compra única</small>';
                                }

                                echo '
                                    </td>
                                      <td><button class="btn btn-outline-primary btn-sm" onclick="detallesCompra(\'' . $idC . '\')">Ver detalles</button></td>
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
              <div class="col-lg-4">
                <div class="card mb-3">
                  <div class="card-header d-flex justify-content-between">
                    <h5>Grupo de insumos</h5>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item pointer" onclick="nuevoGrupoDisplay()"><i class="bx bx bx-package me-1"></i> Nuevo grupo</a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="accordion " id="accordionExample">
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
                <h5 class="modal-title">Agregar Insumo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <input type="text" id="group_hide" hidden />
                <div class="mb-3">
                  <label for="categoria_add_product" class="form-label">Categoría</label>
                  <select name="categoria_add_product" id="categoria_add_product" class="form-control">
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
                  <label for="insumo_add_product" class="form-label">Insumo</label>
                  <select name="insumo_add_product" id="insumo_add_product" class="form-control">
                    <option value="">Seleccione</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="cantidad_add_product" class="form-label">Cantidad</label>
                  <input type="number" name="cantidad_add_product" id="cantidad_add_product" class="form-control" min="1" max="2099" step="1">
                </div>




              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                  Cancelar
                </button>
                <button type="button" class="btn btn-primary" onclick="addProductoAlGrupo()">Guardar</button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="modal-add_pro_comp_p" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Configurar compra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-lg-5">
                    <div class="accordion " id="accordionExample2">
                    </div>
                  </div>
                  <div class="col-lg-7 border-left">
                    <div class="text-muted mb-3">Insumos agregados</div>
                    <ul class="p-0 m-0" id="lista_Compra" style="max-height: 455px !important;overflow-y: auto;"></ul>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="modal-detallesCompra" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Detalles de la compra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body" id="contenidoPrint">

                <table class="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Insumo</th>
                      <th>Cantidad</th>
                      <th class="text-center"></th>
                    </tr>
                  </thead>
                  <tbody id="lista_insumos_pedidos"></tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="print_pdf()"><i class="bx bx-download me-1"></i>Descargar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- / Layout page -->
    </div>
    <!-- Overlay -->


    <div id="template_inv" class="mb-3" style="display: none;">
      <div class="text-center">
        <img src="../../assets/img/logo.png" class="mb-2" style="width: 30px;">
        <p>
          <strong id="titulo">Lista de insumos</strong>
          <br> Fecha: <strong><?php echo fechaCastellano(date('Y-m-d')) ?></strong>
          <br> Empresa: <strong><?php echo $_SESSION["u_ente"] ?></strong>
          <br> Usuario: <strong><?php echo $_SESSION["u_nombre"] ?></strong>
        </p>
      </div>
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
  function print_pdf() {

    var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write('<html><head><title>' + document.title + '</title>');
    mywindow.document.write('<link rel="stylesheet" href="../../assets/vendor/css/core.css" class="template-customizer-core-css" /><link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" /></head><body >');

    mywindow.document.write(document.getElementById('template_inv').innerHTML);
    mywindow.document.write(document.getElementById('contenidoPrint').innerHTML);


    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
  }



  function detallesCompra(id) {
    $(".container-loader").show();
    $.get("../../back/ajax/com_detalles_compra_finalizada.php", "i=" + id, function(data) {
      $('#lista_insumos_pedidos').html(data)
      $('#modal-detallesCompra').modal('show')
      $(".container-loader").hide();
    });
  }


  function nuevoGrupoDisplay() {
    $('#vistaNuevoGrupo').toggle(300);
  }

  var array_insumos = [];

  function guardarGrupo() {

    let nombre_grupo = $('#nombre_grupo').val();
    let descripcion_grupo = $('#descripcion_grupo').val();
    var insumos = ''


    if (array_insumos.length < 1) {
      toast_s('warning', 'Agregue los insumos al grupo')
      return
    }



    let claves_insumos = Object.keys(array_insumos)
    for (let index = 0; index < claves_insumos.length; index++) {
      let element = array_insumos[claves_insumos[index]];
      insumos += element[0] + '~' + element[1] + '~' + element[2] + ';';
    }


    $('.container-loader').show()
    $.ajax({
      type: 'POST',
      url: '../../back/ajax/com_nuevo_grupo.php',
      dataType: 'html',
      data: {
        nombre_grupo: nombre_grupo,
        descripcion_grupo: descripcion_grupo,
        insumos: insumos
      },
      cache: false,
      success: function(msg) {
        $('.container-loader').hide()
        if (msg.trim() == 'ok') {

          grupoInsumos()
          $('#vistaNuevoGrupo').hide();
          array_insumos = [];
          $('#listInsumos').html('')
          $('.form-control').html('')
          toast_s('success', 'Se agrego correctamente')


        } else {
          toast_s('warning', 'Error: algo salio mal' + msg)
        }
      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      $(".container-loader").hide();

      toast_s('warning', 'Ocurrió un error, inténtelo nuevamente ' + errorThrown)
    });

  }

  function addProducGroup() {
    let categoria = $('#categoria').val();
    let insumo = $('#insumo').val();
    let cantidad = $('#cantidad').val();
    if (categoria == '' || insumo == '' || cantidad == '' || nombre_grupo == '' || descripcion_grupo == '') {
      toast_s('error', 'Campos vacios');
      return
    }
    if (cantidad < 1) {
      toast_s('error', 'Indique una cantidad valida');
      return
    }


    let insumo_v = insumo.split('~')
    array_insumos[insumo_v[0]] = [insumo_v[0], insumo_v[1], cantidad]
    toast_s('success', 'Agregado correctamente')
    enlistarInsumos()


    $('#cantidad').val('');

    $("#categoria" + " option[value='']").attr("selected", true);
    $("#insumo" + " option[value='']").attr("selected", true);


  }

  function quitarInsumo(id) {
    delete array_insumos[id];
    toast_s('success', 'Eliminado correctamente')
    enlistarInsumos()
  }

  function enlistarInsumos() {
    $('#listInsumos').html('')

    let claves = Object.keys(array_insumos);
    for (let i = 0; i < claves.length; i++) {
      let clave = claves[i];
      $('#listInsumos').append(`<div class="list-group-item list-group-item-action d-flex justify-content-between">
          <div class="li-wrapper d-flex justify-content-start align-items-center">
          <span class="badge badge-center bg-label-secondary me-2">` + array_insumos[clave][2] + `</span>  
            <div class="list-content">
              <h6 class="mb-1">` + array_insumos[clave][1] + `</h6>
            </div>
          </div>
          <i class="bx bx-trash pointer" onclick="quitarInsumo('` + array_insumos[clave][0] + `')"></i>
        </div>`)
    }
  }



  var cm;

  function loadGrupoCompraPeriodica(id_lista) {
    $('.container-loader').show()
    $.get("../../back/ajax/com_gestor_compraPeriodica.php", "v=1&i=" + id_lista, function(data) {
      $('#lista_Compra').html(data)
      tablaProximasCompras()
      $('.container-loader').hide()
    });
  } // CARGAR LISTA DE INSUMOS DE LA COMPRA PERIODICA



  async function modificarCantidad(id_insumo) {

    $('#modal-add_pro_comp_p').modal('hide');

    const {
      value: ipAddress
    } = await Swal.fire({
      title: "Indique la cantidad necesaria",
      input: "number",
      inputLabel: "Cantidad",
      showCancelButton: true,
      confirmButtonColor: "#69a5ff",
      cancelButtonText: `Cancelar`,
      inputValidator: (value) => {
        if (!value) {
          return "¡Es necesario indicar una cantidad!";
        }
      }
    });
    if (ipAddress) {
      $('.container-loader').show()
      $.get("../../back/ajax/com_gestor_compraPeriodica.php", "v=5&i=" + id_insumo + '&c=' + ipAddress, function(data) {
        $('.container-loader').hide()
        if (data.trim() == 'ok') {
          toast_s('success', 'Modificado correctamente')
          loadGrupoCompraPeriodica(cm)
        } else {
          alert(data)
        }
        $('#modal-add_pro_comp_p').modal('toggle')
      });
    }
    if (!ipAddress) {
      $('#add_pro_comp_p').modal('toggle')
    }




  }



  async function sacarProductoCompra(id) {
    $('#modal-add_pro_comp_p').modal('toggle')

    Swal.fire({
      title: "<strong>¿Está seguro?</strong>",
      icon: "warning",
      html: `El insumo será <b>eliminado</b>.`,
      showCancelButton: true,
      confirmButtonColor: "#69a5ff",
      confirmButtonText: `Eliminar`,
      cancelButtonText: `Cancelar`,
    }).then((result) => {
      if (result.isConfirmed) {
        $('.container-loader').show()
        $.get("../../back/ajax/com_gestor_compraPeriodica.php", "v=4&i=" + id, function(data) {
          $('.container-loader').hide()
          if (data.trim() == 'ok') {
            toast_s('success', 'Eliminado correctamente')
            loadGrupoCompraPeriodica(cm)
          } else {
            alert(data)
          }
          $('#modal-add_pro_comp_p').modal('toggle')

        });
      } else {
        $('#modal-add_pro_comp_p').modal('toggle')
      }
    });




  }




















  function addInsumoCompraPeriodica(id_insumo) {
    $('.container-loader').show()
    $.get("../../back/ajax/com_gestor_compraPeriodica.php", "v=2&i=" + id_insumo + '&c=' + cm, function(data) {
      $('.container-loader').hide()
      if (data.trim() == '0') {
        toast_s('success', 'Se agregó correctamente')
      } else if (data.trim() == '1') {
        toast_s('error', 'El insumo ya se encuentra agregado')
      } else {
        toast_s('info', data.trim() + ' insumos no fueron agregados (repetidos)')
      }

      loadGrupoCompraPeriodica(cm)
    });
  }

  function addGrupoCompraPeriodica(id_grupo) {

    $.get("../../back/ajax/com_gestor_compraPeriodica.php", "v=3&i=" + id_grupo + '&c=' + cm, function(data) {
      if (data.trim() == '0') {
        toast_s('success', 'Se agregó correctamente')
      } else if (data.trim() == '1') {
        toast_s('error', 'Un insumo ya se encuentra agregado')
      } else {
        toast_s('error', data.trim() + ' insumos no fueron agregados (repetidos)')
      }


      loadGrupoCompraPeriodica(cm)
    });

  }

  function showModalCompraPeriodica(id_compra) {
    cm = id_compra;
    loadGrupoCompraPeriodica(cm)
    $('#modal-add_pro_comp_p').modal('show');

  } // MOSTRAR EL MODAL


  function grupoInsumos() {
    $('.container-loader').show()
    $.get("../../back/ajax/com_grupos_insumos.php?v=1", "", function(data) {
      $('#accordionExample').html(data)
    });

    $.get("../../back/ajax/com_grupos_insumos.php?v=2", "", function(data) {
      $('.container-loader').hide()
      $('#accordionExample2').html(data)
    });
  }

  grupoInsumos()



  function agregarInsumoAlGrupo(id) {
    $('#group_hide').val(id)
    $('#modalCenter').modal('toggle')
  }



  function eliminarInsumo(id) {
    Swal.fire({
      title: "<strong>¿Está seguro?</strong>",
      icon: "warning",
      html: `El insumo será <b>eliminado</b> del grupo. La acción es irreversible.`,
      showCancelButton: true,
      confirmButtonColor: "#69a5ff",
      confirmButtonText: `Eliminar`,
      cancelButtonText: `Cancelar`,
    }).then((result) => {
      if (result.isConfirmed) {
        $('.container-loader').show()
        $.get("../../back/ajax/com_borrar_insumo_group.php", "i=" + id, function(data) {
          $('.container-loader').hide()
          if (data.trim() == 'ok') {
            grupoInsumos()
            toast_s('success', 'Se eliminó correctamente')
          } else {
            toast_s('error', 'Ocurrio un error ' + data)
          }
        });
      }
    });
  }

  function addProductoAlGrupo() {
    let categoria_add_product = $('#categoria_add_product').val()
    let insumo_add_product = $('#insumo_add_product').val()
    let cantidad_add_product = $('#cantidad_add_product').val()
    let group_hide = $('#group_hide').val()

    if (categoria_add_product == '' || insumo_add_product == '' || cantidad_add_product == '') {
      toast_s('warning', 'Rellene todos los campos')
      return
    }
    $(".container-loader").show();


    $.ajax({
      type: 'POST',
      url: '../../back/ajax/com_add_insumo_group.php',
      dataType: 'html',
      data: {
        categoria_add_product: categoria_add_product,
        insumo_add_product: insumo_add_product,
        cantidad_add_product: cantidad_add_product,
        group_hide: group_hide
      },
      cache: false,
      success: function(msg) {
        $(".container-loader").hide();

        if (msg.trim() == 'ok') {

          $("#categoria_add_product" + " option[value='']").attr("selected", true);
          $("#insumo_add_product" + " option[value='']").attr("selected", true);
          $('#cantidad_add_product').val('')
          $('#group_hide').val('')

          grupoInsumos()

          toast_s('success', 'Se agrego correctamente')
          $('#modalCenter').modal('toggle')


        } else if (msg.trim() == 'ye') {
          toast_s('error', 'No se pudo agregar, el insumo ya existe dentro del grupo.')
        } else {
          toast_s('warning', 'Error: algo salio mal' + msg)
        }
      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      $(".container-loader").hide();
      $('#modalCenter').modal('toggle')

      toast_s('warning', 'Ocurrió un error, inténtelo nuevamente ' + errorThrown)
    });
  } //// FALTA
  //// FALTA
  //// FALTA



  function tablaProximasCompras(v) {
    $.get("../../back/ajax/com_gestor_proximas_Compras.php", "v=t", function(data) {
      $('#tbodyTableProximasCompras').html(data)
    });


    $.get("../../back/ajax/com_gestor_proximas_Compras.php", "v=p", function(data) {
      $('#section_top').html(data)
    });



  }
  tablaProximasCompras()


  function setView(view) {
    $('.content').removeClass('active')
    $('.' + view).addClass('active')

    $('.bs-stepper-circle').removeClass('active_2')
    $('#' + view + '_1').addClass('active_2')
  } // cambiar campos grupos





  $(document).ready(function() {

    $("#categoria").change(function() {
      $.get("../../back/ajax_selects/com_insumos.php", "c=" + $("#categoria").val(), function(data) {
        $("#insumo").html('<option value="">Seleccione</option>');
        $("#insumo").append(data);
      });
    });



    $("#categoria_add_product").change(function() {
      $.get("../../back/ajax_selects/com_insumos.php", "c=" + $("#categoria_add_product").val(), function(data) {
        $("#insumo_add_product").html('<option value="">Seleccione</option>');
        $("#insumo_add_product").append(data);
      });
    });




  });
</script>

</html>