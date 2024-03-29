<?php
include('../config/conexion.php');
include('../config/funcione_globales.php');


if ($_SESSION["u_nivel"]) {

  $add_post_responsables = $_POST["add_post_responsables"];
  $add_post_responsabilidad = $_POST["add_post_responsabilidad"];
  $add_post_id = $_POST["add_post_id"];



  $stmtk = mysqli_prepare($conexion, "SELECT * FROM `go_tareas` WHERE id_tarea = ?");
  $stmtk->bind_param('s', $add_post_id);
  $stmtk->execute();
  $result = $stmtk->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $operacion = $row['id_operacion'];
    }
  }
  $stmtk->close();



  $stmt = mysqli_prepare($conexion, "SELECT * FROM `system_users` WHERE u_id =?");
  $stmt->bind_param('s', $add_post_responsables);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $empresa = $row['u_ente'];
    }
  }
  $stmt->close();




  $stmt_o = $conexion->prepare("INSERT INTO go_tareas_responsables (tarea, operacion, empresa, empresa_id, responsabilidad) VALUES (?, ?, ?, ?, ?)");
  $stmt_o->bind_param("sssss", $add_post_id, $operacion, $empresa, $add_post_responsables, $add_post_responsabilidad);
  $stmt_o->execute();
  $idregistro = mysqli_insert_id($conexion);



  notificar([$add_post_responsables], 14, $idregistro);


  user_activity(2, 'Agregó un responsable a una tarea');




} else {
  header("Location: ../../public/index.php");
}
