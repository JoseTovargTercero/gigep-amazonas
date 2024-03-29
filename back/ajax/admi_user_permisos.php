<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"] == '1' || $_SESSION["u_nivel"] == '2') {
  if ($_SESSION["sa"] == '1') {

  
  if (isset($_POST["a"]) && $_POST["a"] == 'a') { // registros directos
    $usr_s = $_SESSION["u_id"];
    $modulo = $_POST["modulo"];
    $usr = $_POST["usr"];
    
    $stmt = mysqli_prepare($conexion, "SELECT * FROM `user_permisos` WHERE user = ? AND modulo = ?");
      $stmt->bind_param('ss', $usr, $modulo);
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo 'ye';
          exit();
        }
      }
      $stmt->close();

      $stmt = $conexion->prepare("INSERT INTO user_permisos (user, modulo) VALUES (?, ?)");
      $stmt->bind_param("ss", $usr, $modulo);
      $stmt->execute();
      if ($stmt) {
        echo "ok";
        $stmt->close();
        user_activity(3, 'Actualizo los permisos de un usuario');
      }
    }elseif (isset($_GET["a"]) && $_GET["a"] == 'cp') {
      $u = $_GET["u"];
  
  
  
  
      $stmt = mysqli_prepare($conexion, "SELECT * FROM `user_permisos` WHERE user=?");
      $stmt->bind_param('s', $u);
      $stmt->execute();
      $result = $stmt->get_result();
      echo '<ul class="list-group">';
  
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
      if ($row['modulo'] != 'admi') {

          $id = $row['id'];
          switch ($row['modulo']) {
            case ('go'):
              $modulo =  '<span class="badge bg-label-primary">Gestión operativa</span>';
              break;
            case ('com'):
              $modulo =  '<span class="badge bg-label-success">Compras</span>';
              break;
            case ('veh'):
              $modulo =  '<span class="badge bg-label-warning">Vehículos</span>';
              break;
          }
  
          echo '<li class="list-group-item d-flex justify-content-between"><span>'.$modulo.'</span> <i onclick="eliminarPermiso(\''.$id.'\')" class="text-danger bx bx-trash"></i></li>';
        }
  
        }
        echo '</ul>';
  
      }
      $stmt->close();
  
    }elseif (isset($_GET["a"]) && $_GET["a"] == 'qp') {
      $id = $_GET["i"];



      $stmt = mysqli_prepare($conexion, "SELECT system_users.sa, system_users.u_nivel, system_users.u_ente_id FROM `user_permisos`
      LEFT JOIN system_users ON system_users.u_id = user_permisos.user
       WHERE id = ?");
      $stmt->bind_param('s', $id);
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          

          if ($_SESSION["u_nivel"] == 2) {
            if ($row['u_ente_id'] == '') {
              echo 'np0';
              exit();
            }

            if ($row['u_ente_id'] != $_SESSION["u_ente_id"]) {
              echo 'np';
              exit();
            }
          }elseif ($_SESSION["u_nivel"] == 1) {
            if ($row['u_nivel'] != '1' || $row['sa'] == '1') {
              echo 'np';
              exit();
            }
          }else {
            echo 'np';
            exit();
          }

        }
      }
      $stmt->close();


      $stmt = $conexion->prepare("DELETE FROM `user_permisos` WHERE id = ?");
      $stmt->bind_param("s", $id);
      $stmt->execute();
      if ($stmt) {
        echo 'ok';
        user_activity(1, 'Le quitó permisos a un usuario');

      }
      $stmt->close();
  
    }


}else {
  echo 'np';
}
}else {
  header("Location: ../../public/index.php");
}

?>



