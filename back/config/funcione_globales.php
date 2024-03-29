<?php



function accessControl($u = null){
  global $conexion;

  !$u ? $usr = $_SESSION["u_id"] : $usr = $u; 

  $archivo = basename($_SERVER['PHP_SELF']);
  $modulo_actual = explode('_', $archivo)[0];
 
  $modulos_sistema = array();
  $stmt = mysqli_prepare($conexion, "SELECT * FROM `system_modulos`");
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      array_push($modulos_sistema, $row['modulo']);
    }
  }
  $stmt->close();
  /* EN CASO DE QUE EL MODULO NO EXISTA (CASO, BACK)*/


  $permisos = array();
  $stmt = mysqli_prepare($conexion, "SELECT * FROM `user_permisos` WHERE user = '$usr'");
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      array_push($permisos, $row['modulo']);
    }
  }
  $stmt->close();


  if ($_SESSION["sa"] == '1') {
    return $modulos_sistema;  // PARA LOS SUPER ADMINS
  }elseif (in_array($modulo_actual, $permisos) || $modulo_actual == 'user' || !in_array($modulo_actual, $modulos_sistema)) {
    return $permisos; // CUANDO SE ACCEDE A UN MODULO PERMITIDO ||  CUANDO SE ACCEDE AL PERFIL DE USUARIOS || SOLO APLICA PARA LOS ARCHIVOS DEL BACKEND QUE NO TIENEN UN PREFIJO DEFINIDO
  } else {
    return false;
  }

}

if (accessControl() == false) {
  header("Location: ../../login/logout.php");
} // EN CASO DE QUE NO TENGA PERMISOS



function usuarios_x_empresas($e = null){
  global $conexion;

  if ($e) {
    $empresa = $e;
  }else {
    $empresa = $_SESSION["u_ente_id"];
  }
  $usrs  = array();
  $stmt = mysqli_prepare($conexion, "SELECT u_id, sa, u_nivel FROM `system_users` WHERE u_ente_id = ?");
  $stmt->bind_param('s', $empresa);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $row['u_nivel'] == '2' ? $sa = 1 : $sa = $row['sa'];
      array_push($usrs, [$row['u_id'], $sa]);
    }
  }
  $stmt->close();

  return $usrs;
}
/*
    Returns a human-friendly time difference between the given date and the current date/time.
    @param string $date The date to compare against.
    @return string The time difference, e.g., "1 month ago", "2 days ago", etc.
 */
function dateToTimeAgo($date){
  $datetime1 = new DateTime($date);
  $datetime2 = new DateTime(date('Y-m-d H:i:s'));
  $interval = $datetime1->diff($datetime2);

  $years = $interval->y;
  $months = $interval->m;
  $days = $interval->d;
  $hours = $interval->h;
  $minutes = $interval->i;
  $seconds = $interval->s;

  if ($years > 0) {
    return "hace $years año" . ($years > 1 ? "s" : "");
  } elseif ($months > 0) {
    return "hace $months mese" . ($months > 1 ? "s" : "");
  } elseif ($days > 0) {
    return "hace $days dia" . ($days > 1 ? "s" : "");
  } elseif ($hours > 0) {
    return "hace $hours hora" . ($hours > 1 ? "s" : "");
  } elseif ($minutes > 0) {
    return "hace $minutes minuto" . ($minutes > 1 ? "s" : "");
  } elseif ($seconds > 0) {
    return "hace $seconds segundo" . ($seconds > 1 ? "s" : "");
  } else {
    return "Justo ahora";
  }
}


//notificar(['global_users'], 11, $id_p);
/**
 * Returns the text for a given notification type.
 *
 * @param int $type The type of notification.
 * @return string The text for the given notification type.
 */
function textNotification($type, $t = null){
  $msgTextNotification = array(
    '1' => ['Le asignó una operación', 'go'], //* LISTO
    '2' => ['Le asignó una tarea', 'go'],  //* LISTO
    '3' => ['Modificó una tarea', 'go'], // PENDIENTE
    '4' => ['Publicó una operación', 'go'], //* LISTO
    '5' => ['Cerró una operación', 'go'], //* LISTO
    '6' => ['Ejecutó una tarea', 'go'], //*LISTO
    '7' => ['Confirmó participación', 'go'], //* lISTO
    '8' => ['Rechazó participación', 'go'], //* lISTO
    '9' => ['Envió un mensajes al chat de una operación', 'go'], //*LISTO 
    '10' => ['Solicitó sumarse a una operación', 'go'], //*LISTO
    '11' => ['Inició un nuevo plan sectorial', 'go'], //* LISTO
    '12' => ['Actualizó el estado de un ticket', 'st'], // PENDIENTE
    '13' => ['Cerro un ticket', 'st'], // PENDIENTE
    '14' => ['Le asigno una responsabilidad', 'go'], //* LISTO
    '15' => ['Eliminó una tarea asignada', 'go'], //*LISTO
    '16' => ['Reporto avances en una tarea', 'go'], //*LISTO,
    '17' => ['Comento una operación', 'go'],
    '18' => ['Rechazó la solicitud de su empresa', 'go'],
    '19' => ['Acepto la solicitud de su solicitud', 'go'],
    '20' => ['Se publicó una nueva compra', 'com'],
    '21' => ['Se reprogramó una compra periódica', 'com'],
    '22' => ['Un vehículo fue reparado', 'veh'],
    '23' => ['Un vehículo ha salido de funcionamiento', 'veh'],
    '24' => ['Se necesita un vehículo para completar una tarea', 'go'],
    '25' => ['Se ha programado una compra de repuestos', 'com'],
    '26' => ['Se ha realizado una compra', 'com'],
    '27' => ['Un vehículo propiedad de su empresa se ha designado para completar una tarea', 'go'],
    '28' => ['Ha confirmado el uso de un vehículo en una tarea', 'go'],
    '29' => ['Rechazó el uso de un vehículo en una tarea', 'go'],
    '30' => ['Un vehículo esta presentando fallas', 'veh']
  );
  return !$t ? $msgTextNotification[$type][0] : $msgTextNotification[$type][1];
}


// TODO: REPORTAR EJECUCION PARA TAREAS TRIMESTRALES

/**
 * Notifies the specified users of the specified event.
 *
 * @param array $user_2 The users to notify.
 * @param string $tipo_n The type of event.
 * @param string $guia The GUID of the event.
 */


function notificar($user_2, $tipo_n, $guia, $extra = false, $ignorar = false){
  global $conexion;
  global $users;

  $t_notiifacion = textNotification($tipo_n, 1);

  $users = array();

  $stmt = mysqli_prepare($conexion, "SELECT * FROM `system_users` WHERE u_nivel ='1' OR u_nivel ='2'");
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      array_push($users, [$row['u_nivel'], $row['u_id'], accessControl($row['u_id'])]);
    }
  }
  $stmt->close();



  $user_1_nivel = $_SESSION["u_nivel"];
  $user_1 = $_SESSION["u_id"];


  $stmt_o = $conexion->prepare("INSERT INTO notificaciones (user_1_nivel,user_1,user_2,tipo,guia,comentario) VALUES (?, ?, ?, ?, ?, ?)");

  foreach ($user_2 as $valueParam) {


    if ($valueParam == 'admin_users') {
      foreach ($users as $value) {
        if ($value['1'] != $_SESSION["u_id"]) {
          if ($value['0'] == '1' && in_array($t_notiifacion, $value['2'])) {
            $stmt_o->bind_param("ssssss", $user_1_nivel, $user_1, $value['1'], $tipo_n, $guia, $extra);
            $stmt_o->execute();
          }
        }
      }
    }
    

    if ($valueParam == 'global_users') {
      foreach ($users as $value) {
        if ($value['0'] == '2' || $value['0'] == '3' && in_array($t_notiifacion, $value['2'])) {
          if ($value['1'] != $_SESSION["u_id"]) {
            if ($ignorar != $value['1']) {
              $stmt_o->bind_param("ssssss", $user_1_nivel, $user_1, $value['1'], $tipo_n, $guia, $extra);
              $stmt_o->execute();
            }
          }
        }
      }
    }

    if ($valueParam == 'involved_users') {
      // seguir el id de la tarea/operacion y ejecutar el insert en el while de involucrados
      if ($tipo_n == '5') { // Se ejecuto una operación
        $stmt = mysqli_prepare($conexion, "SELECT DISTINCT(empresa_id) FROM `go_tareas_responsables` WHERE operacion='$guia' AND status='1'");
      } else { // Se ejecuto una tarea
        $stmt = mysqli_prepare($conexion, "SELECT DISTINCT(empresa_id) FROM `go_tareas_responsables` WHERE tarea='$guia' AND status='1'");
      }
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

          $array_users = usuarios_x_empresas($row['empresa_id']);
//
          foreach ($array_users as $item) {
            if ($item[1] == '1' || in_array($t_notiifacion, accessControl($item[0]))) {
              $stmt_o->bind_param("ssssss", $user_1_nivel, $user_1, $item[0], $tipo_n, $guia, $extra);
              $stmt_o->execute();
              # code...
            }
          }
        }
      }
      $stmt->close();
      return $stmt;
    }



    if ($valueParam != 'admin_users' && $valueParam != 'global_users' && $valueParam != 'involved_users') {
      if ($valueParam != $_SESSION["u_id"]) {
        $array_users = usuarios_x_empresas($valueParam);


        foreach ($array_users as $item) {
          if ($item[1] == '1' || in_array($t_notiifacion, accessControl($item[0]))) {
            # code...
            $stmt_o->bind_param("ssssss", $user_1_nivel, $user_1, $item[0], $tipo_n, $guia, $extra);
            $stmt_o->execute();


          }
        }

   
      }
    }
  }

  $stmt_o->close();
}



/**
 * Returns the number of rows that match the specified condition.
 *
 * @param string $condicion The condition to match against.
 * @return int The number of rows that match the condition.
 */
function contar($condicion)
{
  global $conexion;

  //$condicion = "SELECT count(*) FROM $table WHERE $condicion";
  $stmt = $conexion->prepare($condicion);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_row();
  $galTotal = $row[0];

  return $galTotal;
}




/**
 * Returns a Spanish-style date string from a given date.
 *
 * @param string $date A date in YYYY-MM-DD format.
 * @return string The date in Spanish style, for example "23 de febrero de 2023".
 */
function fechaCastellano($date)
{
  $fecha = substr($date, 0, 10);
  $numeroDia = date('d', strtotime($fecha));
  $dia = date('l', strtotime($fecha));
  $mes = date('F', strtotime($fecha));
  $anio = date('Y', strtotime($fecha));
  $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
  $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
  $nombredia = str_replace($dias_EN, $dias_ES, $dia);
  $meses_ES = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sept", "Oct", "Nov", "Dic");
  $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
  // return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;

  if (@strpos(' ', $date)) {
    $hora = explode(' ', $date)[1];
  } else {
    $hora = '';
  }
  // $hora = date('h:i a');
  return $numeroDia . " de " . $nombreMes . " del " . $anio . '. ' . $hora;
}



/**
 * Returns the trimester of a given month.
 *
 * @param int $month The month number (1-12), or null to use the current month
 * @return int The trimester number (1, 2, 3 or 4)
 */
function trimestre($mes = null)
{
  $mes = is_null($mes) ? date('m') : $mes;
  $trim = floor(($mes - 1) / 3) + 1;
  return $trim;
}


/**
 * Calculates the percentage change between two values.
 *
 * @param float $antes The original value.
 * @param float $ahora The updated value.
 * @return float The percentage change.
 */
function obtenerCambioPorcentaje($antes, $ahora)
{
  $diferencia = abs($antes - $ahora);

  $porcentaje = ((float)$diferencia * 100) / $antes; // Regla de tres
  $porcentaje = round($porcentaje, 0);  // Quitar los decimales

  if ($antes > $ahora) {
    return '-' . $porcentaje;
  } else {
    return $porcentaje;
  }
}


/*
Esta función se encarga de obtener el porcentaje de una cantidad en relación a un total.
La función acepta dos parámetros: la cantidad y el total.
La función primero verifica si el total es cero. En ese caso, se devuelve cero.
La función luego calcula el porcentaje utilizando la regla de tres y luego redondea los decimales.
La función finalmente devuelve el porcentaje.
 */


function obteneroPorcentaje($cantidad, $total)
{
  if ($total == 0) {
    return 0;
  }

  $porcentaje = ((float)$cantidad * 100) / $total; // Regla de tres
  $porcentaje = round($porcentaje, 0);  // Quitar los decimales

  return $porcentaje;
}

/**
Esta función se encarga de verificar si hay más de 24 horas entre dos fechas.
La función acepta dos parámetros: la hora de inicio y la hora de finalización.
La función crea dos objetos DateTime con las fechas de inicio y finalización.
La función luego utiliza la función diff () para obtener el intervalo entre las dos fechas.
La función finalmente verifica si el número de horas es mayor o igual a 24.
Si es verdadero, se devuelve verdadero, en caso contrario, se devuelve falso.
 */

function check_time_diff($start_time, $end_time)
{
  $datetime1 = new DateTime($start_time);
  $datetime2 = new DateTime($end_time);
  $interval = $datetime1->diff($datetime2);

  if ($interval->h > 24) {
    return false;
  } else {
    return true;
  }
}

function nombreUsuario($id)
{
  global $conexion;

  $stmt = mysqli_prepare($conexion, "SELECT u_nombre FROM `system_users` WHERE u_id = ?");
  $stmt->bind_param('s', $id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row['u_nombre'];
    }
  }
  $stmt->close();
}

/*
The function recortar_palabras takes a string as input and returns a string with the first 15 words and an ellipsis (...) if the number of words is greater than 15.
*/
function recortar_palabras($string)
{
  $palabras = explode(" ", $string);
  if (count($palabras) > 15) {
    $string = implode(" ", array_slice($palabras, 0, 15)) . "...";
  }
  return $string;
}


/*
It takes two arguments: a date and the number of days to add. It uses the PHP function strtotime to add the specified number of days to the given date, and then formats the result as a Y-m-d string. The function returns the new date.
*/


/*
The function addDaysToDate takes a date and the number of days to add as parameters and returns the new date.

The function uses the PHP function strtotime to add the number of days to the given date and returns the new date in the format Y-m-d.
*/
function addDaysToDate($date, $days){
  $newDate = date("Y-m-d", strtotime($date . " + " . $days . " days"));
  return $newDate;
}






/*The function user_activity takes two parameters, $accion and $detalle, and inserts the current user's information into the system_actividad table in the database.
* The function first retrieves the current user's information from the session variables u_id, u_nombre, and u_ente.
* It then creates a prepared statement to insert a new record into the system_actividad table with the user's information, the action taken, and the details of the action. The bind_param method is used to bind the user's input to the statement parameters, and the execute method is used to execute the statement and insert the new record.
* Finally, the function closes the statement.*/
function user_activity($accion, $detalle){
  $userId = $_SESSION["u_id"];
  $userName = $_SESSION["u_nombre"];
  $userEmpresa = $_SESSION["u_ente_id"];

  global $conexion;

  $stmt_o = $conexion->prepare("INSERT INTO system_actividad (user, name_user, user_empresa, accion, detalles) VALUES (?,?,?,?,?)");
  $stmt_o->bind_param("sssss",$userId, $userName, $userEmpresa, $accion, $detalle);
  $stmt_o->execute();
  $stmt_o->close();
}


function user_type_action($accion){
  switch ($accion) {
    case '1':
      return '<span class="badge bg-label-danger">Eliminó</span>';
      break;
    case '2':
      return '<span class="badge bg-label-success">Agregó</span>';
      break;
    case '3':
      return '<span class="badge bg-label-primary">Actualizó</span>';
      break;
  }
}
