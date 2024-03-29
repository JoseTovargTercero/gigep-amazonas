<?php
include('../config/conexion.php');
if ($_SESSION["u_nivel"]) {
  require('../config/funcione_globales.php');

  $nombreCategoria = $_POST["nombreCategoria"];
  $user = $_SESSION["u_ente_id"];

  $stmt_o = $conexion->prepare("INSERT INTO com_categorias (nombre, user) VALUES (?,?)");
  $stmt_o->bind_param("ss", $nombreCategoria, $user);
  $stmt_o->execute();

  user_activity(2, 'Creo una nueva categoría');



} 