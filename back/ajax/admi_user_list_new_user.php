<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"] == '1' || $_SESSION["u_nivel"] == '2') {

  $name_user = $_POST["name_user"];
  $email_user = $_POST["email_user"];
  $rol_user = $_POST["rol_user"];
  $en = $_POST["en"];
  $en_s = $_POST["en_s"];
  $telefono_user = $_POST["telefono_user"];

  $tipo_registro = '1';
  // solo para usuarios tipo empresa o epa
  $send_notice = '0';
  $rand = rand(100000000,10000000000000);




  if ($_SESSION["u_nivel"] == '2') { // AQUI REGISTRA LA EMPRESA
    if ($rol_user != 'Supervisor' && $rol_user != 'Empleado') {
     echo "accion_denegada";
     exit();
    }
  }


  // verificar registro previo del correo
  $stmt_u = mysqli_prepare($conexion, "SELECT * FROM `system_users` WHERE u_email = ?");
  $stmt_u->bind_param('s', $email_user);
  $stmt_u->execute();
  $result = $stmt_u->get_result();
  if ($result->num_rows > 0) {
    echo "exists_u";
    exit();
  }
  $stmt_u->close();

  /*
  $stmt_t_u = mysqli_prepare($conexion, "SELECT * FROM `system_users_temps` WHERE u_email = ?");
  $stmt_t_u->bind_param('s', $email_user);
  $stmt_t_u->execute();
  $result = $stmt_t_u->get_result();
  if ($result->num_rows > 0) {
    echo "exists_t_u";
    exit();
  }
  $stmt_t_u->close();
*/

$sa = "0";

  switch ($rol_user) {
    case 'Administrador':
      $rol_user_n = '1';
      break;
    case 'Empresa':
      $rol_user_n = '2';
      $sa = '1';
      break;
    case 'Empleado':
      $rol_user_n = '3';
      break;
    case 'Soporte':
      $rol_user_n = '4';
      break;
    case 'Cajero':
      $rol_user_n = '5';
      break;
  }




  /*
  Admin:  TODO: se va directo a la BD USER 
  * $tipo_registro == '1'

  Registra una empresa - 
  Se agregan los datos mas
  */



  if ($tipo_registro == '1') { // registros directos
    //insert n user

      $e = 'LA EPA';
      $stmt = $conexion->prepare("INSERT INTO system_users (u_nombre, u_ente, u_email, u_nivel, u_token, u_telefono, sa) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("sssssss", $name_user, $e, $email_user, $rol_user_n, $rand, $telefono_user, $sa);
      $stmt->execute();
   
      if ($stmt) {
        echo "ok";
      }
      $registro = $conexion->insert_id;
      $stmt->close();

      user_activity(2, 'Creo un nuevo usuario');


      if ($rol_user_n == '2') { //CUANDO SE REGISTRE UNA EMPRESA SE ACTUALIZA EL ENTE ID USANDO SU PROPIO ID
        $stmt2 = $conexion->prepare("UPDATE `system_users` SET `u_ente`=?, `u_ente_id`=? WHERE u_id=?");
        $stmt2->bind_param("sss", $en, $registro, $registro);
        $stmt2->execute();
        $stmt2 -> close();
      }elseif ($rol_user_n == '3') { // CUANDO SE REGISTRA UN EMPLEADO
        // si registra un admin (se toma el valor del select)
        // si registra una empresa (se toma el valor de la sesion)
        if ($_SESSION["u_nivel"] == '2'){
          $en_s = $_SESSION["u_ente_id"];
          $en = $_SESSION["u_ente"];
        }elseif ($_SESSION["u_nivel"] == '1') {
          $en_s = $_POST["en_s"];

          if ($rol_user != 'Empresa') {
              $stmt_q = mysqli_prepare($conexion, "SELECT * FROM `system_users` WHERE u_id = ?");
              $stmt_q->bind_param('s', $en_s);
              $stmt_q->execute();
              $result = $stmt_q->get_result();
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $en = $row["u_ente"];
                }
              }
              $stmt_q->close();
            }

        }

        $stmt2 = $conexion->prepare("UPDATE `system_users` SET `u_ente`=?, `u_ente_id`=? WHERE u_id=?");
        $stmt2->bind_param("sss", $en, $en_s, $registro);
        $stmt2->execute();
        $stmt2 -> close();


        /* ENVIAR EL CORREO */
/*

        $titulo = 'SIGEP - Activación de usuario'; // Asunto
        $mensaje = ' 
        <html> 
        <head> 
        <title>SIGEP - Activación de usuario</title> 
        </head> 
        <body> 
        <h1>Hola '.$name_user.'!</h1> 
        <p> 
        <br>
          Se ha creado un usuario en la plataforma, utilice el siguiente link para completar el registro y poder acceder a su cuenta.
      
          <a href="https://link.com/activate?tk='.$rand.'&u='.$idu.'">Completar registro</a>
        <br>
        <br>
        <h2></h2>
        <br>
        <br>
        </p> 
        </body> 
        </html> '; 
      
        $headers = "MIME-Version: 1.0\r\n"; 
        $headers .= "Content-type: text/html; charset=utf-8\r\n"; 
        $headers .= "From: Soporte de Usuarios MAPOIGNB <soporte@mapoignb.com>\r\n"; 
        $headers .= "Return-path: soporte@mapoignb.com\r\n"; 
        $headers .= "Cc: soporte@mapoignb.com\r\n"; 
        $headers .= "Bcc: soporte@mapoignb.com\r\n"; 
      
        if (!mail($email, $titulo, $mensaje, $headers)) {
          echo 'eroro';
        }
*/


      }




  }

}else {
  header("Location: ../../public/index.php");
}
?>