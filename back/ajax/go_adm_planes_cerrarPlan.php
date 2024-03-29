<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"] == '1') {




    
    $p = $_GET["p"];
        
    $stmt2 = $conexion->prepare("UPDATE `go_planes` SET `cerrado`='1' WHERE id=?");
    $stmt2->bind_param("s", $p);
    $stmt2->execute();
    $stmt2 -> close();

    user_activity(3, 'Cerro un plan');


    header("Location:".$_SERVER['HTTP_REFERER']);


} else {
  header("Location: ../../public/index.php");
}
