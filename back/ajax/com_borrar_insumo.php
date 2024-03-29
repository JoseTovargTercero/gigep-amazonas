<?php
include('../config/conexion.php');
if ($_SESSION["u_nivel"]) {
  require('../config/funcione_globales.php');

  $id = $_GET["i"];
  $user = $_SESSION["u_ente_id"];



  $stmt = mysqli_prepare($conexion, "SELECT * FROM `com_insumos` WHERE id_i = ?");
  $stmt->bind_param('s', $id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      if ($row['user'] == $user) {

       $stmt = $conexion->prepare("DELETE FROM `com_insumos` WHERE id_i = ?");
       $stmt->bind_param("i", $id);
       $stmt->execute();
       $stmt->close();


       user_activity(1, 'Eliminó un insumo');

      }
    }
  }
  $stmt->close();
}
