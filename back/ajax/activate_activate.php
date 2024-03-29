<?php
include('../config/conexion.php');

if ($_POST['t']) {
	$u = $_POST['u'];
	$t = $_POST['t'];
	$p = $_POST['password'];
	$passEncrypted = password_hash($p, PASSWORD_BCRYPT);

	$stmt = mysqli_prepare($conexion, "SELECT * FROM system_users WHERE u_id= ? AND u_contrasena='' LIMIT 1");
	$stmt->bind_param("i", $u);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			if ($t == $row['u_token']) {
				$stmt2 = $conexion->prepare("UPDATE `system_users` SET `u_contrasena`= ?, `u_token`= '', `u_status`='1' WHERE u_id=?");
				$stmt2->bind_param("si", $passEncrypted, $u);
				$stmt2->execute();
				$stmt2 -> close();

				if ($stmt2) {
					echo 'acivado';
				}else {
					echo 'error_i';
				}
			}else {
				echo 'error_t';
			}

		}
	}else {
		echo 'error_n';
	}


	$stmt -> close();



}else {
	echo 'error_i';
}
