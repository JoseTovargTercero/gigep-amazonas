<?php
include('../config/conexion.php');
if ($_SESSION["u_nivel"] == '1' || $_SESSION["u_nivel"] == '2' || $_SESSION["u_nivel"] == '4') {

  $i = $_POST["i"];
  $a = $_POST["a"];

  /* validar accion */
  $stmt = mysqli_prepare($conexion, "SELECT * FROM `system_users` WHERE u_id = ?");
  $stmt->bind_param('s', $i);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $ente_del_user = $row['u_ente_id'];
      $nivel_del_user = $row['u_nivel'];
      $status_del_user = $row['u_status'];

  }
  }
  $stmt->close();


  if ($_SESSION["u_nivel"] == '2') {
    # en caso de ser empresa
    # se valida que el usuario a eliminar sea de la empresa
    if ($ente_del_user != $_SESSION["u_id"]) {
      echo "denied";
      exit();
    }
  }elseif ($_SESSION["u_nivel"] == '4') {
    # en caso de ser supervisor
    # se valida que sea un usr tipo 2
    if ($nivel_del_user != '2') {
      echo "denied";
      exit();
    }
  }






  if ($a == 'd') {
    # delete
    
    $stmt = $conexion->prepare("DELETE FROM `system_users` WHERE u_id = ?");
    $stmt->bind_param("i", $i);
    $stmt->execute();
    $stmt->close();


  }elseif ($a == 'b' || $a == 'ub') {
    # banear

    if ($status_del_user == '1') {
      $set = '3';
    }elseif ($status_del_user == '3') {
      $set = '1';
    }

    $stmt = $conexion->prepare("UPDATE `system_users` SET `u_status`=? WHERE u_id=?");
    $stmt->bind_param("ss", $set, $i);
    $stmt->execute();
    $stmt -> close();

  }







}else {
  header("Location: ../../public/index.php");
}
?>