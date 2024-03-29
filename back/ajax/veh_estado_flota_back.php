
<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"]) {

  $vehiculo = $_GET["v"];




  $stmt = mysqli_prepare($conexion, "SELECT system_users.u_ente, veh_vehiculos.id, veh_vehiculos.marca, veh_vehiculos.modelo, veh_vehiculos.valor, veh_vehiculos.placa, veh_vehiculos.ano, veh_vehiculos.serial_carroceria, veh_vehiculos.serial_motor, veh_vehiculos.condicionMotor, veh_vehiculos.nombreMotor FROM `veh_vehiculos` 
  LEFT JOIN system_users ON system_users.u_id = veh_vehiculos.empresa_id
  WHERE id = ?");
  $stmt->bind_param('s', $vehiculo);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<div><center>
        <p><b>'.$row['marca'].' '.$row['modelo'].'</b></p>';
      
      
      if (file_exists('../../assets/img/vehiculos/' . $row['id'] . '.png')) {
        echo ' <img class="imagenTop" height="150px"  src="../../assets/img/vehiculos/' . $row['id'] . '.png" alt="Imagen vehículo">';
      } else {
        echo '  <img class="imagenTop" height="150px" src="../../assets/img/vehiculos/default.avif" alt="Imagen vehículo">';
      }

      echo '
      <p><b>(Costo del bien: '.number_format($row['valor'], 0, ',', '.').'$)</b></p>
      </center>
      </div>
      
      <p style=" text-decoration: underline; margin-top: 35px; font-weight: bold">DATOS DEL VEHÍCULO:</p>

      <p style="text-transform:uppercase"><b>VEHÍCULO PROPIEDAD DE</b>: ' . $row['u_ente'] . '. <b>MARCA: </b> '.$row['marca'].' <b>MODELO: </b>'.$row['modelo'].' <b>PLACA: </b>'.$row['placa'].' <b>AÑO: </b>'.$row['ano'].' <b>SERIAL DE CARROCERÍA: </b>'.$row['serial_carroceria'].' <b>SERIAL DE MOTOR: </b>'.$row['serial_motor'].'. '.($row['condicionMotor'] == 'Adaptado' ? '(VEHÍCULO CON MOTOR ADAPTADO '.$row['nombreMotor'].').':'').'<br>
      <br>

      <b style="text-decoration: underline;">OBSERVACIONES: </b>
      </p>
      ';

    }
  }
  $stmt->close();



  $totalCost = 0;
  $fallas = array();

  $stmta = mysqli_prepare($conexion, "SELECT id_r, falla, reporte FROM `veh_reporte_fallas` WHERE vehiculo = ? AND status='0' ORDER BY reporte DESC");
  $stmta->bind_param('s', $vehiculo);
  $stmta->execute();
  $resulta = $stmta->get_result();
  if ($resulta->num_rows > 0) {
    while ($row = $resulta->fetch_assoc()) {
      $id = $row['id_r'];

      echo ' <p>'.$row['falla'].'
              <b>Fecha de reporte</b>: ' . fechaCastellano($row['reporte']).'</p>';

      array_push($fallas, $id);

    }
  }
  $stmta->close();
  echo "<p style='text-decoration: underline;'><b>REPUESTOS NECESARIOS Y MANO DE OBRA:</b></p>";


  $stmt = mysqli_prepare($conexion, "SELECT veh_repuestos.cantidad, veh_partes.insumo, veh_repuestos.precio, veh_repuestos.repuesto FROM `veh_repuestos`
  LEFT JOIN veh_partes ON veh_partes.id_i = veh_repuestos.repuesto
   WHERE falla_id = ? ORDER BY veh_repuestos.tipo");  


  foreach ($fallas as $item) {



  $stmt->bind_param('s', $item);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    echo '<ul  style="margin-bottom: 25px">';
    while ($row = $result->fetch_assoc()) {

      $repuesto = ($row['repuesto'] == '0' ? 'Mano de Obra' : $row['insumo']);
      echo '<li style="display: flex; justify-content:space-between !important">
              <span><strong>(X' . $row['cantidad'] . ')</strong> ' . $repuesto . '</span>
              <span><b>' . $row['precio'] . '$</b></span>
            </li>';

            $totalCost += $row['precio'] * $row['cantidad'];
    }
    echo '</ul>';
  }

  }

  $stmt->close();


  echo '<p style="text-align: center; font-weight: bold; margin-top: 35px">Total.................................................'.$totalCost.'$</p>';


} else {
  header("Location: ../../public/index.php");
}


?>


