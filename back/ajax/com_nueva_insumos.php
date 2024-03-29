<?php
include('../config/conexion.php');
if ($_SESSION["u_nivel"]) {
  require('../config/funcione_globales.php');

  $categoria = $_POST["categoria"];
  $insumos = $_POST["insumos"];
  $user = $_SESSION["u_ente_id"];

  $stmt_o = $conexion->prepare("INSERT INTO com_insumos (insumo, categoria, user) VALUES (?,?,?)");
  $stmt_o->bind_param("sss", $insumos, $categoria, $user);
  $stmt_o->execute();

  user_activity(2, 'Creo un nuevo insumo');

} 