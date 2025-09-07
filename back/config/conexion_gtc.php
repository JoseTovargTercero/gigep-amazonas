<?php


function cargarDotEnvg($ruta)
{
	// Construir rutas posibles
	$archivoEnv = rtrim($ruta, '/') . '/.env_gitcom_comercial';
	$archivoAlt = rtrim($ruta, '/') . '/env_gitcom_comercial';

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

cargarDotEnvg(dirname(__DIR__) . '/../../');
$usuario = $_ENV['DB_USERG'];
$host = $_ENV['HOSTG'];
$contrasena = $_ENV['DB_PASSG'];
$baseDeDatos = $_ENV['DB_NAMEG'];


if ($_SERVER['SERVER_NAME'] == 'localhost') {
	$usuario = 'root';
	$contrasena = '';
}

$conexion_g = new mysqli('localhost', $usuario, $contrasena, $baseDeDatos);
$conexion_g->set_charset('utf8');

if ($conexion_g->connect_error) {
	die('Error de conexion_g: ' . $conexion_g->connect_error);
}
