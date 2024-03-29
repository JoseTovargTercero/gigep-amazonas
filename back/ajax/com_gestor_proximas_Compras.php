<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"]) {

  if ($_GET["v"] == 't') {

    $ente = $_SESSION["u_ente_id"];
    $stmt = mysqli_prepare($conexion, "SELECT * FROM `com_compras` WHERE status='0' OR status='1' ORDER BY fecha ASC");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $idC = $row['id'];
        $user = $row['user'];
        $productos = contar("SELECT count(*) FROM `com_compras_estructura` WHERE `compra_id`='$idC' AND user_id='$ente'");

        echo '   <tr class="odd">

      <td>
      <div class="d-flex justify-content-start align-items-center user-name">
      <div class="avatar-wrapper">
      <div class="avatar me-2">' . ($productos == '0' ? '<span class="avatar-initial rounded-circle bg-label-danger"><i class="bx bx-x"></i></span>' : '<span class="avatar-initial rounded-circle bg-label-primary"><i class="bx bx-check"></i></span>') . '
      </div></div><div class="d-flex flex-column"><span class="emp_name text-truncate">' . $row['nombre'] . '</span><small class="emp_post text-truncate text-muted">' . ($productos == '0' ? '<span class="text-muted">Sin insumos </span>' : '<span class="text-muted">'.$productos.' insumos pedidos</span>') . '</small></div></div></td>



      <td class="text-nowrap">' . fechaCastellano($row['fecha']) . '
      <br>';


      if ($row['id_compra_periodica'] !=  '0') {
        echo '<small class="text-primary">'.($row['tipo'] == '2' ? 'Compra quincenal' : 'Compra Mensual') .'</small>';
      }else {
        echo '<small class="text-muted">Compra única</small>';
      }

      echo '
      </td>
     
      <td><div class="d-flex flex-column"><span class="fw-medium">' . ($row['status'] == '0' ? '<span class="badge bg-label-success">Abierta</span>' : '<span class="badge bg-label-dark">Cerrada</span>') . '</span></div></td>


      <td class="text-center">
';

if ($row['status'] == '0') {
  echo '   <div class="dropdown">
  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
  <div class="dropdown-menu">
  <a class="dropdown-item pointer"  onclick="showModalCompraPeriodica(\'' . $row['id'] . '\')" title="Se aplicaran las configuraciones establecidas para la compra periódica"><i class="bx bx bx-cog me-1"></i> Modificar insumos requeridos</a>
  </div></div>';
}
      
   echo '
    

     </td>
      </tr>';
      }
    }
    $stmt->close();
  } elseif ($_GET["v"] == 'p') {
    $ente = $_SESSION["u_ente_id"];

    $p = 1;
    $stmt = mysqli_prepare($conexion, "SELECT * FROM `com_compras` WHERE status='0' OR status='1' ORDER BY fecha ASC LIMIT 2");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $idC = $row['id'];
        $user = $row['user'];
        $productos = contar("SELECT count(*) FROM `com_compras_estructura` WHERE `compra_id`='$idC'  AND user_id='$ente'");
        if ($p == 1) {
          $titulo = '';
        }else {
          $titulo = 'Segunda ';
        }
        $p++;


        if ($productos > 0) {
          echo '  <div class="col-lg-6 mb-3">
          <div class="card bg-label-primary h-100">
          <div class="card-body d-flex justify-content-between">
            <div class="mb-0  d-flex flex-column justify-content-between text-start">
              <div class="card-title">
                <h4 class="text-primary mb-2">'.$titulo.'Compra mas cercana</h4>
                <p class="text-body app-academy-sm-60 app-academy-xl-100">
                ' . $row['nombre'] . '. Fecha: <strong>' . fechaCastellano($row['fecha']) . '</strong> <br>
                <small class="text-muted">('.$productos.') insumos pedidos.</small>
                </p>
              </div>';

              if ($row['status'] == '0') {
                echo '<div class="mb-0"><button class="btn btn-primary"  onclick="showModalCompraPeriodica(\'' . $row['id'] . '\')">Modificar compra</button></div>';
              }else {
                echo 'Compra cerrada';
              }
            
          echo '</div>
          <div class="-academy-sm-40 d-flex justify-content-center justify-content-sm-end h-px-150 mb-3 mb-sm-0">
            <img class="img-fluid rounded scaleX-n1-rtl" src="../../assets/img/illustrations/bolsa2.png" alt="Compra configurada">
          </div>
          </div>
          </div>
          </div>';
        }else {
          echo ' 
          <div class="col-lg-6 mb-3">
          <div class="card bg-label-danger h-100">
            <div class="card-body d-flex justify-content-between">
              <div class="mb-0  d-flex flex-column justify-content-between text-start">
                <div class="card-title">
                  <h4 class="text-danger mb-2">'.$titulo.'Compra mas cercana</h4>
                  <p class="text-body app-academy-sm-60 app-academy-xl-100">
                  ' . $row['nombre'] . '. Fecha: <strong>' . fechaCastellano($row['fecha']) . '
                  </strong> <br>
                  <small class="text-muted">Sin insumos pedidos</small>
                  </p>
                </div>';
                if ($row['status'] == '0') {
                  echo '<div class="mb-0"><button class="btn btn-danger"  onclick="showModalCompraPeriodica(\'' . $row['id'] . '\')">Agregar insumos</button></div>';
                }else {
                  echo 'Compra cerrada';
                }
                
             echo ' </div>
              <div class="-academy-sm-40 d-flex justify-content-center justify-content-sm-end h-px-150 mb-3 mb-sm-0">
                <img class="img-fluid rounded scaleX-n1-rtl" src="../../assets/img/illustrations/bolsa1.png" alt="Compra sin configurar">
              </div>
            </div>
          </div>
          </div>
          
          ';
        }

      }
    }
  }
} else {
  header("Location: ../../public/index.php");
}
