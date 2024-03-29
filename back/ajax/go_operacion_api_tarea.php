<?php
include('../config/conexion.php');
include('../config/funcione_globales.php');


if ($_SESSION["u_nivel"]) {
  $tarea = $_POST["tarea"];

  $trimestreActual = trimestre();

  $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_tareas` WHERE id_tarea = ?");
  $stmt->bind_param('s', $tarea);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $tipo_ejecucion = $row['tipo_ejecucion'];

      echo $row['tipo_ejecucion'].'*';
      echo $row['unidad_medida'].'*';
      $trimestresDisponibles = '<option value="">Seleccione</option>';

      if ($tipo_ejecucion  == '2') {
        
        $trimestresResult = ['', $row['mr_1'], $row['mr_4'], $row['mr_3'], $row['mr_4']];
        for ($i=1; $i <= $trimestreActual; $i++) { 
          
          if ($trimestresResult[$i] == '') {
            $trimestresDisponibles .= '<option value="'.$i.'">Trimestre '.$i.'</option>';
          }

        }
        echo $trimestresDisponibles.'*';
        echo $row['mr_1'].'/'.$row['mr_2'].'/'.$row['mr_3'].'/'.$row['mr_4'].'*';
        echo $row['mt_1'].'/'.$row['mt_2'].'/'.$row['mt_3'].'/'.$row['mt_4'].'*';
      }
    }
  }
  $stmt->close();





}else {
  header("Location: ../../public/index.php");
}
