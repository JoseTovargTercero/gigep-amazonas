<?php
	ob_start();
	include('../back/config/conexion.php');
	$email = clear($_POST['email']);
	$contrasena = clear($_POST['password']);
	$email = mysqli_real_escape_string($conexion,  $email);
	$contrasena = mysqli_real_escape_string($conexion,  $contrasena);


    function tiempoTranscurridoFechas($fechaInicio,$fechaFin){
		$fecha1 = new DateTime($fechaInicio);
		$fecha2 = new DateTime($fechaFin);
		$fecha = $fecha1->diff($fecha2);
		return $fecha->i;
	}

	$_SESSION["errores_val"] = 0;
	$_SESSION["time_out"] = '';

	if (@!$_SESSION["errores_val"]) {
		$_SESSION["errores_val"] = 0;
	}


	if (@$_SESSION["errores_val"] == 3 && @$_SESSION["time_out"] == '') {
		$_SESSION["time_out"] = date('d-m-Y, h:i:s');
		$_SESSION["email_bloq"] = $email;
	}


	if (@$_SESSION["time_out"] != '') {
		$tiempo = tiempoTranscurridoFechas($_SESSION["time_out"], date('d-m-Y, h:i:s'));
		$time_out = 15;
		if ($tiempo < $time_out) {
			// no ha pasado la cantidad de tiempo necesario
			$restan = $time_out - $tiempo;
			echo 'b_temp*'.$restan;
			ob_end_flush();
			exit();
		}else {
			$_SESSION["status_p"] = 'true';
			// ya paso el tiempo, queda en estatus de espera, si se equivoca, bloquea el usuario
		}
	}

	/* LOGIN */


	$stmt = mysqli_prepare($conexion, "SELECT * FROM `system_users` WHERE u_email = ? AND u_contrasena!='' LIMIT 1");
	$stmt->bind_param("s", $email);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows > 0) {

		while ($row = $result->fetch_assoc()) {
			if (password_verify($contrasena, $row['u_contrasena'])) {

					if ($row['u_status'] == '2') {
						$estado = 'user_bloqueado';
					}elseif($row['u_status'] == '0'){
						$estado = 'user_pendiente';
					}elseif($row['u_status'] == '3'){
						$estado = 'user_ban';
					}else{
						$_SESSION["status_p"] = 'false';
						$_SESSION['u_nombre']=$row['u_nombre'];
						$_SESSION['u_nivel']=$row['u_nivel'];
						$_SESSION['u_id']=$row['u_id'];
						$_SESSION['u_ente']=$row['u_ente'];
						$_SESSION['u_ente_id']=$row['u_ente_id'];
						$_SESSION['u_e']=$row['u_email'];
						$_SESSION['u_telefono']=$row['u_telefono'];
						$_SESSION["validate"] = 'true';

						if ($row['u_nivel'] == 2) {
							$_SESSION["sa"] = '1';
						}elseif ($row['u_nivel'] == 1) {
							$_SESSION["sa"] = $row['sa'];
						}else {
							$_SESSION["sa"] = 0;
						}


												
						if ( isset( $_SERVER ) ) {
							$user_agent = $_SERVER['HTTP_USER_AGENT'];
						} else {
							global $HTTP_SERVER_VARS;
							if ( isset( $HTTP_SERVER_VARS ) ) {
								$user_agent = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
							} else {
								global $HTTP_USER_AGENT;
								$user_agent = $HTTP_USER_AGENT;
							}
						}
						//
						//
						function getOS() { 
							global $user_agent;
							$os_array =  array(
											'/windows nt 10/i'      =>  'Windows 10',
											'/windows nt 6.3/i'     =>  'Windows 8.1',
											'/windows nt 6.2/i'     =>  'Windows 8',
											'/windows nt 6.1/i'     =>  'Windows 7',
											'/windows nt 6.0/i'     =>  'Windows Vista',
											'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
											'/windows nt 5.1/i'     =>  'Windows XP',
											'/windows xp/i'         =>  'Windows XP',
											'/windows nt 5.0/i'     =>  'Windows 2000',
											'/windows me/i'         =>  'Windows ME',
											'/win98/i'              =>  'Windows 98',
											'/win95/i'              =>  'Windows 95',
											'/win16/i'              =>  'Windows 3.11',
											'/macintosh|mac os x/i' =>  'Mac OS X',
											'/mac_powerpc/i'        =>  'Mac OS 9',
											'/linux/i'              =>  'Linux',
											'/ubuntu/i'             =>  'Ubuntu',
											'/iphone/i'             =>  'iPhone',
											'/ipod/i'               =>  'iPod',
											'/ipad/i'               =>  'iPad',
											'/android/i'            =>  'Android',
											'/blackberry/i'         =>  'BlackBerry',
											'/webos/i'              =>  'Mobile'
										);
							//
							$os_platform = "Unknown OS Platform";
							foreach ($os_array as $regex => $value) { 
								if (preg_match($regex, $user_agent)) {
									$os_platform = $value;
								}
							}
							return $os_platform;
						}


						function getIp(){
							if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) { // Soporte de Cloudflare
								$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
							} elseif (isset($_SERVER['DIRECCIÓN REMOTA']) === true) {
								$ip = $_SERVER['DIRECCIÓN REMOTA'];
								if (preg_match('/^(?:127|10)\.0\.0\.[12]?\d{1,2}$/', $ip)) {
									if (isset($_SERVER['HTTP_X_REAL_IP'])) {
										$ip = $_SERVER['HTTP_X_REAL_IP'];
									} elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
										$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
									}
								}
							} else {
								$ip = '127.0.0.1';
							}
							if (in_array($ip, ['::1', '0.0.0.0', 'localhost'], true)) {
								$ip = '127.0.0.1';
							}
							$filter = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
							if ($filter === false) {
								$ip = '127.0.0.1';
							}

							return $ip;
						}
						$user_os        =   getOS();
						$device_details =   $user_os . ' - '.getIp();
						$insert = $conexion->query("INSERT INTO system_logs (user_id, dispositivo, empresa_id) VALUES ('$row[u_id]','$device_details','$row[u_ente_id]')"); 
						$estado = 'true';
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


	if ($estado == 'false') {
		$_SESSION["errores_val"] += 1;
		$_SESSION["time_out"] = '';

		if (@$_SESSION["status_p"] == 'true') {
			// bloqua el usuario // query

			$email_2 = $_SESSION["email_bloq"];

			if ($email == $email_2) {
				
			$stmt = $conexion->prepare("UPDATE `system_users` SET `u_ban`= '1' WHERE u_email=?");
			$stmt->bind_param('s', $email);
			$stmt->execute();

			$estado = 'user_bloqueado';
			}else {
				$_SESSION["time_out"] = date('d-m-Y, h:i:s');
				$_SESSION["email_bloq"] = $email; // otro time out // pero de 20 minutos


				$tiempo = tiempoTranscurridoFechas($_SESSION["time_out"], date('d-m-Y, h:i:s'));
				$time_out = 20;
				$restan = $time_out - $tiempo;
				echo 'b_temp*'.$restan;
				ob_end_flush();
				exit();


			}

		}
	}
	echo $estado;

	ob_end_flush();
?>
