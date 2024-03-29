<?php
include('../config/conexion.php');
include('../config/funcione_globales.php');





if ($_SESSION["u_nivel"]) {

  $nombre_grupo = $_POST["nombre_grupo"];
  $descripcion_grupo = $_POST["descripcion_grupo"];
  
  $insumos = str_replace('undefined', '', $_POST["insumos"]);
  $user = $_SESSION["u_ente_id"];


  $stmt_o = $conexion->prepare("INSERT INTO com_grupo (nombre, dsc, user) VALUES (?, ?, ?)");
  $stmt_o->bind_param("sss", $nombre_grupo, $descripcion_grupo, $user);
  $stmt_o->execute();




  if ($stmt_o) {
    $id_r = $conexion->insert_id;
    user_activity(2, 'Creo un nuevo grupo de insumos');

    $stmt_insumos = $conexion->prepare("INSERT INTO com_grupo_insumos (grupo, insumo, cantidad) VALUES (?, ?, ?)");

    if ($insumos != '') {
      $insumos = substr($insumos, 0, -1);
      $insumos = explode(';', $insumos);
      foreach ($insumos as $items) {
        $item = explode('~', $items);
        $stmt_insumos->bind_param("sss", $id_r, $item[0], $item[2]);
        $stmt_insumos->execute();
        if (!$stmt_insumos) {
          echo 'error: condicio...';
        }
      }
    }
  



  }


  
  $stmt_o->close();
  $stmt_insumos->close();
  
  echo "ok";

}else {
  header("Location: ../../public/index.php");
}
?>