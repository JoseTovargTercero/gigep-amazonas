<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"]) {
  $id = $_SESSION["u_id"];
  $currentPassword = $_POST["currentPassword"];
  $newPassword = $_POST["newPassword"];
  $confirmPassword = $_POST["confirmPassword"];




	$stmt = mysqli_prepare($conexion, "SELECT * FROM `system_users` WHERE u_id = ?");
	$stmt->bind_param("s", $id);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			if (password_verify($currentPassword, $row['u_contrasena'])) {
      }else {
        echo 'error_pass';
        exit();
      }
    }
  }
  
  if ($newPassword != $confirmPassword) {
    echo "error_diff";
    exit();
  }




	$passEncrypted = password_hash($newPassword, PASSWORD_BCRYPT);

  $stmt2 = $conexion->prepare("UPDATE `system_users` SET `u_contrasena`=? WHERE u_id='$id'");
  $stmt2->bind_param("s", $passEncrypted);
  $stmt2->execute();
  $stmt2 -> close();



  echo 'ok';



} else {
  header("Location: ../../public/index.php");
}
