<?php


function cargarDotEnv($ruta)
{
	// Construir rutas posibles
	$archivoEnv = rtrim($ruta, '/') . '/.env_sigep';
	$archivoAlt = rtrim($ruta, '/') . '/env_sigep';

	// Verificar cuál existe
	if (file_exists($archivoEnv)) {
		$archivo = $archivoEnv;
	} elseif (file_exists($archivoAlt)) {
		$archivo = $archivoAlt;
	} else {
		echo "Archivo .env o env no encontrado en $ruta";
		return;
	}

	$lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach ($lineas as $linea) {
		if (strpos(trim($linea), '#') === 0) continue; // Ignorar comentarios

		list($nombre, $valor) = explode('=', $linea, 2);
		$nombre = trim($nombre);
		$valor = trim($valor);

		// No sobrescribe variables ya definidas
		if (!isset($_ENV[$nombre])) {
			$_ENV[$nombre] = $valor;
		}
	}
}

cargarDotEnv(dirname(__DIR__) . '/../../');
$usuario = $_ENV['DB_USER'];
$host = $_ENV['HOST'];
$contrasena = $_ENV['DB_PASS'];
$baseDeDatos = $_ENV['DB_NAME'];


if ($_SERVER['SERVER_NAME'] == 'localhost') {
	$usuario = 'root';
	$contrasena = '';
}

$conexion = new mysqli('localhost', $usuario, $contrasena, $baseDeDatos);
$conexion->set_charset('utf8');

if ($conexion->connect_error) {
	die('Error de conexion: ' . $conexion->connect_error);
}

//error_reporting(0);
date_default_timezone_set('America/Manaus');
session_start();



/* Una vez se loguee el usuario */
/*if(isset($_SESSION["nivel"])){
    session_regenerate_id(true);
};*/



function clear($value)
{
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
