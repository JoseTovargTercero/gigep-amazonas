<?php
include('../config/conexion.php');
if ($_SESSION["u_nivel"] == '1') {
  require('../config/funcione_globales.php');

  $user = $_SESSION["u_ente_id"];
  
  $id = $_GET["i"];

  $stmt2 = $conexion->prepare("UPDATE `com_compras` SET `status`='2' WHERE id=?");
  $stmt2->bind_param("s", $id);
  $stmt2->execute();
  if ($stmt2) {
    echo 'ok';
  }
  $stmt2 -> close();

  user_activity(3, 'Marco una compra como finalizada');


  $stmt = mysqli_prepare($conexion, "SELECT DISTINCT(user_id) FROM `com_compras_estructura` WHERE compra_id = ?");
  $stmt->bind_param('s', $id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

      notificar([$row['user_id']], 26, $id);

    }
  }
  $stmt->close();


}
