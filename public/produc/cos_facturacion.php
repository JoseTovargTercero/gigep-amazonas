<?php
include('../../back/config/conexion.php');
include('../../back/config/funcione_globales.php');

if ($_SESSION["u_nivel"] != '1' && $_SESSION["u_nivel"] != '2' && $_SESSION["u_nivel"] != '3') {
  header("Location: ../index.php");
}

?>

</script>
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
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
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

  <style>
    .imagenGrande {
      z-index: 9999;
      position: fixed;
      background-color: #000000c2;
      width: 100%;
      height: 100vh;
      display: none;
    }

    .cerrar {
      height: 5%;
      padding: 15px;
    }

    .cerrar>i {
      color: white;
      font-size: 38px;
      font-weight: bold;
    }

    .imagenSection {
      height: 95%;
      display: grid;
      place-items: center;
    }

    .imagenSection>img {
      height: 60%;
    }

    @media only screen and (max-width: 570px) {
      .imagenSection>img {
        width: 90%;

      }
    }
  </style>


  <style>
    /* Header */
    .header {
      text-align: center;
    }

    .header .logo img {
      max-width: 163px;
      margin: 0 auto;
    }

    .header h1 {
      font-size: 18px;
      margin: 10px 0 5px;
      font-weight: bold;
      line-height: 1.2;
    }

    /* Details generales */
    .details {
      text-align: center;
      margin: 10px 0;
    }

    .details p {
      margin: 5px 0;
      font-size: 14px;
      color: #333;
    }

    .monto-total {
      font-size: 15px;
      margin-top: 8px;
    }

    /* Separadores */
    hr {
      border: none;
      border-top: 1px dotted #ccc;
      margin: 10px 0;
    }

    /* Sección de detalles */
    .section {
      margin: 5px 0;
    }

    .section p {
      margin: 3px 0;
      font-size: 14px;
    }

    .section .factura {
      text-align: right;
      margin-top: 5px;
      font-size: 12px;
    }

    .loader2 {
      width: 16px;
      height: 16px;
      border-radius: 50%;
      display: block;
      margin: 15px auto;
      position: relative;
      background: #FFF;
      box-shadow: -24px 0 #FFF, 24px 0 #FFF;
      box-sizing: border-box;
      animation: shadowPulse 2s linear infinite;
    }

    @keyframes shadowPulse {
      33% {
        background: #FFF;
        box-shadow: -24px 0 #69a5ff, 24px 0 #FFF;
      }

      66% {
        background: #69a5ff;
        box-shadow: -24px 0 #FFF, 24px 0 #FFF;
      }

      100% {
        background: #FFF;
        box-shadow: -24px 0 #FFF, 24px 0 #69a5ff;
      }
    }

    .loader-3 {
      width: 100%;
      height: 250px;
      display: block;
      margin: auto;
      position: relative;
      background: #FFF;
      box-sizing: border-box;
    }

    .loader-3::after {
      content: '';
      width: calc(100% - 30px);
      height: calc(100% - 30px);
      top: 15px;
      left: 15px;
      position: absolute;
      background-image: linear-gradient(100deg, transparent, rgba(255, 255, 255, 0.5) 50%, transparent 80%), radial-gradient(circle 28px at 28px 28px, #DDD 99%, transparent 0), linear-gradient(#DDD 24px, transparent 0), linear-gradient(#DDD 18px, transparent 0), linear-gradient(#DDD 66px, transparent 0);
      background-repeat: no-repeat;
      background-size: 75px 130px, 55px 56px, 100% 90px, 100% 60px, 100% 56px;
      background-position: 0% 0, 0 0, 70px 5px, 70px 38px, 0px 66px;
      box-sizing: border-box;
      animation: animloader 1s linear infinite;
    }

    @keyframes animloader {
      0% {
        background-position: 0% 0, 0 0, 70px 5px, 70px 38px, 0px 66px;
      }

      100% {
        background-position: 150% 0, 0 0, 70px 5px, 70px 38px, 0px 66px;
      }
    }
  </style>


  <style>
    .heading {
      font-size: 23px;
      font-weight: 00
    }



    .pricing {
      border: 2px solid #304FFE;
      background-color: #f2f5ff
    }

    .business {
      font-size: 20px;
      font-weight: 500
    }

    .plan {
      color: #aba4a4
    }

    .dollar {
      font-size: 16px;
      color: #6b6b6f
    }

    .amount {
      font-size: 50px;
      font-weight: 500
    }

    .year {
      font-size: 20px;
      color: #6b6b6f;
      margin-top: 19px
    }

    .detail {
      font-size: 22px;
      font-weight: 500
    }

    .cvv {
      height: 44px;
      width: 73px;
      border: 2px solid #eee
    }

    .cvv:focus {
      box-shadow: none;
      border: 2px solid #304FFE
    }

    .email-text {
      height: 55px;
      border: 2px solid #eee
    }

    .email-text:focus {
      box-shadow: none;
      border: 2px solid #304FFE
    }

    .payment-button {
      height: 70px;
      font-size: 20px
    }

    .section_info_deuda {
      background-image: url('../../assets/img/corner-4-BQNaFa3v.png');
      border-top-right-radius: 0.375rem;
      border-bottom-right-radius: 0.375rem;
    }

    .bg-card {
      background-size: contain;
      background-position: right;
      border-top-right-radius: 0.375rem;
      border-bottom-right-radius: 0.375rem;
      background-repeat: no-repeat;
    }
  </style>

  <div class="imagenGrande animated fadeIn">
    <div class="cerrar text-end">
      <i class="bx bx-x pointer" onclick="$('.imagenGrande').hide()"></i>
    </div>
    <div class="imagenSection">
      <img class="imagenVehiculo" src="../../assets/img/vehiculos/<?php echo $id ?>.png" alt class="rounded-circle" />
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




            <div class="py-3 mb-3 d-flex justify-content-between">

              <div>
                <label for="cod_ced" class="form-label">Rif del comercio</label>

                <div class="input-group ">

                  <input type="text" class="form-control" placeholder="Rif del comercio" id="cod_ced" name="cod_ced">
                  <button class="btn btn-primary" id="btn-buscar">Buscar</button>
                </div>
              </div>



              <button class="btn btn-circulo btn-outline-primary rounded-circle" id="btn-tabla">
                <ion-icon name="grid-outline"></ion-icon>
              </button>


            </div>





            <div class="row hide" id="section_tabla">
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


            <div class="row hide" id="resultados_consulta">
              <div class="col-lg-12 mb-3">
                <div class="card p-3 section_info_deuda bg-card ">
                  <div class="row">
                    <div class="col-lg-8" id="infoCliente"></div>
                    <div class="col-lg-4 text-end " style="align-content: space-evenly;">
                      <button class="btn btn-primary mt-3" id="btn-pay">Procesar pago <i class="bx bx-arrow-left"></i> </button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-12" id="detalles_deuda">
                <div class="card p-3">
                  <span class="loader-3 w-100"></span>
                  <section class="row hide " id="sect_info">
                    <div class="table-responsive">
                      <table class="table table-striped  lign-middle" id="tablaDeuda">
                        <thead>
                          <tr>
                            <th>Mes</th>
                            <th>Monto (USD)</th>
                            <th>Monto (Bs)</th>
                          </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                          <tr style="background-color: #efefef; border-bottom: transparent;">
                            <th></th>
                            <th style="font-size: 16px;" id="totalUsd">$0.00</th>
                            <th style="font-size: 16px;" id="totalBs">0.00 Bs</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                    <section id="pago">


                    </section>
                  </section>
                </div>
              </div>
            </div>
            <div class="row mt-2 hide" id="pago_pro">
              <div class="col-lg-12">
                <div class="card p-3">
                  <h4 class="mb-1">Procesear pago</h4>
                  <span class="text-muted">Registra la informacion relacionada al pago</span>
                  <hr>
                  <div class="row mt-3">
                    <div class="mb-3 col-6">
                      <label for="tipo_pago" class="form-label">Metodo de pago</label>
                      <select class="form-control" name="tipo_pago" id="tipo_pago">
                        <option value="" class="text-muted">Seleccione</option>
                        <option value="bs_efectivo">Bs Efectivo</option>
                        <option value="punto">Punto de venta</option>
                        <option value="biopago">Biopago</option>
                        <option value="transferencia">Transferencia bancaria</option>
                        <option value="pago_movil">Pago Movil</option>
                        <option value="divisas">Dolares</option>
                      </select>
                    </div>

                    <div class="mb-3 col-6">
                      <label class="form-label">Fecha y hora de la transacción</label>
                      <div class="input-group">
                        <input type="datetime-local" class="form-control" id="fechaHora" name="fechaHora">
                        <button class="btn btn-outline-secondary" type="button" onclick="setFechaHoraActual()">AHORA
                        </button>
                      </div>
                    </div>


                    <div class="mb-3 col-6">
                      <label class="form-label">Monto</label>
                      <div class="input-group">
                        <input type="text" disabled class="form-control" id="monto" name="monto">
                      </div>
                    </div>

                    <div class="mb-3 col-6">
                      <label class="form-label">Observación</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="observacion" name="observacion">
                      </div>
                    </div>
                  </div>



                  <section id="pago_online" class="row hide mt-3">

                    <div class="mb-3 col-6">
                      <label class="form-label">Banco emisor</label>
                      <select class="form-control" name="banco_emisor" id="banco_emisor">
                        <option value="">Seleccione</option>
                        <option value="0134">BANESCO</option>
                        <option value="0156">100%BANCO</option>
                        <option value="0196">ABN AMRO BANK</option>
                        <option value="0172">BANCAMIGA BANCO MICROFINANCIERO, C.A.</option>
                        <option value="0171">BANCO ACTIVO BANCO COMERCIAL, C.A.</option>
                        <option value="0166">BANCO AGRICOLA</option>
                        <option value="0175">BANCO BICENTENARIO</option>
                        <option value="0128">BANCO CARONI, C.A. BANCO UNIVERSAL</option>
                        <option value="0001">BANCO CENTRAL DE VENEZUELA.</option>
                        <option value="0164">BANCO DE DESARROLLO DEL MICROEMPRESARIO</option>
                        <option value="0102">BANCO DE VENEZUELA S.A.I.C.A.</option>
                        <option value="0114">BANCO DEL CARIBE C.A.</option>
                        <option value="0149">BANCO DEL PUEBLO SOBERANO C.A.</option>
                        <option value="0163">BANCO DEL TESORO</option>
                        <option value="0176">BANCO ESPIRITO SANTO, S.A.</option>
                        <option value="0115">BANCO EXTERIOR C.A.</option>
                        <option value="0173">BANCO INTERNACIONAL DE DESARROLLO, C.A.</option>
                        <option value="0105">BANCO MERCANTIL C.A.</option>
                        <option value="0191">BANCO NACIONAL DE CREDITO</option>
                        <option value="0116">BANCO OCCIDENTAL DE DESCUENTO.</option>
                        <option value="0138">BANCO PLAZA</option>
                        <option value="0108">BANCO PROVINCIAL BBVA</option>
                        <option value="0104">BANCO VENEZOLANO DE CREDITO S.A.</option>
                        <option value="0168">BANCRECER S.A. BANCO DE DESARROLLO</option>
                        <option value="0177">BANFANB</option>
                        <option value="0146">BANGENTE</option>
                        <option value="0174">BANPLUS BANCO COMERCIAL C.A</option>
                        <option value="0190">CITIBANK.</option>
                        <option value="0157">DELSUR BANCO UNIVERSAL</option>
                        <option value="0151">FONDO COMUN</option>
                        <option value="0601">INSTITUTO MUNICIPAL DE CRÉDITO POPULAR</option>
                        <option value="0169">MIBANCO BANCO DE DESARROLLO, C.A.</option>
                        <option value="0137">SOFITASA</option>

                      </select>
                    </div>



                    <div class="mb-3 col-6">
                      <label class="form-label">Código de transacción');</label>
                      <input type="text" class="form-control" id="codigo" placeholder="Numero de transacción">
                    </div>
                  </section>




                  <script>
                    function setFechaHoraActual() {
                      const input = document.getElementById("fechaHora");
                      const ahora = new Date();

                      // Formato correcto para datetime-local → "YYYY-MM-DDTHH:MM"
                      const year = ahora.getFullYear();
                      const month = String(ahora.getMonth() + 1).padStart(2, '0');
                      const day = String(ahora.getDate()).padStart(2, '0');
                      const hour = String(ahora.getHours()).padStart(2, '0');
                      const minute = String(ahora.getMinutes()).padStart(2, '0');

                      const fechaHoraFormateada = `${year}-${month}-${day}T${hour}:${minute}`;
                      input.value = fechaHoraFormateada;
                    }
                  </script>


                  <!-- Columna Bootstrap -->
                  <div class="mt-4 row hide" id="comprobante_pago">

                    <hr>

                    <div class="mb-3 col-lg-6">
                      <h6 class="text-primary">Comprobante de pago</h6>
                      <div class="image-upload-card">
                        <input id="imgInput" type="file" accept="image/*" hidden>

                        <!-- Dropzone -->
                        <label for="imgInput" class="dropzone" id="dropzone">
                          <div class="dz-content">
                            <!-- Ícono -->
                            <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="#007bff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                              <polyline points="17 8 12 3 7 8" />
                              <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            <h6>Sube el comprobante del pago</h6>
                            <p class="hint">Haz clic o arrastra una imagen aquí</p>
                            <p class="types">Formatos: PNG, JPG, WEBP</p>
                          </div>
                        </label>

                        <!-- Vista previa -->
                        <div class="preview-wrapper d-none" id="previewWrap">
                          <img id="previewImg" alt="Vista previa">
                          <button type="button" class="clear-btn" id="clearBtn" aria-label="Quitar imagen">×</button>
                        </div>
                      </div>
                    </div>

                    <div class="mb-3 col-lg-6" id="section_datos_pago">
                      <h6 class="text-primary">Datos de la cuenta</h6>
                      <div class="datos-cuenta">
                        <div class="list-group" id="datos_pago">
                        </div>
                      </div>
                    </div>


                  </div>



                  <script>
                    (function() {
                      const input = document.getElementById('imgInput');
                      const dropzone = document.getElementById('dropzone');
                      const previewWrap = document.getElementById('previewWrap');
                      const previewImg = document.getElementById('previewImg');
                      const clearBtn = document.getElementById('clearBtn');

                      function isImage(file) {
                        return file && file.type && file.type.startsWith('image/');
                      }

                      function showPreview(file) {
                        if (!isImage(file)) {
                          alert('Por favor selecciona un archivo de imagen válido.');
                          input.value = '';
                          return;
                        }
                        const url = URL.createObjectURL(file);
                        previewImg.src = url;
                        dropzone.classList.add('d-none');
                        previewWrap.classList.remove('d-none');
                      }

                      input.addEventListener('change', (e) => {
                        const file = e.target.files && e.target.files[0];
                        if (file) showPreview(file);
                      });

                      // Drag & drop
                      ['dragenter', 'dragover'].forEach(evt => {
                        dropzone.addEventListener(evt, e => {
                          e.preventDefault();
                          e.stopPropagation();
                          dropzone.style.borderColor = '#007bff';
                          dropzone.style.background = '#f0f8ff';
                        });
                      });
                      ['dragleave', 'drop'].forEach(evt => {
                        dropzone.addEventListener(evt, e => {
                          e.preventDefault();
                          e.stopPropagation();
                          dropzone.style.borderColor = '#ccc';
                          dropzone.style.background = '#f9f9f9';
                        });
                      });
                      dropzone.addEventListener('drop', (e) => {
                        const file = e.dataTransfer.files && e.dataTransfer.files[0];
                        if (file) {
                          input.files = e.dataTransfer.files; // sustituye input
                          showPreview(file);
                        }
                      });

                      // Limpiar
                      clearBtn.addEventListener('click', () => {
                        previewImg.src = '';
                        input.value = '';
                        previewWrap.classList.add('d-none');
                        dropzone.classList.remove('d-none');
                      });
                    })();
                  </script>

                  <div class="mt-3 text-center">
                    <button id="btn_guardar_pago" class="btn btn-primary btn-block "> Procesar el pago</button>
                  </div>
                </div>
              </div>

              <div class="mt-3 col-lg-6 hide">
                <div class="card p-3" id="c_ip">
                  <div class="header ">
                    <div class="logo">
                      <img src="../../assets/img/gobierno/epa.png" alt="Logo Empresa Pública Amazonas">
                    </div>
                    <h1>EMPRESA PÚBLICA AMAZONAS</h1>
                  </div>
                  <div class="details">
                    <p>G-0000</p>
                    <p>Contribución consciente <strong>(SA-HA-GC)</strong></p>
                    <p><?php echo date('Y-m-d h:i a') ?></p>
                    <p>*Factura <strong>315486</strong></p>
                    <div class="text-center">
                      <p class="monto-total"><strong>Monto total: 255 Bs</strong></p>
                    </div>
                  </div>
                  <hr>

                  <!-- Sección de contribución 1 -->
                  <div class="section p-3">
                    <p><strong>Contribución consciente: SANEAMIENTO AMBIENTAL.</strong></p>
                    <p>Descripción: <strong>Recolección de desechos.</strong></p>
                    <p>Número de contrato: <strong>J01R25.</strong></p>
                    <p>Monto: <strong>30 bs</strong></p>
                    <p class="factura">F <strong>315486</strong></p>
                  </div>
                  <hr>

                  <!-- Sección de contribución 2 -->
                  <div class="section p-3">
                    <p><strong>Contribución conciente: AGUA POTABLE.</strong></p>
                    <p>Descripción: <strong>Agua por tubería.</strong></p>
                    <p>Número de contrato: <strong>J01R25.</strong></p>
                    <p>Monto: <strong>115 Bs</strong></p>
                    <p class="factura">F <strong>315486</strong></p>
                  </div>
                  <hr>

                  <!-- Sección de contribución 3 -->
                  <div class="section p-3">
                    <p><strong>Pago del servicio: GAS DOMESTICO.</strong></p>
                    <p>Descripción: <strong>(1) bombona 17kg.</strong></p>
                    <p>Número de contrato: <strong>J01R25.</strong></p>
                    <p>Monto: <strong>110bs </strong></p>
                    <p class="factura">F <strong>315486</strong></p>
                  </div>
                  <hr>

                  <div class="text-center">
                    <p class="monto-total"><strong>Monto total: 255 Bs</strong></p>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!--/ Customer Content -->
      </div>
    </div>
    <script>
      // controlar la visualizacion de los datos de la cuenta

      const deuda_global = {
        id: null,
        total_usd: 0,
        total_bs: 0
      };


      const datosPago = {
        'transferencia': {
          banco: 'Banco Nacional de Crédito (BNC)',
          titular: 'Empresa Pública Amazonas',
          rif: 'G-00000000-0',
          cuenta: '0124-0124-01-0123456789',
          tipo: 'Ahorros'
        },
        'pago_movil': {
          banco: 'Banco de Venezuela (BDV)',
          titular: 'Empresa Pública Amazonas',
          rif: 'G-00000000-0',
          cuenta: '0124-0124-01-0123456789',
          tipo: 'Ahorros'
        }
      }


      function actualizarDatosPago(metodo) {
        const datosDiv = document.getElementById('datos_pago');
        datosDiv.innerHTML = ''; // Limpiar contenido previo
        const $pago_online = document.getElementById('pago_online');

        if (datosPago[metodo]) {
          $pago_online.classList.remove('hide');
          const datos = datosPago[metodo];
          for (const key in datos) {
            const item = document.createElement('div');
            item.className = 'list-group-item';
            item.innerHTML = `<strong>${key.charAt(0).toUpperCase() + key.slice(1)}:</strong> ${datos[key]}`;
            datosDiv.appendChild(item);
          }
          document.getElementById('comprobante_pago').classList.remove('hide');
        } else {
          document.getElementById('comprobante_pago').classList.add('hide');
          $pago_online.classList.add('hide');
        }
      }

      document.getElementById('tipo_pago').addEventListener('change', function() {
        const metodo = this.value.toLowerCase();
        actualizarDatosPago(metodo);

        const $monto = document.getElementById('monto');
        if (metodo === 'divisas') {
          $monto.value = `$${deuda_global.total_usd.toFixed(2)} USD`;
        } else if (metodo !== '') {
          $monto.value = `${deuda_global.total_bs.toFixed(2)} Bs`;
        } else {
          $monto.value = '';
        }
      });











      let $resultados_consulta = $('#resultados_consulta');

      $(document).ready(function() {
        $('#btn-buscar').on('click', function() {

          // Obtener el valor del input con ID `#cod_ced`
          var identificador = $('#cod_ced').val();

          // Verificar si el campo está vacío
          if (!identificador) {
            toast_s('warning', 'Por favor, ingresa un valor en el campo')
            return;
          }

          // hide section_tabla 
          $('#section_tabla').addClass('hide');


          var $loader = $('#consulta-loader');

          // Mostrar el loader con animación
          if ($loader.is(':visible')) {
            $loader.stop().animate({
                height: 0,
                opacity: 0,
              },
              300,
              function() {
                $loader.hide();
              }
            );
          } else {
            $loader.show(); // Muestra el elemento
            var height = $loader.prop('scrollHeight'); // Altura real del contenido
            $loader
              .css({
                height: 0,
                opacity: 0,
              }) // Inicializa la altura
              .stop()
              .animate({
                  height: height,
                  opacity: 1,
                },
                300
              );
          }

          // Enviar la solicitud con fetch
          fetch('../../back/ajax/cos_consulta_deuda_comercial.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
              },
              body: JSON.stringify({
                identificador: identificador, // Enviar el input con el nombre 'identificador'
              }),
            })
            .then((response) => {

              return response.json();
            })
            .then((data) => {

              $resultados_consulta.removeClass('hide');

              console.log(data)
              mostrarDeuda(data);



              if (data['message'] == 'No se encontraron resultados') {
                toast_s('warning', 'No se encontraron resultados')
                return;
              }
              // Manejar la respuesta
              $('.loader-3').hide(300)
              $('#sect_info').removeClass('hide')


            })
            .catch((error) => {
              console.error('Error:', error);
              alert('Ocurrió un error al realizar la consulta');
            })
            .finally(() => {
              // Ocultar el loader después de finalizar la solicitud
              $loader.stop().animate({
                  height: 0,
                  opacity: 0,
                },
                300,
                function() {
                  $loader.hide();
                }
              );
            });
        });


        $('#btn-pay').on('click', function() {
          const $btn = $(this);

          // verifica si #pago_pro tiene la clase hide
          if (!$('#pago_pro').hasClass('hide')) {
            $('#pago_pro').addClass('hide') // Se oculta la seccion de pago
            $btn.html('Procesar pago <i class="bx bx-arrow-left"></i>') // Cambia el texto del boton
            $btn.removeClass('btn-danger').addClass('btn-primary') // Cambia el color del boton
            $('#detalles_deuda').removeClass('hide')
          } else {
            $('#pago_pro').removeClass('hide') // Se muestra la seccion de pago
            $btn.html('Regresar <i class="bx bx-arrow-right"></i>') // Cambia el texto del boton
            $btn.removeClass('btn-primary').addClass('btn-danger') // Cambia el color del boton
            $('#detalles_deuda').addClass('hide')
          }



        });
      });









      // 👉 Función para mostrar datos
      function mostrarDeuda(data) {
        const cliente = data.datos_cliente;
        const deuda = data.deuda;
        const ultimoPago = deuda.ultimo_pago == '202509' ? `No iniciado.` : deuda.ultimo_pago;
        const status = deuda.total_usd > 0 ? `<span class="badge bg-danger">Con deuda</span>` : `<span class="badge bg-success">Al día</span>`;
        // Mostrar info del cliente
        document.getElementById('infoCliente').innerHTML = `
            <h5 class="mb-0">${cliente.SUJETO}</h5>
                      <p class="fs-10 mt-1">Ultimo pago: ${ultimoPago}</p>
                      <div><strong class="me-2">Estatus: </strong>
                      ${status}
                      </div>
              `;

        // Llenar tabla
        const tbody = document.querySelector("#tablaDeuda tbody");
        tbody.innerHTML = "";

        deuda.detalle.forEach(item => {
          const fila = `
      <tr>
        <td><h6>${nombreMes(item.mes)} de ${item.anio}</h6> <span>Contribución unica</span></td>
        <td>$${item.monto_usd.toFixed(2)}</td>
        <td>${item.monto_bs.toFixed(2)} Bs</td>
      </tr>
    `;
          tbody.innerHTML += fila;
        });

        deuda_global.id = cliente.ID;
        deuda_global.total_usd = deuda.detalle.reduce((acc, item) => acc + item.monto_usd, 0);
        deuda_global.total_bs = deuda.detalle.reduce((acc, item) => acc + item.monto_bs, 0);



        // Totales
        document.getElementById("totalUsd").textContent = `$${deuda.total_usd.toFixed(2)}`;
        document.getElementById("totalBs").textContent = `${deuda.total_bs.toFixed(2)} Bs`;
      }

      // 👉 Función para convertir número de mes en nombre
      function nombreMes(num) {
        const meses = ["", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
          "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        ];
        return meses[num] || num;
      }








      // REGISTRAR EL PAGO

      document.getElementById("btn_guardar_pago").addEventListener("click", function() {
        // Capturamos el contenido del div
        const imgInput = document.getElementById('imgInput').files[0];
        const tipo_pago = document.getElementById('tipo_pago').value;
        const fechaHora = document.getElementById('fechaHora').value;
        const observacion = document.getElementById('observacion').value;
        const banco_emisor = document.getElementById('banco_emisor').value;
        const codigo = document.getElementById('codigo').value;

        // Validaciones
        if (!tipo_pago || !fechaHora) {
          toast_s('warning', 'Por favor, complete los campos obligatorios');
          return;
        }
        if ((tipo_pago === 'transferencia' || tipo_pago === 'pago_movil') && !imgInput) {
          toast_s('warning', 'Por favor, suba el comprobante de pago');
          return;
        }
        if ((tipo_pago === 'transferencia' || tipo_pago === 'pago_movil') && !codigo) {
          toast_s('warning', 'Por favor, ingrese el código de transacción');
          return;
        }

        // Construir FormData
        const formData = new FormData();
        formData.append('tipo_pago', tipo_pago);
        formData.append('fechaHora', fechaHora);
        formData.append('observacion', observacion);
        formData.append('banco_emisor', banco_emisor);
        formData.append('id', deuda_global.id);
        console.log(deuda_global.id)

        formData.append('codigo', codigo);
        if (imgInput) {
          formData.append('comprobante', imgInput);
        }

        // Enviar por fetch
        fetch('../../back/ajax/cos_guardar_pago.php', {
            method: 'POST',
            body: formData
          })
          .then(response => response.json()) // si el backend responde en JSON
          .then(data => {
            if (data.success) {


              if (tipo_pago === 'transferencia' || tipo_pago === 'pago_movil') {
                actualizarTabla();
              }

              toast_s('success', 'Pago registrado correctamente');
              // limpiar formulario
              actualizarTabla();
              reiniciarVistas()
              document.getElementById('clearBtn').click()

              document.getElementById('tipo_pago').value = '';
              document.getElementById('fechaHora').value = '';
              document.getElementById('observacion').value = '';
              document.getElementById('banco_emisor').value = '';
              document.getElementById('codigo').value = '';
              document.getElementById('imgInput').value = '';
            } else {
              toast_s('error', data.message || 'Ocurrió un error al guardar el pago');
            }
          })
          .catch(error => {
            console.error('Error en la petición:', error);
            toast_s('error', 'No se pudo conectar con el servidor');
          });
      });



      function reiniciarVistas() { // here
        $('#cod_ced').val('')
        $('#pago_pro').addClass('hide')
        $('#resultados_consulta').addClass('hide')
        $('#detalles_deuda').removeClass('hide')
        $('#btn-pay').html('Procesar pago <i class="bx bx-arrow-left"></i>') // Cambia el texto del boton
        $('#btn-pay').removeClass('btn-danger').addClass('btn-primary') // Cambia el color del boton
      }






      // pendiente

      function print() {

        const contenido = document.getElementById("c_ip").innerHTML;

        // Abrimos una nueva ventana o pestaña
        const ventana = window.open("", "_blank", "width=400,height=600");

        // Escribimos el contenido en la nueva ventana
        ventana.document.open();
        ventana.document.write(`
        <!DOCTYPE html>
        <html>
          <head>
            <title>Impresión</title>
            <style>
              /* Puedes agregar estilos personalizados aquí si es necesario */
              body {
                font-family: Arial, sans-serif;
                margin: 20px;
              }
                 /* Header */
                  .header {
                    text-align: center;
                  }

                  .header .logo img {
                    max-width: 163px;
                    margin: 0 auto;
                  }

                  .header h1 {
                    font-size: 18px;
                    margin: 10px 0 5px;
                    font-weight: bold;
                    line-height: 1.2;
                  }

                  /* Details generales */
                  .details {
                    text-align: center;
                    margin: 10px 0;
                  }

                  .details p {
                    margin: 5px 0;
                    font-size: 14px;
                    color: #333;
                  }

                  .monto-total {
                    font-size: 15px;
                    margin-top: 8px;
                  }

                  /* Separadores */
                  hr {
                    border: none;
                    border-top: 1px dotted #ccc;
                    margin: 10px 0;
                  }

                  /* Sección de detalles */
                  .section {
                    margin: 5px 0;
                  }

                  .section p {
                    margin: 3px 0;
                    font-size: 14px;
                  }

                  .section .factura {
                    text-align: right;
                    margin-top: 5px;
                    font-size: 12px;
                  }

                          </style>
                        </head>
                        <body>
                          ${contenido}
                        </body>
                      </html>
                    `);
        ventana.document.close();


        // Forzar impresión
        ventana.print();

        // Cerrar la ventana después de un tiempo fijo (fallback para onafterprint)
        setTimeout(() => {
          if (!ventana.closed) {
            ventana.close();
            $('#pago_pro').addClass('hide')
            $('#cod_ced').val('')
            Swal.fire({
              title: "Buen trabajo",
              text: "Se proceso el pago correctamente",
              icon: "success"
            });
          }
        }, 2000); // Ajusta el tiempo según sea necesario
      }
    </script>


    <div class="modal fade" id="modal_repuestos" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

          <div class="modal-body" id="list_respuestos">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              Cerrar
            </button>
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
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

</body>

<script>
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
        $(".datatable-title").html('<h4 class="mb-2 mt-2">Pagos Pendientes</h4>');
      }
    });
  });



  function actualizarTabla() {
    fetch('../../back/ajax/cos_consulta_pagos.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          filtro: 'pendientes_general'
        })
      })
      .then(res => res.json())
      .then(data => {

        console.log('data' + data);
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
            '<div class="badge badge-subtle-warning rounded-pill"><p class="mb-0">Pendiente</p></div>',
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


  document.getElementById('btn-tabla').addEventListener('click', function() {
    // alterna clase hide en #section_tabla
    // verifica si tiene la clase hide y se va a mostrar, actualiza la tabla con actualizarTabla()
    if (!$('#section_tabla').hasClass('hide')) {
      actualizarTabla()
    }

    $('#section_tabla').toggleClass('hide');

  });
</script>

</html>