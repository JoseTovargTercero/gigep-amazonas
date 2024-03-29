<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"]) {

  if ($_GET["v"] == 1) {
  $user = $_SESSION["u_ente_id"];

  $stmt_p = mysqli_prepare($conexion, "SELECT com_grupo_insumos.cantidad, com_insumos.insumo, com_insumos.id_i, com_grupo_insumos.id_g AS id_i_g FROM `com_grupo_insumos` 
  LEFT JOIN com_insumos ON com_insumos.id_i = com_grupo_insumos.insumo
  WHERE grupo=?");

  $stmt = mysqli_prepare($conexion, "SELECT * FROM `com_grupo` WHERE user='$user' ORDER BY nombre ASC");
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
     $id = $row['id'];


      echo ' <div class="accordion-item">
      <h2 class="accordion-header">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion_'.$id.'" aria-expanded="false">
          '.$row['nombre'].'
        </button>
      </h2>
      <div id="accordion_'.$id.'" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
        <div class="accordion-body py-3">';




        $stmt_p->bind_param('s', $id);
        $stmt_p->execute();
        $result_p = $stmt_p->get_result();
        if ($result_p->num_rows > 0) {
          while ($r = $result_p->fetch_assoc()) {
            echo '<div class="list-group-item list-group-item-action d-flex justify-content-between mb-2">
            <div class="li-wrapper d-flex justify-content-start align-items-center">
            <span class="badge badge-center bg-label-secondary me-2 fw-bold">'.$r['cantidad'].'</span>  
              <div class="list-content">
                <span class="mb-1">'.$r['insumo'].'</span>
              </div>
            </div>
            <i class="bx bx-trash pointer" onclick="eliminarInsumo(\''.$r['id_i_g'].'\')"></i>
          </div>';
          }

          
        }
        echo '<hr><div class="list-group-item list-group-item-action d-flex justify-content-between mb-2 add-item"  onclick="agregarInsumoAlGrupo(\''.$id.'\')">
        <div class="li-wrapper d-flex justify-content-start align-items-center">
        <span class="badge badge-center bg-primary me-2"><i class="bx bx-plus"></i></span>  
          <div class="list-content " >
            <span class="mb-1 pointer add-item text-primary">AGREGAR INSUMO</span>
          </div>
        </div>
      </div>';

        echo '</div>
      </div>
    </div>';
    
    

    }
  }
  $stmt->close();

}elseif ($_GET["v"] == '2') {
 

  echo '<small class="text-muted">Grupo de insumos</small> <br>';

  $user = $_SESSION["u_ente_id"];

  $stmt_p = mysqli_prepare($conexion, "SELECT com_grupo_insumos.cantidad, com_insumos.insumo, com_insumos.id_i, com_grupo_insumos.id_g AS id_i_g FROM `com_grupo_insumos` 
  LEFT JOIN com_insumos ON com_insumos.id_i = com_grupo_insumos.insumo
  WHERE grupo=?");

  $stmt = mysqli_prepare($conexion, "SELECT * FROM `com_grupo` WHERE user='$user' ORDER BY nombre ASC");
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
     $id = $row['id'];
      echo ' <div class="accordion-item">
      <h2 class="accordion-header">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion_x'.$id.'" aria-expanded="false">
          '.$row['nombre'].'
        </button>
      </h2>
      <div id="accordion_x'.$id.'" class="accordion-collapse collapse" data-bs-parent="#accordionExample2">
        <div class="accordion-body py-3">';
        $stmt_p->bind_param('s', $id);
        $stmt_p->execute();
        $result_p = $stmt_p->get_result();
        if ($result_p->num_rows > 0) {
          while ($r = $result_p->fetch_assoc()) {
            echo '<div class="list-group-item list-group-item-action d-flex justify-content-between mb-2">
            <div class="li-wrapper d-flex justify-content-start align-items-center">
            <span class="badge badge-center bg-label-secondary me-2 fw-bold">'.$r['cantidad'].'</span>  
              <div class="list-content">
                <span class="mb-1">'.$r['insumo'].'</span>
              </div>
            </div>
            <i class="bx bx-plus pointer text-primary" onclick="addInsumoCompraPeriodica(\''.$r['id_i_g'].'\')"></i>
          </div>';
          }

          echo '<hr><div class="list-group-item list-group-item-action d-flex justify-content-between mb-2 add-item"  onclick="addGrupoCompraPeriodica(\''.$id.'\')">
          <div class="li-wrapper d-flex justify-content-start align-items-center">
          <span class="badge badge-center bg-danger me-2"><i class="bx bx-plus"></i></span>  
            <div class="list-content " >
              <span class="mb-1 pointer add-item text-danger">AGREGAR TODOS</span>
            </div>
          </div>
        </div>';
        }
     
        echo '</div>
      </div>
    </div>';

    }
  }
  $stmt->close();











}


} else {
  header("Location: ../../public/index.php");
}
