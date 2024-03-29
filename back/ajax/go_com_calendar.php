<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"] == '1') {



  $stmt = mysqli_prepare($conexion, "SELECT * FROM `com_compras` WHERE status = '0'");
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

      echo $row['fecha'].'~'.$row['nombre'].'~'.$row['id'].'~'.$row['veh'].';';
    }
  }
  $stmt->close();


} else {
  header("Location: ../../public/index.php");
}
