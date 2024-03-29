<?php



if ($_SERVER['SERVER_NAME'] == 'localhost') {
	$usuario = 'root';
	$contrasena = '';
  }else {
	$usuario = 'ricardo_s';
	$contrasena = 'rQW2ByFPB9Y+';
  }

$baseDeDatos = 'bd_epa_';


$conexion = new mysqli('localhost', $usuario, $contrasena, $baseDeDatos); 
$conexion->set_charset('utf8'); 

if ($conexion->connect_error) {
    die('Error de conexi贸n: ' . $conexion->connect_error);
}

//error_reporting(0);
date_default_timezone_set('America/Manaus');
session_start();



/* Una vez se loguee el usuario */
/*if(isset($_SESSION["nivel"])){
    session_regenerate_id(true);
};*/



function clear($value){
	$value = addslashes($value);
	$value = strip_tags($value);
	$value = stripslashes($value);
	$value = str_replace('"', "", $value);
	$value = str_replace("'", "", $value);
	$value = str_replace("drop", "", $value);
	$value = str_replace("truncate", "", $value);
	$value = str_replace("delete", "", $value);
	$value = str_replace("DROP", "", $value);
	$value = str_replace("TRUNCATE", "", $value);
	$value = str_replace("DELETE", "", $value);
	$value = str_replace("<", "", $value);
	$value = str_replace(">", "", $value);
	$value = str_replace("/", "", $value);
	$value = str_replace(";", "", $value);
	return $value;
}

?>