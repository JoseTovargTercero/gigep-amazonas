<?php
	
	include('../configuracion/conexionMysqli.php');
	include("../class/clearDates.php");
	include("../class/accionesSecundarias.php");

	$tipo = clearDate($_POST['tipo']);

	$rec_correo = clearDate($_POST['rec_correo']);
	$rec_tel = clearDate($_POST['rec_tel']);
	$rec_cod = clearDate($_POST['rec_cod']);

	if ($tipo == 'vc') {
		$stmt = mysqli_prepare($conexion, "SELECT * FROM sist_usuarios WHERE usuario= ?");
		$stmt->bind_param("s", $rec_correo);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				echo substr($row['telefono'], -2);
			}
		}else {
			echo 'NE';
		}
		$stmt -> close();
	}elseif($tipo == 'tl'){
		$stmt = mysqli_prepare($conexion, "SELECT * FROM sist_usuarios WHERE usuario= ? AND telefono = ?");
		$stmt->bind_param("ss", $rec_correo, $rec_tel);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
			$rand = rand(10000,1000000);
			$id = $row['id'];
			
			$stmt_upt = $conexion->prepare("UPDATE `sist_usuarios` SET `token`= ? WHERE id='$id'");
			$stmt_upt->bind_param("s", $rand);
			$stmt_upt->execute();
			$stmt_upt -> close();


			$titulo = 'GITCOM - Recuperar contraseña'; // Asunto
			$mensaje = ' 
			<html> 
			<head> 
			<title>GITCOM - Recuperar contraseña</title> 
			</head> 
			<body> 
			<h1>Hola '.$row['nombreUser'].'!</h1> 
			<p> 
			<b>
				Utilice el siguiente código para cambiar la su contraseña:
				<strong>
				'.$rand.'
				</strong>
			<br>
			<br>
			<br>
			</p> 
			</body> 
			</html> '; 
			
			if (sendMails($email, $titulo, $mensaje) == 1) {
				echo 'OK';
			}else {
				echo 'ERROR_C';
			}

		}

		}else {
			echo 'NE';
		}
		$stmt -> close();

		
	}elseif($tipo == 'cod'){
	
		$stmt = mysqli_prepare($conexion, "SELECT * FROM sist_usuarios WHERE usuario= ? AND token= ?");
		$stmt->bind_param("ss", $rec_correo, $rec_cod);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			echo 'OK';
		}else {
			echo 'NC';
		}
		$stmt -> close();
	}elseif ($tipo == 'pass') {
		$rec_pss = clearDate($_POST['rec_pss']);

		$stmt = mysqli_prepare($conexion, "SELECT * FROM sist_usuarios WHERE usuario= ? AND token= ?");
		$stmt->bind_param("ss", $rec_correo, $rec_cod);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {

			$id = $row['id'];

			$passEncrypted = password_hash($rec_pss, PASSWORD_BCRYPT);

			$stmt_upt = $conexion->prepare("UPDATE `sist_usuarios` SET `contrasena`= ?, `token`='' WHERE id='$id'");
			$stmt_upt->bind_param("s", $passEncrypted);
			$stmt_upt->execute();
			if ($stmt_upt) {
				echo 'OK';
			}
			$stmt_upt -> close();
		}

			
		}else {
			echo 'NC';
		}
		$stmt -> close();
		
	}




?>