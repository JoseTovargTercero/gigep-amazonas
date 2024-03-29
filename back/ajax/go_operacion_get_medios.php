<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"]) {



  
  $e = $_GET["e"]; // TAREA/OPERACION/CHAT
  $fecha = $_GET["fecha"]; // TAREA/OPERACION/CHAT



  if ($_SESSION["u_nivel"] == 1) {

    $op = $_GET["op"]; // TAREA/OPERACION/CHAT

        
    $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_operaciones` WHERE id = ?");
    $stmt->bind_param('s', $op);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {

        $empresa = $row["empresa_id"]; 
    }
    }
    $stmt->close();



  }else {
    $empresa = $_SESSION["u_ente_id"]; 
  }



  $condicion = " WHERE empresa_id='$empresa'";
 
  if ($e != '') {
    $empresas_i = explode(',', $e);

    foreach ($empresas_i as $value) {
      $condicion .= " OR empresa_id='$value'"; 
    }
  }


  
/*
 LEFT JOIN veh_vehiculos_tarea ON veh_vehiculos_tarea.vehiculo=veh_vehiculos.id
  LEFT JOIN go_tareas ON go_tareas.id_tarea=veh_vehiculos_tarea.tarea
*/


      $stmtax = mysqli_prepare($conexion, "SELECT * FROM `veh_vehiculos_tarea` WHERE fecha = ? AND vehiculo=? AND status='0'");





      $stmta = mysqli_prepare($conexion, "SELECT * FROM `veh_reporte_fallas` WHERE vehiculo = ? AND status='0'");

      /* SE REGISTRA EN LA TABLA DE MENSAJES PENDIENTES AL RESP DE LA OPERACION */
      $stmt = mysqli_prepare($conexion, "SELECT veh_vehiculos.id, veh_vehiculos.marca, veh_vehiculos.modelo, veh_vehiculos.placa, system_users.u_ente, veh_vehiculos.tipo_vehiculo FROM `veh_vehiculos`
  LEFT JOIN system_users ON system_users.u_id=veh_vehiculos.empresa_id
 
      $condicion ORDER BY veh_vehiculos.empresa_id");
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $id = $row['id'];
          echo '  <tr>
          <td>
          <a class="d-flex flex-column text-black" href="veh_vehiculo?i='.$id.'" target="_blank">
          <span class="fw-medium mb-0">'.$row['marca'].'</span><small class=""text-muted>'.$row['modelo'].'</small></a></td>
          <td class="text-center">'.$row['placa'].'<br><small class="text-muted">'.$row['u_ente'].'</small></td>
          <td></td>
          <td>';

          $stmta->bind_param('s', $id);
          $stmta->execute();
          $resulta = $stmta->get_result();
          if ($resulta->num_rows > 0) {
            echo '<span class="badge rounded bg-label-danger" >Inoperativo</span>';
          }else {
            echo '<span class="badge rounded bg-label-success" >Operativo</span>';
          }



          $stmtax->bind_param('ss', $fecha, $id);
          $stmtax->execute();
          $resultaX = $stmtax->get_result();
          if ($resultaX->num_rows > 0) {
            $s = 's';
          }else {
            $s = 'n';
          }

          echo '</td>
          <td>

           <button type="button" id="btn_'.$id.'" class="btn btn-icon btn-sm btn-secondary" onclick="vehiculo(\''.$id.'\', \''.$s.'\')">
                <span class="tf-icons bx bx-minus"></span>
              </button>
          
          </td>
        </tr>
        ';
        }
      }
      $stmt->close();
      /* SE REGISTRA EN LA TABLA DE MENSAJES PENDIENTES AL RESP DE LA OPERACION */

} else {
  header("Location: ../../public/index.php");
}
