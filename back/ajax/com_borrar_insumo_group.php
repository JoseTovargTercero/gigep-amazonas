<?php
include('../config/conexion.php');
if ($_SESSION["u_nivel"]) {
  require('../config/funcione_globales.php');

  $id = $_GET["i"];
  $user = $_SESSION["u_ente_id"];



  $stmt = mysqli_prepare($conexion, "SELECT * FROM `com_grupo_insumos` 
  LEFT JOIN com_grupo ON com_grupo.id=com_grupo_insumos.grupo
  WHERE id_g = ?");
  $stmt->bind_param('s', $id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      if ($row['user'] == $user) {

       $stmt_2 = $conexion->prepare("DELETE FROM `com_grupo_insumos` WHERE id_g = ?");
       $stmt_2->bind_param("i", $id);
       $stmt_2->execute();
       $stmt_2->close();

       user_activity(1, 'Eliminó un grupo de insumos');


       echo "ok";
      }else {
        echo "error";
      }
    }
  }
  $stmt->close();
}
