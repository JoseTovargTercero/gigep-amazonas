<?php
	
	include('../configuracion/conexionMysqli.php');
	include("../class/clearDates.php");

	$doc = clearDate($_POST['user']);
	$contrasena = clearDate($_POST['pass']);


	$stmt = mysqli_prepare($conexion, "SELECT *
	FROM sist_usuarios WHERE usuario= ?");
	$stmt->bind_param("s", $doc);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			
			$passAlmacenada = $row['contrasena'];
			$idUsuario = $row['id'];

			if (password_verify($contrasena, $passAlmacenada)) {
				$_SESSION['nombre']=$row['nombreUser'];
				$_SESSION['darkMode']=$row['darkMode'];
				$_SESSION['nivel']=$row['nivel'];
				$_SESSION['id']=$row['id'];
				$_SESSION["validate"] = "ok";
				$_SESSION["status"] = $row['status'];

				$id = $_SESSION['id'];
				$nombre = $_SESSION['nombre'];
				$fecha = time();
				$nivel = $_SESSION['nivel'];

				$insert = $conexion->query("INSERT INTO log_usuarios (id_user, usuario, fecha) VALUES ('$id','$nombre','$fecha')"); 
/*
				if ($_SESSION["status"] == 0 && $nivel!= 1 && $nivel != 2) {
					echo 2;
				}else{*/
					echo 1;
//				}

			}else {
				echo 0;
			}

		}

	}else {
		echo 0;
	}


?>
