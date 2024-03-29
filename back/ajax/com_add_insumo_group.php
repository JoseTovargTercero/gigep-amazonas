<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"]) {

  $user = $_SESSION["u_ente_id"];
  $categoria_add_product = $_POST["categoria_add_product"];
  $insumo_add_product = $_POST["insumo_add_product"];
  $cantidad_add_product = $_POST["cantidad_add_product"];
  $group_hide = $_POST["group_hide"];



//// FALTA
//// FALTA
//// FALTA
//// FALTA
//// FALTA
//// FALTA
//// FALTA


  $stmt = mysqli_prepare($conexion, "SELECT * FROM `com_grupo_insumos` WHERE grupo=? AND insumo=?");
  $stmt->bind_param('ss', $group_hide, $insumo_add_product);
  $stmt->execute();
  $result = $stmt->get_result();
  if (!$result->num_rows > 0) {
    $stmt_o = $conexion->prepare("INSERT INTO com_grupo_insumos (grupo, insumo, cantidad) VALUES (?,?,?)");
    $stmt_o->bind_param("sss", $group_hide, $insumo_add_product, $cantidad_add_product);
    $stmt_o->execute();

    if ($stmt_o) {
      echo "ok";
    }

  }else {
    echo 'ye';
  }
  $stmt->close();

} else {
  header("Location: ../../public/index.php");
}
