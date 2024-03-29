<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"]) {



  $stmt = mysqli_prepare($conexion, "SELECT * FROM `com_categorias`
  LEFT JOIN system_users ON system_users.u_id=com_categorias.user
   ORDER BY nombre DESC");
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
     $id = $row['id'];
     $user = $row['user'];

     $insumosCategoria = contar("SELECT count(*) FROM `com_insumos` WHERE `categoria`='$id'");
      echo '   <tr class="odd">
      <td class="sorting_1">
        <div class="d-flex justify-content-start align-items-center product-name">
          <div class="d-flex flex-column">
            <h6 class="text-body text-nowrap mb-0">'.$row['nombre'].'</h6>
          </div>
        </div>
      </td>
      <td class="text-center">'.$insumosCategoria.'</td>
      <td>
      <div class="d-flex flex-column"><span class="fw-medium">'.$row['u_nombre'].'</span><small class="text-muted">'.$row['u_ente'].'</small></div>



      </td>


      <td class="text-center">';

      if ($user == $_SESSION["u_ente_id"] && $insumosCategoria == 0 || '1' == $_SESSION["u_nivel"] && $insumosCategoria == 0 ) {
       echo '<a class="btn btn-sm btn-icon delete-record me-2" onclick="borrarCategoria('.$id.')"><i class="bx bx-trash"></i></a>';
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
