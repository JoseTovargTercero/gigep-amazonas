<?php
include('../config/conexion.php');
if ($_SESSION["u_nivel"]) {


  $r = $_GET["r"];


  $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_tareas_responsables` WHERE id = ?");
  $stmt->bind_param('s', $r);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<div class="d-flex justify-content-between">
      <img onerror="this.onerror=null; this.src=\'../../assets/img/avatars/default.jpg\'"  src="../../assets/img/avatars/'.$row['empresa_id'].'.png" alt="Avatar" class="rounded-circle me-3" height="60px" width="60px"/>
      <div style="width: 85%;">
        <h3>'.$row['empresa'].'</h3>
        <div style="    background-color: #43597117;padding: 12px;border-radius: 7px;">
        <strong>Responsabilidad: </strong>
        '.$row['responsabilidad'].'
        <br>
          </div>
        </div>  
    </div>';

      }
    }

  $stmt->close();


}else {
  header("Location: ../../public/index.php");
}

?>