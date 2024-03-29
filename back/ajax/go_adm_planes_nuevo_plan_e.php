<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"] == '1') {


  $nombre_est = $_POST["nombre_est"];
  $ano = $_POST["ano"];
  $tipo = '2';
  $user = $_SESSION["u_id"];



  $stmt_o = $conexion->prepare("INSERT INTO go_planes (tipo, ano, nombre, user) VALUES (?, ?, ?, ?)");
  $stmt_o->bind_param("ssss", $tipo, $ano, $nombre_est, $user);
  $stmt_o->execute();
  if ($stmt_o) {
    echo 'ok';
  }else {
    echo "error";
  }
  $stmt_o->close();

  user_activity(2, 'Registró un nuevo plan estratégico');

}else {
  header("Location: ../../public/index.php");
}
?>