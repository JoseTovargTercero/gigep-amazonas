<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"]) {

  $vehiculo = $_POST["vehiculo"];
  $falla = $_POST["falla"];
  $empresa_id = $_SESSION["u_ente_id"];
  $insumos = str_replace('undefined', '', $_POST["insumos"]);
  
  $operativo_real2 = $_POST["operativo_real2"];
  $mano_obra2 = $_POST["mano_obra2"];




  
  if ($operativo_real2 == 'Si') {
    $operativo_real2 = 2;
  }else{
    $operativo_real2 = 1;
  }




    $stmt = mysqli_prepare($conexion, "SELECT * FROM `veh_vehiculos` WHERE id = ?");
    $stmt->bind_param('s', $vehiculo);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        if ($row['empresa_id'] == $_SESSION["u_ente_id"]) {
          

          $stmt_o = $conexion->prepare("INSERT INTO veh_reporte_fallas (vehiculo, falla, gravedad) VALUES (?, ?, ?)");
          $stmt_o->bind_param("sss", $vehiculo, $falla, $operativo_real2);
          $stmt_o->execute();


        
          if ($stmt_o) {
            $id_r = $conexion->insert_id;
          user_activity(2, 'Registró una falla de un vehículo');

            if ($insumos != '') {
              $stmt_insumos = $conexion->prepare("INSERT INTO veh_repuestos (repuesto, cantidad, falla_id, empresa_id, precio) VALUES (?, ?, ?, ?, ?)");
              $insumos = substr($insumos, 0, -1);
              $insumos = explode(';', $insumos);
              foreach ($insumos as $items) {
                $item = explode('~', $items);
                $stmt_insumos->bind_param("sssss", $item[0], $item[1], $id_r, $empresa_id, $item[3]);
                $stmt_insumos->execute();
                if (!$stmt_insumos) {
                  echo 'error: condicio...';
                }
              }
            }
          }
          
          if ($operativo_real2 == 2) {
            notificar(['admin_users'], 23, $vehiculo);
          }else {
            notificar(['admin_users'], 30, $vehiculo);
          }
        }
      }
    }



    
    $stmt_obra = $conexion->prepare("INSERT INTO veh_repuestos (repuesto, cantidad, falla_id, empresa_id, precio, tipo) VALUES ('0', '1', ?, ?, ?, '2')");
    $stmt_obra->bind_param("sss", $id_r, $empresa_id, $mano_obra2);
    $stmt_obra->execute();
    $stmt_obra->close();



  

} else {
  header("Location: ../../public/index.php");
}
