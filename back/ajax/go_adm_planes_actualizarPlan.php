<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"] == '1') {
    $p = $_POST["p"];
    $nuevoNombre = $_POST["nuevoNombre"];
    
    $stmt2 = $conexion->prepare("UPDATE `go_planes` SET `nombre`='$nuevoNombre' WHERE id=?");
    $stmt2->bind_param("s", $p);
    $stmt2->execute();
    $stmt2 -> close();

    user_activity(3, 'Actualizó el nombre de un plan');

    header("Location:".$_SERVER['HTTP_REFERER']);

} else {
  header("Location: ../../public/index.php");
}
