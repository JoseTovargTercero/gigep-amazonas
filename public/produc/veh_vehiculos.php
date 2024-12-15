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
  <title class="vehiculos" id="title">Vehículos</title>
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

  <script>
    var nombreRepuestos = []
    <?php
    $stmt = mysqli_prepare($conexion, "SELECT id_i, insumo FROM `veh_partes` WHERE tipo='1'");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo 'nombreRepuestos["' . $row['id_i'] . '"] = "' . $row['insumo'] . '";';
      }
    }
    $stmt->close();
    ?>
  </script>
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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Vehículos /</span> Lista de vehículos</h4>
            </div>
            <div class="row ">
              <div class="col-lg-12">

                <div class="card mb-3" id="nuevoVehiculoSec" style="display: none;">
                  <div class="card-body">
                    <div class="d-flex  justify-content-between mb-3">

                      <h5 class="card-title">
                        Nuevo vehículo
                      </h5>
                      <button class="btn btn btn-label-secondary btn-sm" onclick="nuevoVehiculoSection()"> <i class="bx bx-x"></i> Cancelar</button>

                    </div>


                    <div class="bs-stepper-header border-bottom pb-3">
                      <div class="step" onclick="setView('view-1')">
                        <button type="button" class="step-trigger" aria-selected="false">
                          <span class="bs-stepper-circle view-1 active_2" id="view-1_1">
                            <i class='bx bx-car'></i>
                          </span>
                          <div class="bs-stepper-label text-start">
                            <h5 class="mb-0">Tipo de vehículo</h5>
                            <span class="bs-stepper-subtitle text-muted">Modelo y marca</span>
                          </div>
                        </button>
                      </div>


                      <div class="line">
                        <i class="bx bx-chevron-right fs-2 text-muted"></i>
                      </div>
                      <div class="step" onclick="setView('view-2')">
                        <button type="button" class="step-trigger" aria-selected="false">
                          <span class="bs-stepper-circle view-2" id="view-2_1">
                            <i class='bx bx-detail'></i>
                          </span>
                          <div class="bs-stepper-label text-start">
                            <h5 class="mb-0">Detalles</h5>
                            <span class="bs-stepper-subtitle text-muted">Detalles del vehículo</span>
                          </div>
                        </button>
                      </div>




                      <div class="line">
                        <i class="bx bx-chevron-right fs-2 text-muted"></i>
                      </div>
                      <div class="step" onclick="setView('view-3')">
                        <button type="button" class="step-trigger" aria-selected="false">
                          <span class="bs-stepper-circle view-3" id="view-3_1">
                            <i class='bx bx-gas-pump'></i>
                          </span>
                          <div class="bs-stepper-label text-start">
                            <h5 class="mb-0">Fluidos</h5>
                            <span class="bs-stepper-subtitle text-muted">Consumo de fluidos</span>
                          </div>
                        </button>
                      </div>










                      <div class="line">
                        <i class="bx bx-chevron-right fs-2 text-muted"></i>
                      </div>
                      <div class="step" onclick="setView('view-4')">
                        <button type="button" class="step-trigger" aria-selected="false">
                          <span class="bs-stepper-circle view-4" id="view-4_1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1)">
                              <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 13a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm2.75-7.17A5 5 0 0 0 13 7.1v-3a7.94 7.94 0 0 1 3.9 1.62zM11 7.1a5 5 0 0 0-1.75.73L7.1 5.69A7.94 7.94 0 0 1 11 4.07zM7.83 9.25A5 5 0 0 0 7.1 11h-3a7.94 7.94 0 0 1 1.59-3.9zM7.1 13a5 5 0 0 0 .73 1.75L5.69 16.9A7.94 7.94 0 0 1 4.07 13zm2.15 3.17a5 5 0 0 0 1.75.73v3a7.94 7.94 0 0 1-3.9-1.62zm3.75.73a5 5 0 0 0 1.75-.73l2.15 2.14a7.94 7.94 0 0 1-3.9 1.62zm3.17-2.15A5 5 0 0 0 16.9 13h3a7.94 7.94 0 0 1-1.62 3.9zM16.9 11a5 5 0 0 0-.73-1.75l2.14-2.15a7.94 7.94 0 0 1 1.62 3.9z"></path>
                            </svg>
                          </span>
                          <div class="bs-stepper-label text-start">
                            <h5 class="mb-0">Neumáticos</h5>
                            <span class="bs-stepper-subtitle text-muted">Ejes y neumáticos</span>
                          </div>
                        </button>
                      </div>

                      <div class="line">
                        <i class="bx bx-chevron-right fs-2 text-muted"></i>
                      </div>
                      <div class="step" onclick="setView('view-5')">
                        <button type="button" class="step-trigger" aria-selected="false">
                          <span class="bs-stepper-circle view-5" id="view-5_1">
                            <i class='bx bx-wrench'></i>
                          </span>
                          <div class="bs-stepper-label text-start">
                            <h5 class="mb-0">Operatividad</h5>
                            <span class="bs-stepper-subtitle text-muted">Estado operativo</span>
                          </div>
                        </button>
                      </div>
                    </div>
                    <div class="bs-stepper wizard-vertical vertical wizard-vertical-icons-example mt-2">
                      <form class="bs-stepper-content" id="formElem" enctype="multipart/form-data">
                        <div id="view-1" class="view-1 content active">
                          <div class="content-header mb-3">
                            <h6 class="mb-0">Tipo de vehículo</h6>
                            <small>Modelo y marca</small>
                          </div>
                          <div class="row">
                            <div class="col-lg-6">

                              <div class="mb-3">
                                <label for="tipo_vehiculo" class="form-label">Tipo de vehículo</label>
                                <select id="tipo_vehiculo" name="tipo_vehiculo" class="form-control" onchange="setEjes(this.value)">
                                  <option value="">Seleccione</option>
                                  <option value="AMBULANCIA">AMBULANCIA</li=>
                                  <option value="ARRASTRE">ARRASTRE</option>
                                  <option value="AUTOBUS">AUTOBUS</option>
                                  <option value="BATEA">BATEA</option>
                                  <option value="BOMBEADOR DE CONCRETO">BOMBEADOR DE CONCRETO</option>
                                  <option value="CABINA">CABINA</option>
                                  <option value="CAMION TRACTOR">CAMION TRACTOR</option>
                                  <option value="CASILLERO">CASILLERO</option>
                                  <option value="CAVA">CAVA</option>
                                  <option value="CAVA/GRANEL">CAVA/GRANEL</option>
                                  <option value="CESTA">CESTA</option>
                                  <option value="CHUTO">CHUTO</option>
                                  <option value="CISTERNA">CISTERNA</option>
                                  <option value="ESPECIAL">ESPECIAL</option>
                                  <option value="ESTACA/BARANDA">ESTACA/BARANDA</option>
                                  <option value="ESTACAS">ESTACAS</option>
                                  <option value="MINIBUS">MINIBUS</option>
                                  <option value="MINIVAN">MINIVAN</option>
                                  <option value="MONTA CARGA">MONTA CARGA</option>
                                  <option value="MOTOCICLETA">MOTOCICLETA</option>
                                  <option value="PICK-UP">PICK-UP</option>
                                  <option value="PICK-UP C/CABINA">PICK-UP C/CABINA</option>
                                  <option value="PICK-UP D/CABINA">PICK-UP D/CABINA</option>
                                  <option value="PICK-UP/BARANDA">PICK-UP/BARANDA</option>
                                  <option value="PICK-UP/BARANDA/HIERRO">PICK-UP/BARANDA/HIERRO</option>
                                  <option value="PICK-UP/C CABINA">PICK-UP/C CABINA</option>
                                  <option value="PICK-UP/C FURGON">PICK-UP/C FURGON</option>
                                  <option value="PLATABANDA">PLATABANDA</option>
                                  <option value="SEDAN">SEDAN</option>
                                  <option value="TECHO DE LONA">TECHO DE LONA</option>
                                  <option value="TECHO DURO">TECHO DURO</option>
                                  <option value="TRACTOR">TRACTOR</option>
                                  <option value="TRAYLER">TRAYLER</option>
                                  <option value="TRIMOVIL">TRIMOVIL</option>
                                  <option value="VACUUM">VACUUM</option>
                                  <option value="VAN">VAN</option>
                                  <option value="VOLTEO">VOLTEO</option>
                                </select>
                              </div>
                              <div class="mb-3">
                                <label for="marca" class="form-label">Marca</label>
                                <input type="text" id="marca" name="marca" list="marcas" class="form-control">

                              </div>


                              <datalist id="marcas">
                                <option value="AG"></option>
                                <option value="ACURA"></option>
                                <option value="AGAMAR"></option>
                                <option value="AGRALE"></option>
                                <option value="AGUILA"></option>
                                <option value="ALFA ROMEO"></option>
                                <option value="AMERICAN MOTORCYCLE"></option>
                                <option value="AMERICAN SCOOTER"></option>
                                <option value="APOLO"></option>
                                <option value="APRIOPTIONA"></option>
                                <option value="ARO"></option>
                                <option value="ASTRA"></option>
                                <option value="AUDI"></option>
                                <option value="AUTOGAGO"></option>
                                <option value="AVA"></option>
                                <option value="AVILA"></option>
                                <option value="BAJAJ"></option>
                                <option value="BATEAS DE OCCIDENTE"></option>
                                <option value="BATEAS GERPLAP"></option>
                                <option value="BATEAS JM"></option>
                                <option value="BATEAS LARA"></option>
                                <option value="BATEAS SAN CRISTOBAL"></option>
                                <option value="BENELOPTION"></option>
                                <option value="BERA"></option>
                                <option value="BIMI FORCE"></option>
                                <option value="BLUE BIRD"></option>
                                <option value="BMW"></option>
                                <option value="BRONX"></option>
                                <option value="BRUMOCA"></option>
                                <option value="BUICK"></option>
                                <option value="BYD"></option>
                                <option value="CADILLAC"></option>
                                <option value="CARIBE"></option>
                                <option value="CARONI"></option>
                                <option value="CARROCERIA SN MARCOS"></option>
                                <option value="CARROCERIAS CHAMA"></option>
                                <option value="CARROCERIAS CORTEZ"></option>
                                <option value="CARROCERIAS SUCRE"></option>
                                <option value="CASERTA GROUP"></option>
                                <option value="CATERPILLAR"></option>
                                <option value="CEOPTIONMO"></option>
                                <option value="CHAMA"></option>
                                <option value="CHANA"></option>
                                <option value="CHANGHE"></option>
                                <option value="CHERY"></option>
                                <option value="CHEVROLET"></option>
                                <option value="CHRYSLER"></option>
                                <option value="CIMC"></option>
                                <option value="CITROEN"></option>
                                <option value="CONQUISTADOR"></option>
                                <option value="CONST. METAOPTIONCAS LEO"></option>
                                <option value="D INNOCENZO"></option>
                                <option value="DACIA"></option>
                                <option value="DAEWOO"></option>
                                <option value="DAEWOO POLSKA"></option>
                                <option value="DAFU"></option>
                                <option value="DAIHATSU"></option>
                                <option value="DAYUN"></option>
                                <option value="DE CARO"></option>
                                <option value="DE CARO MOTOS"></option>
                                <option value="DELAGE"></option>
                                <option value="DFM"></option>
                                <option value="DIDI"></option>
                                <option value="DITE / MOTORCA"></option>
                                <option value="DIVICA"></option>
                                <option value="DODGE"></option>
                                <option value="DONGFENG"></option>
                                <option value="DUCATI"></option>
                                <option value="EBRO"></option>
                                <option value="EDGAURIST C.A"></option>
                                <option value="EMPIRE"></option>
                                <option value="ENCAVA"></option>
                                <option value="EQUIVENCA, C.A"></option>
                                <option value="EROX"></option>
                                <option value="FABR. EXTRANJERA"></option>
                                <option value="FABRICACION NAC"></option>
                                <option value="FABRIMONCA"></option>
                                <option value="FACCHINI"></option>
                                <option value="FAREARA"></option>
                                <option value="FARGO"></option>
                                <option value="FAW"></option>
                                <option value="FIAT"></option>
                                <option value="FICA`S"></option>
                                <option value="FORCE"></option>
                                <option value="FORD"></option>
                                <option value="FORMACA"></option>
                                <option value="FOTON"></option>
                                <option value="FRAB"></option>
                                <option value="FREE WAYS"></option>
                                <option value="FREIGHTOPTIONNER"></option>
                                <option value="FRENOS DE AIRE DEL C"></option>
                                <option value="FRUEHAUF"></option>
                                <option value="FURGO ESTACAS"></option>
                                <option value="FYM"></option>
                                <option value="G.M.C"></option>
                                <option value="G.M.C. TRUCK"></option>
                                <option value="GEELY"></option>
                                <option value="GENERAL MOTORS"></option>
                                <option value="GILERA"></option>
                                <option value="GREAT DANE"></option>
                                <option value="GREAT WALL"></option>
                                <option value="GROVE"></option>
                                <option value="GUASARE"></option>
                                <option value="GUERRA"></option>
                                <option value="GURI"></option>
                                <option value="GUZZI"></option>
                                <option value="GWM"></option>
                                <option value="HAFEI"></option>
                                <option value="HAIMA"></option>
                                <option value="HAOJIANG"></option>
                                <option value="HAOJUE"></option>
                                <option value="HAOTIAN"></option>
                                <option value="HARLEY DAVIDSON"></option>
                                <option value="HILLMAN"></option>
                                <option value="HINO"></option>
                                <option value="HINO MOTORS DE VENEZUELA CA"></option>
                                <option value="HONDA"></option>
                                <option value="HUALONG"></option>
                                <option value="HUMMER"></option>
                                <option value="HUONIAO"></option>
                                <option value="HUSQVARNA"></option>
                                <option value="HYOSUNG"></option>
                                <option value="HYUNDAI"></option>
                                <option value="HZ- ACETO"></option>
                                <option value="IBRANCA"></option>
                                <option value="IMMECA"></option>
                                <option value="IMMENSA"></option>
                                <option value="INCA"></option>
                                <option value="IND. METALURGICA COLON"></option>
                                <option value="INDIANAPOOPTIONS"></option>
                                <option value="INDUAGA"></option>
                                <option value="INDUST. METAL. HP"></option>
                                <option value="INMECAR"></option>
                                <option value="INSTALME"></option>
                                <option value="INTERNACIONAL"></option>
                                <option value="INTERNATIONAL"></option>
                                <option value="INTORCA"></option>
                                <option value="ISUZU"></option>
                                <option value="IVECO"></option>
                                <option value="JAC"></option>
                                <option value="JAGUAR"></option>
                                <option value="JEEP"></option>
                                <option value="JHON DEERE"></option>
                                <option value="JIAOPTIONNG"></option>
                                <option value="JIANSHE"></option>
                                <option value="JINLUN"></option>
                                <option value="JMC"></option>
                                <option value="JUVE"></option>
                                <option value="KAMAZ"></option>
                                <option value="KAWASAKI"></option>
                                <option value="KAWUASUKI"></option>
                                <option value="KEEWAY"></option>
                                <option value="KENWORTH"></option>
                                <option value="KIA"></option>
                                <option value="KORACA"></option>
                                <option value="KTC"></option>
                                <option value="KTM"></option>
                                <option value="KYMCO"></option>
                                <option value="KYOTO"></option>
                                <option value="LADA"></option>
                                <option value="LAND ROVER"></option>
                                <option value="LANDOLFO"></option>
                                <option value="LAVAL"></option>
                                <option value="LEXUS"></option>
                                <option value="LH300T-B"></option>
                                <option value="OPTIONFAN"></option>
                                <option value="OPTIONNCOLN"></option>
                                <option value="OPTIONNHAI"></option>
                                <option value="LML"></option>
                                <option value="LONCIN"></option>
                                <option value="LUBEROWI"></option>
                                <option value="MACK"></option>
                                <option value="MANAURE"></option>
                                <option value="MARCOPOLO"></option>
                                <option value="MASSEY FERGUNSON"></option>
                                <option value="MASTRO"></option>
                                <option value="MAX MOTOR"></option>
                                <option value="MAXY PLUS"></option>
                                <option value="MAXYS"></option>
                                <option value="MAZ"></option>
                                <option value="MAZDA"></option>
                                <option value="MAZVEN"></option>
                                <option value="MD"></option>
                                <option value="MD HAOJIN"></option>
                                <option value="MERCEDES BENZ"></option>
                                <option value="MERCURY"></option>
                                <option value="MILLER"></option>
                                <option value="MINI"></option>
                                <option value="MITSUBISHI"></option>
                                <option value="MOKE"></option>
                                <option value="MOTO TUNING"></option>
                                <option value="MOTOMARKET"></option>
                                <option value="MOTOSTAR DE VZLA."></option>
                                <option value="NACIONAL"></option>
                                <option value="NAVEIRA"></option>
                                <option value="NEW HOLLAND"></option>
                                <option value="NEW JAGUAR"></option>
                                <option value="NISSAN"></option>
                                <option value="OKIO"></option>
                                <option value="OLDSMOBILE"></option>
                                <option value="OPEL"></option>
                                <option value="ORINOCO"></option>
                                <option value="PANTERA"></option>
                                <option value="PEGASO"></option>
                                <option value="PETER BILT"></option>
                                <option value="PEUGEOT"></option>
                                <option value="PIAGGIO"></option>
                                <option value="PLYMOUTH"></option>
                                <option value="PONTIAC"></option>
                                <option value="PORSCHE"></option>
                                <option value="PUMAX"></option>
                                <option value="QINGQI"></option>
                                <option value="QIPAI"></option>
                                <option value="RAMBLER"></option>
                                <option value="RANDON"></option>
                                <option value="REMOLQUES DOGUI"></option>
                                <option value="REMOLQUES KREMEZIS"></option>
                                <option value="REMOLQUES WAL"></option>
                                <option value="REMYVECA"></option>
                                <option value="RENAULT"></option>
                                <option value="REO"></option>
                                <option value="RETOÑO"></option>
                                <option value="RIO"></option>
                                <option value="ROIN CA"></option>
                                <option value="ROMBAUCA"></option>
                                <option value="ROVER"></option>
                                <option value="ROZO"></option>
                                <option value="SACIN"></option>
                                <option value="SAIC"></option>
                                <option value="SAIC WUOPTIONNG"></option>
                                <option value="SANY"></option>
                                <option value="SCANIA"></option>
                                <option value="SEAT"></option>
                                <option value="SENKE"></option>
                                <option value="SERGOMEL"></option>
                                <option value="SERLECA"></option>
                                <option value="SERVICAR"></option>
                                <option value="SHUGUANG"></option>
                                <option value="SINGOPTIONA"></option>
                                <option value="SINOTRUK"></option>
                                <option value="SKODA"></option>
                                <option value="SKYGO"></option>
                                <option value="SPAZZIO"></option>
                                <option value="SSANGYONG"></option>
                                <option value="STAR"></option>
                                <option value="STEYR"></option>
                                <option value="STRI"></option>
                                <option value="STRICK"></option>
                                <option value="SUBARU"></option>
                                <option value="SUESCUN"></option>
                                <option value="SUKIDA"></option>
                                <option value="SUMO"></option>
                                <option value="SUZUKI"></option>
                                <option value="TALLER EUOPTIONN E HIJOS, CA"></option>
                                <option value="TALLER VALERO"></option>
                                <option value="TAMELMECA"></option>
                                <option value="TAMOI"></option>
                                <option value="TASCA"></option>
                                <option value="TATA"></option>
                                <option value="TITAN"></option>
                                <option value="TIUNA"></option>
                                <option value="TOPAZ"></option>
                                <option value="TOYOTA"></option>
                                <option value="TRANSP. Y MQ HNOS.JR"></option>
                                <option value="TRAYLERS"></option>
                                <option value="TRIUMPH"></option>
                                <option value="TS"></option>
                                <option value="TUNING"></option>
                                <option value="TYTAL"></option>
                                <option value="UM"></option>
                                <option value="UNICO"></option>
                                <option value="UNITED MOTORS"></option>
                                <option value="VANGUARD"></option>
                                <option value="VELOCE"></option>
                                <option value="VENCHI"></option>
                                <option value="VENIRAUTO"></option>
                                <option value="VENSUN"></option>
                                <option value="VENTO"></option>
                                <option value="VERUCCI"></option>
                                <option value="VESPA"></option>
                                <option value="VOLKSWAGEN"></option>
                                <option value="VOLTRAILER"></option>
                                <option value="VOLVO"></option>
                                <option value="VSTARS"></option>
                                <option value="WANGYE"></option>
                                <option value="WHITE"></option>
                                <option value="WILLYS"></option>
                                <option value="YAGUSA"></option>
                                <option value="YAMAHA"></option>
                                <option value="YAMATI"></option>
                                <option value="YAMAZAKI"></option>
                                <option value="YASUKI"></option>
                                <option value="YINGANG"></option>
                                <option value="YUEXIN"></option>
                                <option value="YUTONG BUS"></option>
                                <option value="ZHONGNENG"></option>
                                <option value="ZHONGXING"></option>
                                <option value="ZONGSHEN"></option>
                                <option value="ZOTYE"></option>
                                <option value="ZXMCO"></option>
                              </datalist>


                              <div class="row mb-3">
                                <div class="col-lg-6">
                                  <label for="modelo" class="form-label">Modelo</label>
                                  <input type="text" id="modelo" name="modelo" class="form-control">

                                </div>
                                <div class="col-lg-6">
                                  <label for="ano" class="form-label">Año</label>
                                  <input type="number" onchange="isNumberInRangeRealTime(this.value, 1020, <?php echo date('Y') + 1 ?>, 'ano')" id="ano" name="ano" class="form-control" />
                                </div>
                              </div>




                            </div>
                            <div class="col-lg-6">
                              <div class="mb-3">
                                <label for="frecuencia_cambio" class="form-label">Valor del bien</label>
                                <div class="input-group input-group-merge">
                                  <input id="valor" name="valor" type="number" class="form-control">
                                  <span class="input-group-text"> <i title="Expresado en dólares" class="bx bx-dollar"></i> </span>
                                </div>
                              </div>

                              <div class="mb-3">
                                <label for="placa" class="form-label">Placa</label>
                                <input id="placa" name="placa" class="form-control" />
                              </div>
                            </div>
                          </div>

                          <div class="col-12 d-flex justify-content-between">
                            <button type="button" class="btn btn-label-secondary btn-prev" disabled>
                              <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                              <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                            </button>
                            <button type="button" class="btn btn-primary btn-next" onclick="setView('view-2')">
                              <span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
                              <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                            </button>
                          </div>
                        </div>
                        <div id="view-2" class="view-2 content">
                          <div class="content-header mb-3">
                            <h6 class="mb-0">Detalles</h6>
                            <small>Detalles del vehículo.</small>
                          </div>
                          <div class="row g-3">



                            <div class="col-lg-6 ">
                              <div class="mb-3">
                                <label for="photo" class="form-label">Foto del vehículo</label>
                                <div class="input-group">

                                  <input type="file" class="form-control" accept=".png, .jpg, .jpeg" id="photo" onchange="vistaPreliminar(event)" name="photo[]" />



                                  <label class="input-group-text" for="photo"><i class="bx bx-upload"></i></label>

                                </div>
                              </div>


                              <div class="mb-3">
                                <label for="serial_carroceria" class="form-label">Serial de carrocería</label>
                                <input type="text" id="serial_carroceria" name="serial_carroceria" class="form-control" />
                              </div>

                              <div class="mb-3">
                                <label for="serial_motor" class="form-label">Serial de motor</label>
                                <input type="text" id="serial_motor" name="serial_motor" class="form-control" />
                              </div>



                            </div>



                            <div class="col-lg-6">





                              <div class="mb-3">
                                <label for="condicionMotor" class="form-label">Condición del motor</label>
                                <select id="condicionMotor" name="condicionMotor" class="form-control" onchange="(this.value == 'Adaptado' ? $('#motorSection').show(300) :  $('#motorSection').hide(300))">
                                  <option value="">Seleccione</option>
                                  <option value="Original">Original</option>
                                  <option value="Adaptado">Adaptado</option>
                                </select>
                              </div>


                              <div class="mb-3" id="motorSection" style="display: none;">
                                <label for="nombreMotor" class="form-label">Detalles del motor</label>
                                <input type="text" id="nombreMotor" name="nombreMotor" class="form-control" />
                              </div>



                            </div>

                            <div class="col-12 d-flex justify-content-between">
                              <button type="button" class="btn btn-primary btn-prev" onclick="setView('view-1')">
                                <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                              </button>
                              <button type="button" class="btn btn-primary btn-next" onclick="setView('view-3')">
                                <span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
                                <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                              </button>
                            </div>
                          </div>
                        </div>
                        <div id="view-3" class="view-3 content">
                          <div class="content-header mb-3">
                            <h6 class="mb-0">Fluidos</h6>
                            <small>Consumo de fluidos.</small>
                          </div>
                          <div class="row g-3">



                            <div class="col-lg-6 ">
                              <div class="mb-3">
                                <label for="tipo_combustible" class="form-label">Tipo de combustibles</label>
                                <select id="tipo_combustible" name="tipo_combustible" class="form-control">
                                  <option value="">Seleccione</option>
                                  <option value="gasolina">Gasolina</option>
                                  <option value="diésel">Diésel </option>
                                  <option value="gas">Gas </option>
                                  <option value="mixto">Gasolina y gas </option>
                                  <!-- <option value="Gas natural">Gas natural</option> -->
                                </select>
                              </div>


                              <div class="mb-3">
                                <label for="capacidad_tanque" class="form-label">Capacidad del tanque</label>
                                <input type="number" id="capacidad_tanque" name="capacidad_tanque" class="form-control" />
                              </div>



                              <div class="mb-3">
                                <label for="liga_frenos" class="form-label">Liga de frenos</label>
                                <select id="liga_frenos" name="liga_frenos" class="form-control">
                                  <option value="">Seleccione</option>
                                  <option value="Dot 3">Dot 3</option>
                                  <option value="Dot 4">Dot 4</option>
                                  <option value="Dot 5">Dot 5</option>
                                  <option value="Dot 5.1">Dot 5.1</option>
                                </select>
                              </div>


                              <div class="mb-3">
                                <label for="cantidad_liga_frenos" class="form-label">Cantidad de usada</label>
                                <select id="cantidad_liga_frenos" name="cantidad_liga_frenos" class="form-control">
                                  <option value="">Seleccione</option>
                                  <option value="500 ml">500 ml</option>
                                  <option value="1">1 L</option>
                                  <option value="2">2 L</option>
                                </select>
                              </div>
                            </div>



                            <div class="col-lg-6">


                              <div class="mb-3">
                                <label for="aceite_motor" class="form-label">Tipo de aceite de motor</label>
                                <select id="aceite_motor" name="aceite_motor" class="form-control">
                                  <option value="">Seleccione</option>
                                  <option value="0W20">0W20</option>
                                  <option value="0W30">0W30</option>
                                  <option value="0W40">0W40</option>
                                  <option value="5W20">5W20</option>
                                  <option value="5W30">5W30</option>
                                  <option value="5W10">5W10</option>
                                  <option value="5W50">5W50</option>
                                  <option value="10W30">10W30</option>
                                  <option value="10W40">10W40</option>
                                  <option value="15W40">15W40</option>
                                  <option value="15W50">15W50</option>
                                  <option value="20W20">20W20</option>
                                  <option value="20W30">20W30</option>
                                  <option value="20W40">20W40</option>
                                  <option value="20W50">20W50</option>
                                  <option value="25W50">25W50</option>
                                  <option value="25W60">25W60</option>
                                </select>
                              </div>
                              <div class="mb-3">
                                <label for="marca_aceite" class="form-label">Marca preferida</label>
                                <input type="text" id="marca_aceite" name="marca_aceite" class="form-control" />
                              </div>


                              <div class="mb-3">
                                <label for="cantidad_aceite" class="form-label">Cantidad utilizada (Litros)</label>
                                <input type="text" id="cantidad_aceite" name="cantidad_aceite" class="form-control" />
                              </div>


                              <div class="mb-3">
                                <label for="unidad_medida" class="form-label">Tipo de medida usada para el cambio de aceite</label>
                                <select id="unidad_medida" name="unidad_medida" onchange="$('#text_medida').html(this.value)" class="form-control">
                                  <option value="">Seleccione</option>
                                  <option value="viajes">Por viajes</option>
                                  <option value="kilometros">Por kilómetros</option>
                                  <option value="dias">Por dias</option>
                                </select>
                              </div>
                              <div class="mb-3">
                                <label for="frecuencia_cambio" class="form-label">Frecuencia de cambio</label>

                                <div class="input-group input-group-merge">
                                  <input type="number" class="form-control" placeholder="Frecuencia según el tipo de medida indicada" id="frecuencia_cambio" name="frecuencia_cambio">
                                  <span class="input-group-text"></span>
                                </div>

                              </div>
                            </div>

                            <div class="col-12 d-flex justify-content-between">
                              <button type="button" class="btn btn-primary btn-prev" onclick="setView('view-2')">
                                <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                              </button>
                              <button type="button" class="btn btn-primary btn-next" onclick="setView('view-4')">
                                <span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
                                <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                              </button>
                            </div>
                          </div>
                        </div>
                        <div id="view-4" class="view-4 content">
                          <div class="content-header mb-3">
                            <h6 class="mb-0">Neumáticos</h6>
                            <small>Ejes y neumáticos</small>
                          </div>
                          <div class="row mb-3">
                            <div class="col-lg-6" id="zonaVehiculos">

                              <div class="mb-3">
                                <label for="cant_ejes" class="form-label">Cantidad de ejes</label>
                                <select id="cant_ejes" name="cant_ejes" class="form-control" onchange="$('#cant_cauchos').val('');">
                                  <option value="">Seleccione</option>
                                </select>
                                <small id="detallesCamion" name="detallesCamion" style="display: none;">Remolque (R). Remolque balanceado (B). Semirremolque (S)</small>
                              </div>

                              <div class="mb-3">
                                <label for="cant_cauchos" class="form-label">Cantidad de neumático</label>
                                <input type="number" onchange="validarCantidadCauchos(this.value)" id="cant_cauchos" name="cant_cauchos" class="form-control" />
                              </div>
                              <script>
                                function validarCantidadCauchos(value) {
                                  var tipo = $('#tipo_vehiculo').val();
                                  var cant_ejes

                                  if (tipo == 'MOTOCICLETA') {
                                    cant_ejes = 1;

                                  } else {
                                    cant_ejes = $('#cant_ejes').val();
                                    if (cant_ejes == '') {
                                      toast_s('error', 'Indique una cantidad de ejes')
                                      $('#cant_cauchos').val('');
                                      return
                                    }
                                  }
                                  if (tipo == '') {
                                    toast_s('error', 'Indique un tipo de vehículo')
                                    $('#cant_cauchos').val('');
                                    return
                                  }

                                  if (tipo == 'CISTERNA' || tipo == 'TRACTOR' || tipo == 'TRAYLER') {
                                    if (cant_ejes.toString().indexOf('R') != '-1') {
                                      let rslt = cant_ejes.split('R')
                                      cant_ejes = parseInt(rslt[0]) + parseInt(rslt[1])
                                    }
                                    if (cant_ejes.toString().indexOf('S') != '-1') {
                                      let rslt = cant_ejes.split('S')
                                      cant_ejes = parseInt(rslt[0]) + parseInt(rslt[1])
                                    }
                                    if (cant_ejes.toString().indexOf('B') != '-1') {
                                      let rslt = cant_ejes.split('B')
                                      cant_ejes = parseInt(rslt[0]) + parseInt(rslt[1])
                                    }
                                  }

                                  let minCauchos = cant_ejes * 2;

                                  if (tipo == 'TRIMOVIL') {
                                    if (value % 2 === 0 || value < minCauchos) {
                                      // El número es par
                                      $('#cant_cauchos').val('');
                                      toast_s('error', 'Indique una cantidad valida')
                                    }
                                  } else {
                                    if (value % 2 != 0 || value < minCauchos) {
                                      // El número es impar
                                      $('#cant_cauchos').val('');
                                      toast_s('error', 'Indique una cantidad valida')
                                    }
                                  }
                                }













                                let ejes = ['1', '2', '3', '4', '2S1', '2S2', '2S3', '3S1', '3S2', '3S3', '2R2', '3R2', '4R2', '2R3', '3R3', '4R3', '4R4', '2B1', '2B3', '3B1', '3B2', '3B3', '4B1', '4B2', '4B3']

                                let ejes_vehiculos = {
                                  'AMBULANCIA': 2,
                                  'ARRASTRE': 3,
                                  'AUTOBUS': 4,
                                  'BATEA': 4,
                                  'BOMBEADOR DE CONCRETO': 4,
                                  'CABINA': 4,
                                  'CAMION TRACTOR': 4,
                                  'CASILLERO': 3,
                                  'CAVA': 4,
                                  'CAVA/GRANEL': 3,
                                  'CESTA': 4,
                                  'CHUTO': 4,
                                  'CISTERNA': 24,
                                  'ESPECIAL': 4,
                                  'ESTACA/BARANDA': 3,
                                  'ESTACAS': 3,
                                  'MINIBUS': 2,
                                  'MINIVAN': 2,
                                  'MONTA CARGA': 1,
                                  'MOTOCICLETA': 1,
                                  'PICK-UP': 1,
                                  'PICK-UP C/CABINA': 1,
                                  'PICK-UP D/CABINA': 1,
                                  'PICK-UP/BARANDA': 1,
                                  'PICK-UP/BARANDA/HIERRO': 1,
                                  'PICK-UP/C CABINA': 1,
                                  'PICK-UP/C FURGON': 1,
                                  'PLATABANDA': 1,
                                  'SEDAN': 1,
                                  'TECHO DE LONA': 1,
                                  'TECHO DURO': 1,
                                  'TRACTOR': 24,
                                  'TRAYLER': 24,
                                  'TRIMOVIL': 1,
                                  'VACUUM': 4,
                                  'VAN': 1,
                                  'VOLTEO': 2,
                                }


                                function setEjes(value) {
                                  $('#cant_ejes').html('<option value="">Seleccione</option>')

                                  for (let index = 0; index < ejes_vehiculos[value]; index++) {
                                    let element = ejes[index];
                                    $('#cant_ejes').append('<option value="' + element + '">' + element + '</option>')
                                  }

                                  if (value == 'MOTOCICLETA') {
                                    $('#cant_cauchos').val('2');
                                    $("#cant_ejes" + " option[value='1']").attr("selected", true);
                                    $('#zonaVehiculos').hide()
                                  } else {
                                    $('#zonaVehiculos').show()
                                    $("#cant_ejes" + " option[value='']").attr("selected", true);
                                    $('#cant_cauchos').val('');

                                  }

                                  if (value == 'Camión') {
                                    $('#detallesCamion').show()
                                  } else {
                                    $('#detallesCamion').hide()
                                  }
                                }
                              </script>





                            </div>
                            <div class="col-lg-6">



                              <div class="mb-3">
                                <label for="cant_ejes" class="form-label">Medida del neumático</label>

                                <div class="input-group">
                                  <input type="number" id="ancho" name="ancho" placeholder="285 (Ancho)" type="number" class="form-control">
                                  <span class="input-group-text">/</span>
                                  <input type="number" id="perfil" name="perfil" placeholder="80 (Perfil)" type="number" class="form-control">
                                  <span class="input-group-text">R</span>
                                  <input type="number" id="radial" name="radial" placeholder="22.5 (Radial)" type="number" class="form-control">
                                </div>
                              </div>




                              <div class="mb-3">
                                <label for="indice_carga" class="form-label">Indice de carga</label>
                                <div class="input-group ">
                                  <input id="indice_carga" name="indice_carga" placeholder="Indice de carga" type="number" class="form-control">
                                  <span onclick="verInfo('indice_carga')" class="input-group-text cursor-pointer"><i class="bx bx-info-circle"></i></span>
                                </div>
                              </div>
                              <div class="mb-3">
                                <label for="indice_velocidad" class="form-label">Indice de velocidad</label>
                                <div class="input-group ">
                                  <select id="indice_velocidad" name="indice_velocidad" class="form-control">
                                    <option value="">Seleccione</option>
                                    <option value="A1">A1</option>
                                    <option value="A2">A2</option>
                                    <option value="A3">A3</option>
                                    <option value="A4">A4</option>
                                    <option value="A5">A5</option>
                                    <option value="A6">A6</option>
                                    <option value="A7">A7</option>
                                    <option value="A8">A8</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                    <option value="G">G</option>
                                    <option value="J">J</option>
                                    <option value="K">K</option>
                                    <option value="L">L</option>
                                    <option value="M">M</option>
                                    <option value="N">N</option>
                                    <option value="P">P</option>
                                    <option value="Q">Q</option>
                                    <option value="R">R</option>
                                    <option value="S">S</option>
                                    <option value="T">T</option>
                                    <option value="U">U</option>
                                    <option value="H">H</option>
                                    <option value="V">V</option>
                                    <option value="ZR">ZR</option>
                                    <option value="W">W</option>
                                    <option value="Y">Y</option>
                                  </select>
                                  <span onclick="verInfo('indice_velocidad')" class="input-group-text cursor-pointer"><i class="bx bx-info-circle"></i></span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-12 d-flex justify-content-between">
                            <button type="button" class="btn btn-primary btn-prev" onclick="setView('view-3')">
                              <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                              <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                            </button>
                            <butto type="button" n class="btn btn-primary btn-next" onclick="setView('view-5')">
                              <span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
                              <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                            </butto>
                          </div>
                        </div>
                        <div id="view-5" class="view-5 content">
                          <div class="content-header mb-3">
                            <h6 class="mb-0">Operatividad</h6>
                            <small>Estado operativo</small>
                          </div>
                          <div class="row mb-3">


                            <div class="col-lg-6">



                              <div class="mb-3">
                                <label for="operativo" class="form-label">¿El vehículo tiene alguna falla? </label>
                                <select id="operativo" name="operativo" onchange="this.value == 'Si' ? $('.sect_vehiculo_danado').show(300):$('.sect_vehiculo_danado').hide(30)" class="form-control">
                                  <option value="">Seleccione</option>
                                  <option value="Si">Si</option>
                                  <option value="No">No</option>
                                </select>
                              </div>






                              <section class="sect_vehiculo_danado" style="display: none;">


                                <div class="mb-3">
                                  <label for="operativo_real" class="form-label">¿La falla impide la operatividad del vehiculo? </label>
                                  <select id="operativo_real" name="operativo_real" class="form-control">
                                    <option value="">Seleccione</option>
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                  </select>
                                </div>



                                <div class="mb-3">
                                  <label for="tipo" class="form-label">Descripción de la falla</label>
                                  <div class="input-group input-group-merge speech-to-text">
                                    <textarea onkeyup="max_caracteres(this.value, 'res_car_descripcion', 'descripcion_falla', 250)" class="form-control" placeholder="Describa la falla" rows="2" id="descripcion_falla" name="descripcion_falla"></textarea>
                                    <span class="input-group-text" id="res_car_descripcion">
                                      250
                                    </span>
                                  </div>
                                </div>


                                <div class="mb-3">
                                  <label for="mano_obra" class="form-label">Costo de la mano de obra</label>
                                  <input type="number" id="mano_obra" name="mano_obra" class="form-control" placeholder="Mano de obra">
                                </div>

                              </section>

                            </div>


                            <div class="col-lg-6">

                              <section class="sect_vehiculo_danado" style="display: none;">


                                <div class="row">
                                  <div class="col-lg-6">



                                    <div class="mb-3">

                                      <label for="categoria_repuesto_r" class="form-label">Categoría</label>


                                      <div class="input-group">
                                        <select id="categoria_repuesto_r" name="categoria_repuesto_r" class="form-control" onchange="set_repuestos(this.value, 'respuesto')">

                                        </select>
                                        <span class="input-group-text pointer" onclick="addCategoria('categoria_repuesto_r')"><i class="bx bx-plus"></i></span>
                                      </div>





                                    </div>

                                  </div>
                                  <div class="col-lg-6">
                                    <label for="tipo" class="form-label">Repuesto</label>



                                    <div class="input-group">
                                      <select id="respuesto" name="respuesto" class="form-control">
                                        <option value="">Seleccione</option>
                                      </select>
                                      <span class="input-group-text pointer" onclick="addReouesto(this.value, 'respuesto')"><i class="bx bx-plus"></i></span>
                                    </div>


                                  </div>
                                </div>

                                <div class="row">

                                  <div class="mb-3 col-lg-6">
                                    <label for="costo" class="form-label">Precio unitario del repuesto</label>
                                    <div class="input-group ">
                                      <input id="costo" name="costo" placeholder="Precio" type="number" class="form-control">
                                      <span class="input-group-text cursor-pointer"><i title="Expresado en dólares" class="bx bx-dollar"></i></span>
                                    </div>
                                  </div>

                                  <div class="mb-3 col-lg-6">
                                    <label class="form-label">Cantidad</label>
                                    <input type="number" id="cantidad" name="cantidad" value="1" class="form-control" placeholder="Cantidad">
                                  </div>
                                </div>


                                <div class="text-end">
                                  <button type="button" onclick="addProducGroup()" type="button" class="btn btn-primary"> Agregar </button>
                                </div>



                                <div class="mb-3 mt-3">

                                  <small class="text-light fw-medium">Lista de repuestos</small>
                                  <div class="demo-inline-spacing">
                                    <div class="list-group mt-3" id="listInsumos">
                                    </div>
                                  </div>
                                </div>
                              </section>
                            </div>
                          </div>
                          <div class="col-12 d-flex justify-content-between">
                            <button type="button" class="btn btn-primary btn-prev" onclick="setView('view-4')">
                              <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                              <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                            </button>
                            <button type="submit" class="btn btn-success btn-next"> <!--  onclick="guardarVehiculo()" -->
                              <span class="align-middle d-sm-inline-block d-none me-sm-1">Finalizar</span>
                              <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card" id="tablaSection">
                <div class="card-header d-flex justify-content-between">
                  <h5>Vehículos</h5>
                  <button class="btn btn-secondary add-new btn-primary ms-2" type="button" onclick="nuevoVehiculoSection()"><span><i class="bx bx-plus me-0 me-sm-1"></i>Agregar vehículo</span></button>
                </div>
                <div class="card-body">
                  <div class="card-datatable table-responsive">
                    <div class="dataTables_wrapper dt-bootstrap5 no-footer">
                      <div class="table-responsive">
                        <table class="dt-route-vehicles table dataTable no-footer dtr-column">
                          <thead class="border-top">
                            <tr>
                              <th>Vehículo</th>
                              <th>Tipo</th>
                              <th>Placa</th>
                              <th>Operatividad</th>
                              <th class="text-center" title="Información del vehículo">Información</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody id="tbodyTable"></tbody>
                        </table>
                      </div>
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
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Nuevo Grupo/Categoría</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="col-lg-2">
                  <button type="button" class="btn btn-outline-primary btn-vista w-100 mb-2" onclick="setVista('v1')" id="v1">Categoría</button>
                  <button type="button" class="btn btn-primary btn-vista w-100 mb-2" onclick="setVista('v2')" id="v2">Repuesto</button>
                </div>
                <div class="col-lg-10">

                  <div class="vista v1 animated fadeIn" id="categoria_section" style="display: none;">
                    <h5 class="mb-0">Nueva categoría</h5>
                    <small class="text-muted">Categoría de repuestos</small>
                    <div class="mt-3">
                      <label for="categoria_repuesto" class="form-label">Nombre de la categoría</label>
                      <input type="text" id="categoria_repuesto" class="form-control" placeholder="Nombre de la categoría">
                    </div>

                    <div class="mt-3 text-end">
                      <button class="btn btn-primary" onclick="nuevaCategoria()">Guardar</button>
                    </div>
                  </div>

                  <div class="vista v2 animated fadeIn" id="repuesto_section">
                    <h5 class="mb-0">Nuevo repuesto</h5>
                    <small class="text-muted">Registro de repuestos</small>

                    <div class="mt-3">
                      <label for="categoria_nuevo_repuesto" class="form-label">Categoría</label>
                      <select id="categoria_nuevo_repuesto" class="form-control" onchange="set_repuestos(this.value, 'nuevo_repuesto')">

                      </select>
                    </div>

                    <div class="mt-3">
                      <label for="nuevo_repuesto" class="form-label">Repuesto</label>
                      <input type="text" id="nuevo_repuesto" class="form-control" placeholder="Nombre del repuesto">
                    </div>

                    <div class="mt-3 text-end">
                      <button class="btn btn-primary" onclick="nuevoRepuesto()">Guardar</button>
                    </div>



                  </div>

                </div>
              </div>












            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>




    </div>
    <!-- tipo
 / Layout page -->
  </div>



  <div class="modal fade" id="modal_repuestos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Reporte de fallas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-lg-6">


              <div class="mb-3">
                <label for="tipo" class="form-label">Descripción de la falla</label>
                <div class="input-group input-group-merge speech-to-text">
                  <textarea onkeyup="max_caracteres(this.value, 'res_car_descripcion2', 'descripcion_falla2', 250)" class="form-control" placeholder="Describa la falla" rows="4" id="descripcion_falla2"></textarea>
                  <span class="input-group-text" id="res_car_descripcion2">
                    250
                  </span>
                </div>
              </div>



              <div class="mb-3">
                <label for="operativo_real2" class="form-label">¿La falla impide la operatividad del vehiculo? </label>
                <select id="operativo_real2" name="operativo_real2" class="form-control">
                  <option value="">Seleccione</option>
                  <option value="Si">Si</option>
                  <option value="No">No</option>
                </select>
              </div>


              <div class="mb-3">
                <label for="mano_obra2" class="form-label">Costo de la mano de obra</label>
                <input type="number" id="mano_obra2" class="form-control" placeholder="Mano de obra">
              </div>



            </div>
            <div class="col-lg-6">





              <div class="row">
                <div class="col-lg-6 mb-3">
                  <label for="categoria_repuesto_2" class="form-label">Categoría</label>
                  <div class="input-group">
                    <select id="categoria_repuesto_2" name="categoria_repuesto_2" class="form-control" onchange="set_repuestos(this.value, 'respuesto_2')">
                    </select>
                    <span class="input-group-text pointer" onclick="addCategoria('categoria_repuesto_2')"><i class="bx bx-plus"></i></span>
                  </div>



                </div>
                <div class="mb-3 col-lg-6">
                  <label for="respuesto_2" class="form-label">Repuesto</label>

                  <div class="input-group">
                    <select id="respuesto_2" name="respuesto_2" class="form-control">
                      <option value="">Seleccione</option>
                    </select>
                    <span class="input-group-text pointer" onclick="addReouesto(this.value, 'respuesto_2')"><i class="bx bx-plus"></i></span>
                  </div>



                </div>


              </div>


              <div class="row">


                <div class="mb-3 col-lg-6">
                  <label for="costo2" class="form-label">Precio unitario del repuesto</label>
                  <div class="input-group ">
                    <input id="costo2" placeholder="Precio" type="number" class="form-control">
                    <span class="input-group-text cursor-pointer"><i title="Expresado en dólares" class="bx bx-dollar"></i></span>
                  </div>
                </div>


                <div class="mb-3 col-lg-6">
                  <label class="form-label" for="cantidad_2">Cantidad</label>
                  <input type="number" id="cantidad_2" class="form-control" placeholder="Cantidad">
                </div>
              </div>





              <div class="text-end">
                <button onclick="addProducGroup_2()" type="button" class="btn btn-primary"> Agregar </button>
              </div>




              <div class="mb-3 mt-3">

                <small class="text-light fw-medium">Lista de repuestos</small>
                <div class="demo-inline-spacing">
                  <div class="list-group mt-3" id="listInsumos2">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="report_falla()">Aceptar</button>
        </div>
      </div>
    </div>
  </div>




















  <div class="modal fade" id="modal_info" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="titulomodal"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <p id="texto" class="mb-3 text-center"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
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
  function verInfo(info) {
    let titulo
    let texto
    let informacion

    switch (info) {
      case 'indice_carga':
        titulo = 'Indice de carga del neumático'
        texto = 'Se refiere a la capacidad máxima de carga del neumático.<br> <strong>Indices de carga:</strong><br><br><img style="    filter: hue-rotate(160deg);opacity: 0.6;" src="../../assets/img/illustrations/carga.png" alt="tabla indices">'
        break;
      case 'indice_velocidad':
        titulo = 'Indice de velocidad del neumático'
        texto = 'Se refiere a la velocidad máxima soportada por el neumático.<br> <strong>Indices de velocidad:</strong><br><br><img style="filter: hue-rotate(160deg);opacity: 0.6;" src="../../assets/img/illustrations/velocidad.png" alt="tabla indices">'
        break;
    }

    $('#texto').html(texto)
    $('#titulomodal').html(titulo)
    $('#modal_info').modal('show')
  }

  var campo = ''
  var campo_Ca = ''
  var modal = ''
  var modal_Ca = ''


  function addReouesto(value, value2) {
    setVista('v2')
    $('#modalCenter').modal('toggle')
    $('#modal_repuestos').modal('hide')


    campo = value2
    if (value2 == 'respuesto_2') {
      modal = 'modal_repuestos'
      $("#categoria_nuevo_repuesto" + " option[value='" + $('#categoria_repuesto_2').val() + "']").attr("selected", true);
    } else {
      modal = ''
      $("#categoria_nuevo_repuesto" + " option[value='" + $('#categoria_nuevo_repuesto').val() + "']").attr("selected", true);
    }
  }

  function addCategoria(campo) {
    $('#modalCenter').modal('toggle')
    $('#modal_repuestos').modal('hide')
    campo_Ca = campo
    setVista('v1')


    if (campo_Ca == 'categoria_repuesto_2') {
      modal_Ca = 'modal_repuestos'
      $("#categoria_nuevo_repuesto" + " option[value='" + $('#categoria_repuesto_2').val() + "']").attr("selected", true);
    } else {
      modal_Ca = ''
      $("#categoria_nuevo_repuesto" + " option[value='" + $('#categoria_repuesto_r').val() + "']").attr("selected", true);
    }
  }

  function setVista(value) {
    $('.vista').hide();
    $('.' + value).show();
    $('.btn-vista').removeClass('btn-primary');
    $('#' + value).removeClass('btn-outline-primary');
    $('#' + value).addClass('btn-primary');
  }

  var r_f

  function re_falla(id) {
    r_f = id
    $('#modal_repuestos').modal('toggle');
  }

  function eliminar(id) {
    Swal.fire({
      title: "¿Esta seguro?",
      icon: "warning",
      html: `Se <strong>eliminará</strong> el vehículo. La acción es irreversible.`,
      confirmButtonColor: "#69a5ff",
      cancelButtonText: `Cancelar`,
      showCancelButton: true,
      confirmButtonText: "Eliminar",
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        $('.container-loader').show()
        $.get("../../back/ajax/veh_vehiculo.php", "v=3&i=" + id, function(data) {
          $('.container-loader').hide()
          toast_s('success', 'Eliminado correctamente')
          location.reload();
        });
      }
    });
  }

  function nuevoVehiculoSection() {
    $('#nuevoVehiculoSec').toggle();
    $('#tablaSection').toggle();
  }

  function setView(view) {
    $('.content').removeClass('active')
    $('.' + view).addClass('active')

    $('.bs-stepper-circle').removeClass('active_2')
    $('#' + view + '_1').addClass('active_2')
  } // cambiar campos grupos

  function getName(id) {
    return nombreRepuestos[id]
  }

  var array_insumos = [];

  function addProducGroup() {
    let respuesto = $('#respuesto').val();
    let cantidad = $('#cantidad').val();
    let costo = $('#costo').val();

    if (respuesto == '' || cantidad == '' || costo == '') {
      toast_s('error', 'Campos vacios');
      return
    }
    if (cantidad < 1) {
      toast_s('error', 'Indique una cantidad valida');
      return
    }
    if (costo < 1) {
      toast_s('error', 'Indique un precio real');
      return
    }

    let name = getName(respuesto);

    array_insumos[respuesto] = [respuesto, cantidad, name, costo]
    toast_s('success', 'Agregado correctamente')
    enlistarInsumos()

    $("#categoria_repuesto_r" + " option[value='']").attr("selected", true);
    $("#respuesto" + " option[value='']").attr("selected", true);
    $('#cantidad').val('');
    $('#costo').val('');
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
                                    <span class="badge badge-center bg-label-secondary me-2">` + array_insumos[clave][1] + `</span>  
                                      <div class="list-content">
                                        <h6 class="mb-1">` + array_insumos[clave][2] + `</h6>
                                      </div>
                                    </div>
                                    <i class="bx bx-trash pointer" onclick="quitarInsumo('` + array_insumos[clave][0] + `')"></i>
                                  </div>`)
    }
  }

  var array_insumos2 = [];

  function addProducGroup_2() {
    let respuesto = $('#respuesto_2').val();
    let cantidad = $('#cantidad_2').val();
    let costo2 = $('#costo2').val();

    if (respuesto == '' || cantidad == '' || costo2 == '') {
      toast_s('error', 'Campos vacios');
      return
    }
    if (cantidad < 1) {
      toast_s('error', 'Indique una cantidad valida');
      return
    }
    if (costo2 < 1) {
      toast_s('error', 'Indique un precio real');
      return
    }
    let name = getName(respuesto);

    array_insumos2[respuesto] = [respuesto, cantidad, name, costo2]
    toast_s('success', 'Agregado correctamente')
    enlistarInsumos2()


    $('#respuesto_2').val('');
    $('#cantidad_2').val('');
    $('#costo2').val('');
    $("#respuesto_2" + " option[value='']").attr("selected", true);
    $("#categoria_repuesto_2" + " option[value='']").attr("selected", true);

  }

  function quitarInsumo2(id) {
    delete array_insumos2[id];
    toast_s('success', 'Eliminado correctamente')
    enlistarInsumos2()
  }

  function enlistarInsumos2() {
    $('#listInsumos2').html('')

    let claves = Object.keys(array_insumos2);
    for (let i = 0; i < claves.length; i++) {
      let clave = claves[i];
      $('#listInsumos2').append(`<div class="list-group-item list-group-item-action d-flex justify-content-between">
                                    <div class="li-wrapper d-flex justify-content-start align-items-center">
                                    <span class="badge badge-center bg-label-secondary me-2">` + array_insumos2[clave][1] + `</span>  
                                      <div class="list-content">
                                        <h6 class="mb-1">` + array_insumos2[clave][2] + `</h6>
                                      </div>
                                    </div>
                                    <i class="bx bx-trash pointer" onclick="quitarInsumo2('` + array_insumos2[clave][0] + `')"></i>
                                  </div>`)
    }
  }

  function report_falla() {
    let vehiculo = r_f
    let falla = $('#descripcion_falla2').val();
    let operativo_real2 = $('#operativo_real2').val();
    let mano_obra2 = $('#mano_obra2').val();



    if (checkField('operativo_real2', 'Operatividad del vehículo') == false) {
      return
    }

    if (checkField('mano_obra2', 'Mano de obra') == false) {
      return
    }

    if (checkField('descripcion_falla2', 'Descripción de la falla') == false) {
      return
    }

    if (mano_obra2 < 0) {
      toast_s('error', 'El costo de la mano de obra no es correcto')
      return
    }

    let insumos;

    let claves_insumos = Object.keys(array_insumos2)
    for (let index = 0; index < claves_insumos.length; index++) {
      let element = array_insumos2[claves_insumos[index]];
      insumos += element[0] + '~' + element[1] + '~' + element[2] + '~' + element[3] + ';';
    }
    $('.container-loader').show()


    $.ajax({
      type: 'POST',
      url: '../../back/ajax/veh_reporte_falla.php',
      dataType: 'html',
      data: {
        vehiculo: vehiculo,
        falla: falla,
        insumos: insumos,
        operativo_real2: operativo_real2,
        mano_obra2: mano_obra2
      },
      cache: false,
      success: function(msg) {
        $('.container-loader').hide()
        tabla()
        $('#modal_repuestos').modal('hide');
        $('#listInsumos2').html('')
        $('#descripcion_falla2').val('')
        $('#operativo_real2').val('')
        $('#mano_obra2').val('')



        array_insumos2 = [];

        toast_s('success', 'Se agrego correctamente')

      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      $(".container-loader").hide();

      toast_s('warning', 'Ocurrió un error, inténtelo nuevamente ' + errorThrown)
    });

  }

  $(document).ready(function(e) {
    $("#formElem").on('submit', function(e) {
      e.preventDefault();

      let formData = new FormData(this);
      var insumos = ''
      let claves_insumos = Object.keys(array_insumos)
      for (let index = 0; index < claves_insumos.length; index++) {
        let element = array_insumos[claves_insumos[index]];
        insumos += element[0] + '~' + element[1] + '~' + element[3] + ';';
      }

      formData.append('insumos', insumos);

      if ($('#operativo').val() == 'Si') {

        if (checkField('descripcion_falla', 'Descripción de la falla') == false) {
          return
        }

        if (checkField('mano_obra', 'Costo de la mano de obra') == false) {
          return
        }

        if ($('#mano_obra').val() < 0) {
          toast_s('error', 'El costo de la mano de obra no es correcto')
          return
        }

        if (checkField('operativo_real', 'Operatividad del vehículo') == false) {
          return
        }
      }

      if (checkField('cant_ejes', 'Cantidad de ejes') == false) {
        return;
      }
      if (checkField('tipo_vehiculo', 'Tipo de vehículo') == false) {
        return;
      }
      if (checkField('marca', 'Marca del vehículo') == false) {
        return;
      }
      if (checkField('modelo', 'Modelo') == false) {
        return;
      }
      if (checkField('valor', 'Valor de bien') == false) {
        return;
      }
      if (checkField('placa', 'Placa del vehículo') == false) {
        return;
      }
      if (checkField('ano', 'Año del vehículo') == false) {
        return;
      }
      if (checkField('tipo_combustible', 'Tipo de combustible') == false) {
        return;
      }
      if (checkField('capacidad_tanque', 'Capacidad del tanque') == false) {
        return;
      }
      if (checkField('liga_frenos', 'Liga de frenos') == false) {
        return;
      }
      if (checkField('cantidad_liga_frenos', 'Cantidad de liga de frenos') == false) {
        return;
      }
      if (checkField('aceite_motor', 'Aceite de motor') == false) {
        return;
      }
      if (checkField('marca_aceite', 'Marca de aceite preferida') == false) {
        return;
      }
      if (checkField('cantidad_aceite', 'Cantidad de aceite de motor') == false) {
        return;
      }
      if (checkField('unidad_medida', 'Unidad de medida para el cambio de aceite') == false) {
        return;
      }
      if (checkField('frecuencia_cambio', 'Frecuencia de cambio de aceite') == false) {
        return;
      }
      if (checkField('cant_cauchos', 'Cantidad de cauchos') == false) {
        return;
      }
      if (checkField('ancho', 'Ancho del caucho') == false) {
        return;
      }
      if (checkField('perfil', 'Perfil del caucho') == false) {
        return;
      }
      if (checkField('radial', 'Radial del caucho') == false) {
        return;
      }
      if (checkField('indice_carga', 'Indice de carga') == false) {
        return;
      }
      if (checkField('indice_velocidad', 'Indice de velocidad') == false) {
        return;
      }
      if (checkField('operativo', 'Fallas del vehículo') == false) {
        return;
      }
      if (checkField('serial_carroceria', 'Serial de carrocería') == false) {
        return;
      }
      if (checkField('serial_motor', 'Serial del motor') == false) {
        return;
      }
      if (checkField('condicionMotor', 'Condición del motor') == false) {
        return;
      }
      if ($('#condicionMotor').val() == 'Adaptado') {
        if (checkField('nombreMotor', 'Detalles del motor') == false) {
          return;
        }
      }
      if (isNumberInRange($('#valor').val(), 900, 500000) == false) {
        toast_s('error', 'Valor del bien incorrecto');
        return;
      }
      if (isNumberInRange($('#ano').val(), 1970, 2026) == false) {
        toast_s('error', 'Año del vehículo incorrecto');
        return;
      }
      if (isNumberInRange($('#capacidad_tanque').val(), 3, 800) == false) {
        toast_s('error', 'Capacidad del tanque incorrecta');
        return;
      }
      if (isNumberInRange($('#cantidad_aceite').val(), 1, 50) == false) {
        toast_s('error', 'Cantidad de aceite incorrecta');
        return;
      }
      if (isNumberInRange($('#frecuencia_cambio').val(), 1, 30000) == false) {
        toast_s('error', 'Frecuencia de cambio incorrecta');
        return;
      }
      if (isNumberInRange($('#cant_cauchos').val(), 2, 30) == false) {
        toast_s('error', 'Cantidad de caucho incorrecta');
        return;
      }
      if (isNumberInRange($('#indice_carga').val(), 20, 120) == false) {
        toast_s('error', 'Indice de carga incorrecta');
        return;
      }

      $('button').attr('disabled', true);
      $(".container-loader").show();

      $.ajax({
        type: 'POST',
        url: '../../back/ajax/veh_nuevoVehiculo.php',
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function(msg) {

          $('button').attr('disabled', false);
          $(".container-loader").hide();

          if (msg.trim() == 'ye') {
            toast_s('error', 'el vehículo ya existe')
            return;
          } else if (msg.trim() == 'ok') {


            nuevoVehiculoSection()
            tabla()
            $('#listInsumos').html('')
            array_insumos = [];
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




    })
  });


  function nuevoRepuesto() {
    let categoria_nuevo_repuesto = $('#categoria_nuevo_repuesto').val()
    let repuesto = $('#nuevo_repuesto').val()

    //registra, agrega el item al select repuesto y cierra el modal
    // registra y actualiza las categorias del otro apartado (sin cerrar el modal)
    $('.container-loader').show()
    $.get("../../back/ajax/veh_vehiculos_categorias_repuestos.php", "a=rr&c=" + categoria_nuevo_repuesto + "&r=" + repuesto, function(data) {
      nombreRepuestos[data.trim()] = repuesto;
      toast_s('success', 'Registrado correctamente')
      $('#modalCenter').modal('hide')

      if (modal == 'modal_repuestos') {
        set_repuestos($('#categoria_repuesto_2').val(), 'respuesto_2', data.trim())
        $('#modal_repuestos').modal('show')
      } else {
        set_repuestos($('#categoria_nuevo_repuesto').val(), 'respuesto', data.trim())
      }

      $('.container-loader').hide()


    });
  }

  function set_repuestos(value, campo, valor1 = null) {
    $('.container-loader').show()
    $.get("../../back/ajax/veh_vehiculos_categorias_repuestos.php", "a=cr&c=" + value, function(data) {
      $('#' + campo).html(data)
      if (valor1 != null) {
        $("#" + campo + " option[value='" + valor1 + "']").attr("selected", true);
      }
      $('.container-loader').hide()
    });
  }

  function tabla() {
    $.get("../../back/ajax/veh_lista.php", "", function(data) {
      $('#tbodyTable').html(data)
    });
  }
  tabla()








  function nuevaCategoria() {
    let categoria_nombre = $('#categoria_repuesto').val();
    // registra y actualiza las categorias del otro apartado (sin cerrar el modal)
    $('.container-loader').show()
    $.get("../../back/ajax/veh_vehiculos_categorias_repuestos.php", "a=rc&c=" + categoria_nombre, function(data) {
      $('#categoria_nuevo_repuesto').html(data)
      toast_s('success', 'Registrado correctamente')
      $('#categoria_repuesto').val('')
      $('#modalCenter').modal('toggle')



      if (modal_Ca == 'modal_repuestos') {
        set_categorias('categoria_repuesto_2', data.trim())
        $('#modal_repuestos').modal('show')
      } else {
        set_categorias('categoria_repuesto_r', data.trim())
      }

      $('.container-loader').hide()



    });
  }


  function set_categorias(campo = null, valor = null) {
    $('.container-loader').show()
    $.get("../../back/ajax/veh_vehiculos_categorias_repuestos.php", "a=cc", function(data) {
      $('#categoria_repuesto_r').html(data)
      $('#categoria_repuesto_2').html(data)
      $('#categoria_nuevo_repuesto').html(data)

      if (campo) {
        $("#" + campo + " option[value='" + valor + "']").attr("selected", true);
      }
      $('.container-loader').hide()
    });
  }

  set_categorias()
</script>

</html>