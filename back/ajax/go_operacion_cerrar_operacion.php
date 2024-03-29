<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"] == 2) {

  $i = $_GET["i"];


  $users = array();
  $stmt_users = mysqli_prepare($conexion, "SELECT * FROM `go_operaciones` WHERE id =?");
  $stmt_users->bind_param('s', $i);
  $stmt_users->execute();
  $result_users = $stmt_users->get_result();
  if ($result_users->num_rows > 0) {
    while ($row_users = $result_users->fetch_assoc()) {
      if ($_SESSION["u_id"] == $row_users['empresa_id']) {


        $stmt2 = $conexion->prepare("UPDATE `go_operaciones` SET `cerrado`='1' WHERE id=?");
        $stmt2->bind_param("s", $i);
        $stmt2->execute();
        $stmt2 -> close();

        user_activity(3, 'Cerró una operación');
        notificar(['admin_users', 'involved_users'], 5, $i);
      }
    }
  }
  $stmt_users->close();

  header("Location:".$_SERVER['HTTP_REFERER']);





} else {
  header("Location: ../../public/index.php");
}
