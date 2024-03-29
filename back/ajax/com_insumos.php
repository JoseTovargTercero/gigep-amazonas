<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"]) {



  
  $stmt = mysqli_prepare($conexion, "SELECT com_insumos.tipo, com_insumos.user, com_insumos.id_i, com_insumos.insumo, com_categorias.nombre, system_users.u_nombre,system_users.u_ente FROM `com_insumos`
  LEFT JOIN com_categorias ON com_insumos.categoria=com_categorias.id
  LEFT JOIN system_users ON system_users.u_id=com_insumos.user
   ORDER BY com_insumos.tipo ASC, com_insumos.categoria ASC, com_insumos.insumo ASC");
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
     $idC = $row['id_i'];
     $user = $row['user'];
     $insumosGrup = contar("SELECT count(*) FROM `com_grupo_insumos` WHERE 'insumo'='$idC'");

      echo '   <tr class="odd">
      
      <td>';


      if ($row['tipo'] == '0') {
       echo '
       <div class="d-flex">
       <div class="avatar flex-shrink-0 me-3">
         <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-printer"></i></span>
       </div>
       <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
         <div class="me-2">
           <h6 class="mb-0">'.$row['insumo'].'</h6>
           <small class="text-muted">'.$row['nombre'].'</small>
         </div>
       </div>
     </div>
       ';


      }else {
        echo '
        <div class="d-flex">
        <div class="avatar flex-shrink-0 me-3">
          <span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-car"></i></span>
        </div>
        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
          <div class="me-2">
            <h6 class="mb-0">'.$row['insumo'].'</h6>
            <small class="text-muted">'.$row['nombre'].'</small>
          </div>
        </div>
      </div>
        ';
      }
      
     
                        
echo '</td>
      <td>
      <div class="d-flex flex-column"><span class="fw-medium">'.$row['u_nombre'].'</span><small class="text-muted">'.$row['u_ente'].'</small></div>



      </td>


      <td class="text-center">';

      if ($user == $_SESSION["u_ente_id"] && $insumosGrup == 0 || '1' == $_SESSION["u_nivel"] && $insumosGrup == 0) {
       echo '<a class="btn btn-sm btn-icon delete-record me-2" onclick="borrarInsumo('.$idC.')"><i class="bx bx-trash"></i></a>';
      }
      
      
      echo '
     </td>
      </tr>';
    
    

    }
  }
  $stmt->close();



} else {
  header("Location: ../../public/index.php");
}
