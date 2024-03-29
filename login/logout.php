<?php
include('../back/config/conexion.php');
session_start();
session_destroy();
$conexion->close();

header("Location: ../public/index.php");
?>