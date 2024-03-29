<?php
	
	include('../config/config.php');
	include("../config/clearDates.php");
	include("../config/crud.php");
	include("../class/accionesSecundarias.php");

	$doc = clearDate($_POST['user']);
	$contrasena = clearDate($_POST['password']);

	$stmt = mysqli_prepare($conexion, "SELECT * FROM sheet_u WHERE u_sr= ? AND u_pss!='' AND u_status!='2' LIMIT 1");
	$stmt->bind_param("s", $doc);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			if (password_verify($contrasena, $row['u_pss'])) {
				if ($row['u_status'] == 1) {
					session_start();
					$_SESSION['user_id']=$row['id'];
					$id = $row['id'];
					$rand = rand(10000,1000000);
					$_SESSION['rand'] = $rand;

					$stmt = $conexion->prepare("UPDATE `sheet_u` SET `u_token`= 'x' WHERE id='$id'");
					$stmt->execute();

				
					$titulo = 'SIRCIG-GNB - Verificacion'; // Asunto
					$mensaje = ' 
					<html> 
					<head> 
					<title>SIRCIG-GNB</title> 
					</head> 
					<body> 
					<h1>Hola '.$row['u_nm'].'!</h1> 
					<p> 
					<b>
						Haga click en el siguiente enlace para validar su inicio de sesi&oacute;n. 
						<strong>
						En caso de no haber realizado ning&uacute;n inicio, actualice sus credenciales.
						</strong>
				
						<a href="https://mapoignb.com/sircig/ini?tk='.$rand.'&u='.$row['id'].'">Validación de usuario</a>
					<br>
					<br>
					<h2></h2>
					<br>
					<br>
					</p> 
					</body> 
					</html> '; 
				
			
					if (sendMails($row['u_sr'], $titulo, $mensaje) == 1) {
						$estado = 'true';
					}else {
						$estado = 'false-m';
					}





				}else{
					$estado = 'false-2';
					// por usr bloqueado
				}

			}else{
				$estado = 'false';
				// por pss incorrecto
			}
		}
	}else {
		$estado = 'false';
		// por pss/usr incorrecto
	}

	$stmt -> close();





	echo $estado;

?>