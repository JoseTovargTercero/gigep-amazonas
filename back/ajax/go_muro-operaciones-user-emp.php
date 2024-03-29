<?php 
require('../config/conexion.php');
require('../config/funcione_globales.php');





if ($_SESSION["u_nivel"] == 2 || $_SESSION["u_nivel"] == 3) {
  $emp = $_SESSION["u_ente_id"];
  $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_operaciones` 
  LEFT JOIN system_users ON system_users.u_id = go_operaciones.empresa_id
  WHERE empresa_id = ? ORDER BY id DESC");
  $stmt->bind_param('s', $emp);
}else {
  $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_operaciones`  
  LEFT JOIN system_users ON system_users.u_id = go_operaciones.empresa_id
  ORDER BY id DESC");
}


$empresa = '';


$stmt->execute();
$result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $id = $row['id'];
      $tareas = contar("SELECT count(*) FROM `go_tareas` WHERE id_operacion='$id' AND status='0'");
 
      if ($empresa != $row['u_ente']) {
        

        echo '<tr><td>
        <span class="d-flex justify-content-between align-items-center bb-1">
          <a class="d-flex">';



        echo '
          <strong>'.$row['u_ente'].'</strong>
        </a>';
  
   
          echo '</span></td></tr>';





        $empresa = $row['u_ente'];
      }




      echo '
      <tr>
      
      <td class="list-group-item-action d-flex justify-content-between align-items-center pointer bb-1" >
        <a href="go_operacion?i='.$row['id'].'">';
        switch ($row['tipo_p']) {
          case ('1'):
            echo '<span title="Pla sectorial" class="badge badge-center me-3 bg-label-success"><i>S</i></span>';
            break;
          case ('2'):
            echo '<span title="Pla estratégico" class="badge badge-center me-3 bg-label-primary"><i>E</i></span>';
            break;
          case ('3'):
            echo '<span title="Pla de contingencia" class="badge badge-center me-3 bg-label-warning"><i>C</i></span>';
            break;
        }

      echo '
          '.$row['nombre'].'
        </a>';

        if ($tareas != '0') {
          echo '<span class="badge bg-primary">'. $tareas.'</span>';
        }
        echo '</td>';
  }
}

?>