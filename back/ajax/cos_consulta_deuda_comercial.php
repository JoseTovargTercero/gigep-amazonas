<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
include('../config/conexion_gtc.php');
require_once 'cos_deuda_comercial.php';
require_once '../config/tasas_cambio.php';


if ($_SESSION["u_nivel"]) {
  // crea el header  'Content-Type': 'application/json'
  header('Content-Type: application/json');
  // recibe los inputs

  // Manejo de solicitudes preflight (OPTIONS)
  if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // Sin contenido
    exit(0);
  }


  $datos = json_decode(file_get_contents('php://input'), true);
  if (!$datos || !isset($datos['identificador'])) {
    throw new Exception("Datos JSON inválidos o campo 'identificador' faltante.");
  }
  $identificador = $datos['identificador'];




  $datos = deudaComercial($identificador, $tasas_bcv);
  header('Content-Type: application/json');
  echo json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} else {
  header("Location: ../../public/index.php");
}
