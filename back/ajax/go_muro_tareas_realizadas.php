<?php
include('../config/conexion.php');
include('../config/funcione_globales.php');


if ($_SESSION["u_nivel"]) {


  $contador = 1;

  $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_tareas` WHERE status='1' OR status='2' ORDER BY id_tarea DESC");
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

      $id = $row['id_tarea'];

      if ($row['tipo_ejecucion'] == '1') {
        $photo = $id . '_1';
      } else {
        if ($row['mr_4'] != '') {
          $photo = 't4_' . $id . '_1';
        } elseif ($row['mr_3'] != '') {
          $photo = 't3_' . $id . '_1';
        } elseif ($row['mr_2'] != '') {
          $photo = 't2_' . $id . '_1';
        } elseif ($row['mr_1'] != '') {
          $photo = 't1_' . $id . '_1';
        }
      }


      if ($contador != 3) {
        if ($contador == 1) {
          $col = 'col-lg-6';
        } else {
          $col = 'col-lg-4';
        }



        echo '<div class="' . $col . ' pointer">
        <div class="card bg-primary text-white mb-3 history" style="background-image: url(\'../../assets/img/tareas/' . $photo . '.png\');">
          <div class="card-body history-body" style="padding: 14px;">
            <h5 class="card-title text-white">'.$row['tarea'].'</h5>
            <small class="card-text">'.recortar_palabras($row['descripcion']).'</small>
          </div>
        </div>
      </div>';
      } else {
        echo '<div class="col-lg-2 pointer">
        <h5 class="text-white info-extras">
          <i class=\'bx bx-list-plus\' style="font-size: 28px;"></i>
        </h5>
        <div class="card bg-primary text-white mb-3 history history-body-extras" style="background-image: url(\'../../assets/img/tareas/' . $photo . '.png\'); filter: contrast(0.5); opacity: 0.6;">
          <div class="card-body history-body  d-flex">
          </div>
        </div>
  
      </div>';
      }
      $contador++;
    }
  } else {
    echo '<div class="col-lg-12">
    <div class="card" style="    overflow: hidden;">
      <div class="d-flex pt-3 row">
        <div class="col-8">
          <div class="card-body">
            <h3 class="card-title mb-1 text-nowrap">Ningún resultado!</h3>
            <p class="d-block mb-3 text-nowrap">Aquí se mostraran las tareas ejecutadas!</p>
          </div>
        </div>
        <div class="col-4  ps-0">
          <img src="../../assets/img/illustrations/no_result.jpg" height="120" class="rounded-start" alt="View Sales">
        </div>
      </div>
    </div>
  </div>';
  }
  $stmt->close();
} else {
  header("Location: ../../public/index.php");
}
