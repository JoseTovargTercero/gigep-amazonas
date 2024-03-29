<?php
include('../config/conexion.php');
if ($_SESSION["u_nivel"]) {
  require('../config/funcione_globales.php');

  $user = $_SESSION["u_ente_id"];
  $id = $_GET["i"];



  /* VERIFICAR EL TIPO DE COMPRA */
  $stmt = mysqli_prepare($conexion, "SELECT * FROM `com_compras` WHERE id = ?");
  $stmt->bind_param('s', $id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $veh = $row['veh'];
    }
  }
  $stmt->close();
  /* VERIFICAR EL TIPO DE COMPRA */



  $count = 1;
  if ($veh == '1') {
  # code...
  
    $stmt = mysqli_prepare($conexion, "SELECT veh_partes.insumo, com_compras_estructura.cantidad_i FROM `com_compras_estructura`
    LEFT JOIN veh_repuestos ON veh_repuestos.id=com_compras_estructura.insumo_id
    LEFT JOIN veh_partes ON veh_partes.id_i=veh_repuestos.repuesto


    WHERE com_compras_estructura.compra_id = ? AND com_compras_estructura.user_id='$user'");
  }else {
    $stmt = mysqli_prepare($conexion, "SELECT com_insumos.insumo, com_compras_estructura.cantidad_i FROM `com_compras_estructura`
        LEFT JOIN veh_repuestos ON veh_repuestos.id=com_compras_estructura.insumo_id
    LEFT JOIN veh_partes ON veh_partes.id_i=veh_repuestos.repuesto
    WHERE com_compras_estructura.compra_id = ? AND com_compras_estructura.user_id='$user'");
  }



  $stmt->bind_param('s', $id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
     echo '<tr>
     <td>'.$count++.'</td>
     <td>'.$row['insumo'].'</td>
     <td>'.$row['cantidad_i'].'</td>
     <td class="text-center"><div class="cuadro"></div></td>
     </tr>';
    }
  }
  $stmt->close();
}
