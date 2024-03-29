<?php
	include('../config/conexion.php');
	include("../config/clearDates.php");

if ($_SESSION['id'] && $_SESSION['rand']) {
	$id = $_SESSION['id'];
	$tk = $_SESSION['rand'];

	$stmt = mysqli_prepare($conexion, "SELECT * FROM sist_usuarios_vt WHERE id=? AND u_token=? LIMIT 1");
	$stmt->bind_param("ss", $id, $tk);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {

			$stmt = $conexion->prepare("UPDATE `sist_usuarios_vt` SET `u_token`= '' WHERE id='$id'");
			$stmt->execute();
		
			$_SESSION['nombre']=$row['nombreUser'];
			$_SESSION['nivel']=$row['nivel'];
			$_SESSION['id']=$row['id'];
			$_SESSION["validate"] = "ok";
			$_SESSION["instancia"] = $row['instancia'];
			$_SESSION["instancia_val"] = $row['instancia_val'];
			$_SESSION["s"] = $row['s'];
			$_SESSION["mcp_filter"] = '';

			$id = $_SESSION['id'];
			$nombre = $_SESSION['nombre'];
			$fecha = time();

			$insert = $conexion->query("INSERT INTO log_usuarios (id_user, usuario, fecha) VALUES ('$id','$nombre','$fecha')"); 

			echo 'true';
		}
	} else {
		echo 'false';
	}
	$stmt->close();
} else {
	echo 'false-servidor';
}

?>