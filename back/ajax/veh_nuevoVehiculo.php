<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"]) {

  $tipo_vehiculo = $_POST["tipo_vehiculo"];
  $marca = $_POST["marca"];
  $modelo = $_POST["modelo"];
  $ano = $_POST["ano"];
  $valor = $_POST["valor"];
  $tipo_combustible = $_POST["tipo_combustible"];
  $capacidad_tanque = $_POST["capacidad_tanque"];
  $liga_frenos = $_POST["liga_frenos"];
  $cantidad_liga_frenos = $_POST["cantidad_liga_frenos"];
  $aceite_motor = $_POST["aceite_motor"];
  $marca_aceite = $_POST["marca_aceite"];
  $cantidad_aceite = $_POST["cantidad_aceite"];
  $unidad_medida = $_POST["unidad_medida"];
  $frecuencia_cambio = $_POST["frecuencia_cambio"];
  $cant_ejes = $_POST["cant_ejes"];
  $cant_cauchos = $_POST["cant_cauchos"];
  $ancho = $_POST["ancho"];
  $perfil = $_POST["perfil"];
  $radial = $_POST["radial"];
  $indice_carga = $_POST["indice_carga"];
  $indice_velocidad = $_POST["indice_velocidad"];
  $falla = $_POST["operativo"];
  $descripcion_falla = $_POST["descripcion_falla"];
  $empresa_id = $_SESSION["u_ente_id"];
  $placa = $_POST["placa"];
  $serial_carroceria = $_POST["serial_carroceria"];
  $serial_motor = $_POST["serial_motor"];
  $condicionMotor = $_POST["condicionMotor"];
  $nombreMotor = $_POST["nombreMotor"];
  $operativo_real = $_POST["operativo_real"];

  $insumos = str_replace('undefined', '', $_POST["insumos"]);



  $stmt = mysqli_prepare($conexion, "SELECT * FROM `veh_vehiculos` WHERE placa = ?");
  $stmt->bind_param('s', $placa);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
   echo 'ye';
    exit();
  }
  $stmt->close();




  $stmt_o = $conexion->prepare("INSERT INTO veh_vehiculos (tipo_vehiculo, marca, modelo, ano, placa, valor, tipo_combustible, capacidad_tanque, liga_frenos, cantidad_liga_frenos, aceite_motor, marca_aceite, cantidad_aceite, unidad_medida, frecuencia_cambio, cant_ejes, cant_cauchos, ancho, perfil, radial, indice_carga, indice_velocidad, empresa_id, serial_carroceria, serial_motor, condicionMotor, nombreMotor) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt_o->bind_param("sssssssssssssssssssssssssss", $tipo_vehiculo, $marca, $modelo, $ano, $placa, $valor, $tipo_combustible, $capacidad_tanque, $liga_frenos, $cantidad_liga_frenos, $aceite_motor, $marca_aceite, $cantidad_aceite, $unidad_medida, $frecuencia_cambio, $cant_ejes, $cant_cauchos, $ancho, $perfil, $radial, $indice_carga, $indice_velocidad, $empresa_id, $serial_carroceria, $serial_motor, $condicionMotor, $nombreMotor);
  $stmt_o->execute();



  if ($stmt_o) {
    echo "ok";
    $id_v = $conexion->insert_id;


    user_activity(2, 'Registró un nuevo vehículo');
    
    if ($falla == 'Si') {


      if ($operativo_real == 'Si') {
        $operativo_real = 2;
      }else{
        $operativo_real = 1;
      }


      $stmt_o = $conexion->prepare("INSERT INTO veh_reporte_fallas (vehiculo, falla, gravedad) VALUES (?, ?, ?)");
      $stmt_o->bind_param("sss", $id_v, $descripcion_falla, $operativo_real);
      $stmt_o->execute();
    
      if ($stmt_o) {
        $id_r = $conexion->insert_id;
        if ($insumos != '') {
          $stmt_insumos = $conexion->prepare("INSERT INTO veh_repuestos (repuesto, cantidad, falla_id, empresa_id, precio) VALUES (?, ?, ?, ?, ?)");
          $insumos = substr($insumos, 0, -1);
          $insumos = explode(';', $insumos);
          foreach ($insumos as $items) {
            $item = explode('~', $items);
            $stmt_insumos->bind_param("sssss", $item[0], $item[1], $id_r, $empresa_id, $item[2]);
            $stmt_insumos->execute();
            if (!$stmt_insumos) {
              echo 'error: condicio...';
            }
          }
        }
      }
      $stmt_insumos->close();


      $costo_mano_obra = $_POST["mano_obra"];


      $stmt_obra = $conexion->prepare("INSERT INTO veh_repuestos (repuesto, cantidad, falla_id, empresa_id, precio, tipo) VALUES ('0', '1', ?, ?, ?, '2')");
      $stmt_obra->bind_param("sss", $id_r, $empresa_id, $costo_mano_obra);
      $stmt_obra->execute();
      $stmt_obra->close();







  }


















  function cargarArchivo($archivo, $folder)    {
    global $id_v;
    $nam = $id_v;
    $dir = opendir($folder); //Abrimos el directorio de destino
    //Como el elemento es un arreglos utilizamos foreach para extraer todos los valores
    foreach ($_FILES[$archivo]['tmp_name'] as $key => $tmp_name) {
      //Validamos que el archivo exista
      if ($_FILES[$archivo]["name"][$key]) {
        $source = $_FILES[$archivo]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo

        $target_path = $folder . '/' .$nam . '.png'; //Indicamos la ruta de destino, así como el nombre del archivo
        move_uploaded_file($source, $target_path);  //	echo 'ok. ';
      }
    }
    closedir($dir); //Cerramos el directorio de destino

  }

  cargarArchivo('photo', '../../assets/img/vehiculos');









  }
} else {
  header("Location: ../../public/index.php");
}
