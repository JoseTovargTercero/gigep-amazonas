<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"]) {

  $id = $_POST["id"];

  function cargarArchivo($archivo, $folder)    {
    global $id;
    $nam = $id;
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
  user_activity(3, 'Actualizó la foto de un vehículo');

  cargarArchivo('photo', '../../assets/img/vehiculos');

  //header("Location:".$_SERVER['HTTP_REFERER']);
  header("Cache-Control: no-cache, must-revalidate");
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  header("Content-Type: application/xml; charset=utf-8");
} else {
  header("Location: ../../public/index.php");
}
