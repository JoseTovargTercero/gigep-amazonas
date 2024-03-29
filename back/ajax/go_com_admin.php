<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"] == '1') {

  $user = $_SESSION["u_ente_id"];
  $i = $_GET["i"];
  $v = $_GET["v"];
  $veh = $_GET["veh"];




if ($v == '1') {


$stmt = mysqli_prepare($conexion, "SELECT system_users.u_ente, system_users.u_id, COUNT(*) as num_repeticiones FROM com_compras_estructura LEFT JOIN system_users ON system_users.u_id=com_compras_estructura.user_id WHERE compra_id=? GROUP BY user_id");
$stmt->bind_param('s', $i);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {

    echo '<tr>
    <td>
      <div class="d-flex justify-content-start align-items-center product-name">
        <div class="avatar-wrapper">          ';
          if (file_exists('../../assets/img/avatars/' . $row['u_id'] . '.png')) {
            echo ' 
            <div class="avatar avatar me-2 rounded-2 bg-label-secondary"><img src="../../assets/img/avatars/' . $row['u_id'] . '.png" alt="user profile" class="rounded-2"></div>          ';
          } else {
            echo '  <span class="avatar me-3 rounded-2 bg-label-danger">' . substr($row['u_ente'], 0, 1) . '</span>';
          }

          echo '</div>
        <div class="d-flex flex-column">
          <h6 class="text-body text-nowrap mb-0">'.$row['u_ente'].'</h6>
        </div>
      </div>
    </td>
    <td class="text-center"><span class="text-primary"><strong>'.$row['num_repeticiones'].'</strong> Insumo'.($row['num_repeticiones'] > 1 ? 's':'').'</span></td>

  </tr>';
}
}
$stmt->close();


}elseif ($v == '2') {
  if ($veh == '1') {
    $stmt = mysqli_prepare($conexion, "SELECT com_compras_estructura.cantidad_i, veh_partes.insumo, system_users.u_ente, system_users.u_id FROM com_compras_estructura 
    LEFT JOIN system_users ON system_users.u_id=com_compras_estructura.user_id
    LEFT JOIN veh_repuestos ON veh_repuestos.id=com_compras_estructura.insumo_id
    LEFT JOIN veh_partes ON veh_partes.id_i=veh_repuestos.repuesto
     WHERE compra_id=? ORDER BY user_id");
  }else {

    # code...
    $stmt = mysqli_prepare($conexion, "SELECT com_compras_estructura.cantidad_i, com_insumos.insumo, system_users.u_ente, system_users.u_id FROM com_compras_estructura 
    LEFT JOIN system_users ON system_users.u_id=com_compras_estructura.user_id
    LEFT JOIN com_insumos ON com_insumos.id_i=com_compras_estructura.insumo_id
     WHERE compra_id=? ORDER BY user_id");
  }
  
  $stmt->bind_param('s', $i);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
  
      echo '<tr>
      <td>
        <div class="d-flex justify-content-start align-items-center product-name">
        <div class="avatar-wrapper"> ';
          if (file_exists('../../assets/img/avatars/' . $row['u_id'] . '.png')) {
            echo ' 
            <div class="avatar avatar me-2 rounded-2 bg-label-secondary"><img src="../../assets/img/avatars/' . $row['u_id'] . '.png" alt="user profile" class="rounded-2"></div>';
          } else {
            echo '  <span class="avatar me-3 rounded-2 bg-label-danger">' . substr($row['u_ente'], 0, 1) . '</span>';
          }
          echo '</div><div class="d-flex flex-column">
            <h6 class="text-body text-nowrap mb-0">'.$row['u_ente'].'</h6>
          </div>
        </div>
      </td>
      <td><span class="text-primary"><strong>'.$row['insumo'].'</strong></span></td>
      <td class="text-center"><span class="text-primary"><strong>'.$row['cantidad_i'].'</strong></span></td>
  
    </tr>';
  }
  }
  $stmt->close();
  
  
  
  }elseif ($v == '3') {

    if ($veh == 1) {
      # code...
      $stmt = mysqli_prepare($conexion, "SELECT veh_partes.insumo, com_compras_estructura.insumo_id, SUM(com_compras_estructura.cantidad_i) AS total_quantity FROM com_compras_estructura
          LEFT JOIN veh_repuestos ON veh_repuestos.id=com_compras_estructura.insumo_id
    LEFT JOIN veh_partes ON veh_partes.id_i=veh_repuestos.repuesto
      WHERE compra_id=?
       GROUP BY com_compras_estructura.insumo_id");
    }else {
      $stmt = mysqli_prepare($conexion, "SELECT com_insumos.insumo, com_compras_estructura.insumo_id, SUM(com_compras_estructura.cantidad_i) AS total_quantity FROM com_compras_estructura
      LEFT JOIN com_insumos ON com_insumos.id_i=com_compras_estructura.insumo_id
      WHERE compra_id=?
       GROUP BY com_compras_estructura.insumo_id");
    }

  
    $stmt->bind_param('s', $i);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo '<tr>
        <td>'.$row['insumo'].'</td>
        <td class="text-center"><span class="text-primary"><strong>'.$row['total_quantity'].'</strong></span></td>
      </tr>';
    }
    }
    $stmt->close();
    }

} else {
  header("Location: ../../public/index.php");
}
