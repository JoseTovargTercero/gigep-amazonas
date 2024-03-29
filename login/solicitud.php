<?php
		include('../configuracion/conexionMysqli.php');
		include("../class/clearDates.php");
		include("../class/accionesSecundarias.php");
	
		$c_correo = $_POST['c_correo'];
		$c_cedula = $_POST['c_cedula'];
		$c_nombre = $_POST['c_nombre'];
		$c_telefono = $_POST['c_telefono'];
		$c_tipo = $_POST['c_tipo'];
		$c_lugar = $_POST['c_lugar'];
		$lat_r = $_POST['lat_r'];
		$lon_r = $_POST['lon_r'];

		function verificar($tabla){
			global $conexion;
			global $c_correo;
			$finds = 0;
			$stmt = mysqli_prepare($conexion, "SELECT * FROM $tabla WHERE usuario= ?");
			$stmt->bind_param("s", $c_correo);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows > 0) {
				$finds = 1;
			}
			$stmt -> close();
			if($finds != 0){
				return true;	
			} else {
				return false;	
			}
		}


		if (verificar('sist_usuarios') != true && verificar('sist_solicitudes_acceso') != true) {
			$stmt_upt = $conexion->prepare("INSERT INTO sist_solicitudes_acceso (cedula, responsable, tipo, lugar, telefono, usuario, lat, lng) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt_upt->bind_param("ssssssss", $c_cedula, $c_nombre, $c_tipo, $c_lugar, $c_telefono, $c_correo, $lat_r,
			$lon_r); 
			$stmt_upt->execute();

			if ($stmt_upt) { 
				echo 1;
			}
			$stmt_upt -> close();
		}else{
			echo 'EX';
		}

?>