<?php
include('../config/conexion.php');
include('../config/funcione_globales.php');
error_reporting(0);





if ($_SESSION["u_nivel"] && isset($_POST["ubicacion"])) {

  $res_car_nombre = $_POST["res_car_nombre"];
  $res_car_descripcion = $_POST["res_car_descripcion"];
  $ubicacion = $_POST["ubicacion"];
  $fecha = $_POST["fecha"];
  $i = $_POST["i"];
  $map = $_POST["mapInfo"];
  
  $empresasinvs = str_replace('undefined', '', $_POST["empresasinvs"]);
  $recursosDisponibles = str_replace('undefined', '', $_POST["recursosDisponibles"]);
  $r_vehiculos = str_replace('undefined', '', $_POST["r_vehiculos"]);
  $condicionesAdversas = str_replace('undefined', '', $_POST["condicionesAdversas"]);
  
  $res_car_unidad = $_POST["res_car_unidad"];
  $res_car_tipo_ejecucion = $_POST["res_car_tipo_ejecucion"];
  $res_car_mt_1 = $_POST["res_car_mt_1"];
  $res_car_mt_2 = $_POST["res_car_mt_2"];
  $res_car_mt_3 = $_POST["res_car_mt_3"];
  $res_car_mt_4 = $_POST["res_car_mt_4"];
  $user_n = $_POST["user_n"];
  $fechaFin = $_POST["fechaFin"];
  
  $estado = $_POST["estado"];
  $municipio = $_POST["municipio"];
  $parroquia = $_POST["parroquia"];
  $comuna = $_POST["comuna"];
  $comunidad = $_POST["comunidad"];
  
  $instancia = $_POST["instancia"];
  $otra_comunidad = $_POST["otra_comunidad"];





  
  

  if($comunidad == 'add-item'){
    // registrar la nueva comunidad y traer el codigo

    $stmt = mysqli_prepare($conexion, "SELECT * FROM `local_comunidades` WHERE id_comuna = ? ORDER BY id_consejo DESC LIMIT 1");
    $stmt->bind_param('s', $comuna);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $last_C = substr($row['id_consejo'], -2) + 1; 
      }
    }
    $stmt->close();
    if ($last_C < 10) {
      $last_C = '0'.$last_C;
    }

    $comunidad = $comuna.$last_C;
    $nueva_comunidad = strtoupper($otra_comunidad);

    $ur = $_SESSION["u_id"];

    $stmt_o = $conexion->prepare("INSERT INTO local_comunidades (nombre_c_comunal, id_estado, id_municipio, id_parroquia, id_comuna, id_consejo, id_user) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt_o->bind_param("sssssss", $nueva_comunidad, $estado, $municipio, $parroquia, $comuna, $comunidad, $ur);
    $stmt_o->execute();
    $stmt_o->close();


  }


  $vehiculos = $_POST["vehiculos"];
  $condicion_vehiculos = $_POST["condicion_vehiculos"];

  // Sacar el id del plan 
  $stmt = mysqli_prepare($conexion, "SELECT go_operaciones.id_p, go_operaciones.id, go_operaciones.empresa_id, system_users.u_ente  FROM `go_operaciones` 
  LEFT JOIN system_users ON system_users.u_id = go_operaciones.empresa_id
  WHERE id = ?");
  $stmt->bind_param('s', $i);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
    $id_plan = $row["id_p"];
    $id_o = $row["id"];
    $empresa_id = $row["empresa_id"];
    $empresa_name = $row["u_ente"];
    }
  }
  $stmt->execute();
  $stmt->close();
  // Sacar el id del plan

  $date = explode('-', $fecha);
  $anio = $date[0];
  $mes = $date[1];

  if ($mes >= 10) {
    $trimestre = '4';
  }elseif ($mes >= 7) {
    $trimestre = '3';
  }elseif ($mes >= 4) {
    $trimestre = '2';
  }else {
    $trimestre = '1';
  }

  // Registrar la nueva tarea 
  $usarios_id = $_SESSION["u_id"]; // usuario que registra, independiente de quien sea
  

  if ($_SESSION["u_nivel"] == 1) {
    $tipo_registro = '1'; // tipo de registro, asignado
    $responsable_ente_id = $empresa_id;
  }else {
    $tipo_registro = '2'; // tipo de registro, tomado
    $responsable_ente_id = $_SESSION["u_ente_id"];
  }
  



  $stmt_o = $conexion->prepare("INSERT INTO go_tareas (id_operacion, id_plan, tarea, descripcion, fecha, fechaFin, trimestre, ano, ubicacion, cords, tipo_registro, usarios_id, responsable_ente_id, unidad_medida, tipo_ejecucion, mt_1, mt_2, mt_3, mt_4,vehiculos,
  condicion_vehiculos,estado, municipio, parroquia, comuna, comunidad) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
  $stmt_o->bind_param("ssssssssssssssssssssssssss", $i, $id_plan, $res_car_nombre, $res_car_descripcion, $fecha, $fechaFin, $trimestre, $anio, $ubicacion, $map, $tipo_registro, $usarios_id, $responsable_ente_id, $res_car_unidad, $res_car_tipo_ejecucion, $res_car_mt_1, $res_car_mt_2, $res_car_mt_3, $res_car_mt_4,$vehiculos,$condicion_vehiculos, $estado, $municipio, $parroquia, $comuna, $comunidad);
  $stmt_o->execute();


  if ($stmt_o) {
    $id_r = $conexion->insert_id;
    user_activity(2, 'Creo una nueva tarea');
  }else {
    echo "error";
  }
  $stmt_o->close();
  

  $stmt_condicio = $conexion->prepare("INSERT INTO go_tareas_condiciones (tarea, condicion) VALUES (?, ?)");
  $stmt_recursos = $conexion->prepare("INSERT INTO go_tareas_recursos (tarea, recurso, status) VALUES (?, ?, ?)");
  $stmt_responsa = $conexion->prepare("INSERT INTO go_tareas_responsables (tarea, operacion, empresa, empresa_id, responsabilidad, status) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt_vehiculo = $conexion->prepare("INSERT INTO veh_vehiculos_tarea (vehiculo, tarea, fecha, status) VALUES (?, ?, ?, ?)");





  if ($_SESSION["u_nivel"] == '1') {
      notificar([$responsable_ente_id], 2, $id_r);
  } 

  if ($vehiculos == 'Necesarios' && $condicion_vehiculos == 'No') {
    notificar(['admin_users', 'involved_users'], 24, $id_r);
  }
  // Responsables
  if ($empresasinvs != '') {
    $empresasinvs = substr($empresasinvs, 0, -1);
    $empresasinvs = explode('/', $empresasinvs);
    foreach ($empresasinvs as $array_item) {

      $item = explode('*', $array_item);

      if ($user_n == $item[0]) {
        $st = '1';
      }else {
        $st = '0';
      }


      $stmt_responsa->bind_param("ssssss", $id_r, $id_o, $item[1], $item[0], $item[2], $st);
      $stmt_responsa->execute();
      $id_res = $conexion->insert_id;

      // SE ENVIA NOTICIA AL $item[0]
      notificar([$item[0]], 14, $id_res);

      if (!$stmt_responsa) {
        echo 'error: responsa...';
      }
    }
  }



  // Vehiculos
  if ($r_vehiculos != '') {

    $stmtaaa = mysqli_prepare($conexion, "SELECT * FROM `veh_vehiculos` WHERE id = ?");

    $r_vehiculos = explode(',', $r_vehiculos);

    foreach ($r_vehiculos as $array_item) {
      $stmtaaa->bind_param('s', $array_item);
      $stmtaaa->execute();
      $resultaaaa = $stmtaaa->get_result();
      if ($resultaaaa->num_rows > 0) {
        while ($rowaaa = $resultaaaa->fetch_assoc()) {
          $empresa_id_v = $rowaaa['empresa_id'];
         }
      }


      if ($_SESSION["u_nivel"] == 1) {
        $st_vehiculo = '0';
        notificar([$empresa_id_v], 27, $array_item, $id_r);
      } else {
        if ($_SESSION["u_ente_id"] == $empresa_id_v) {
          $st_vehiculo = '1';
        } else {
          notificar([$empresa_id_v], 27, $array_item, $id_r);
          $st_vehiculo = '0';
        }
      }

      $stmt_vehiculo->bind_param("ssss", $array_item, $id_r, $fecha, $st_vehiculo);
      $stmt_vehiculo->execute();
      if (!$stmt_vehiculo) {
        echo 'error: recursos...';
      }

 
    }
    $stmtaaa->close();

  }
  // Recursos
  if ($recursosDisponibles != '') {
    $recursosDisponibles = substr($recursosDisponibles, 0, -1);
    $recursosDisponibles = explode('/', $recursosDisponibles);
    foreach ($recursosDisponibles as $array_item) {
      $item = explode('*', $array_item);
      $stmt_recursos->bind_param("sss", $id_r, $item[0], $item[1]);
      $stmt_recursos->execute();
      if (!$stmt_recursos) {
        echo 'error: recursos...';
      }
    }
  }
  //Condiciones
  if ($condicionesAdversas != '') {
    $condicionesAdversas = substr($condicionesAdversas, 0, -1);
    $condicionesAdversas = explode('/', $condicionesAdversas);
    foreach ($condicionesAdversas as $item) {
      $stmt_condicio->bind_param("ss", $id_r, $item);
      $stmt_condicio->execute();
      if (!$stmt_condicio) {
        echo 'error: condicio...';
      }
    }
  }


  $stmt_condicio->close();
  $stmt_recursos->close();
  $stmt_responsa->close();
  $stmt_vehiculo->close();

  echo 'ok';
}else {
  header("Location: ../../public/index.php");
}
?>