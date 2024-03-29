<?php
include('../config/conexion.php');
include('../config/funcione_globales.php');


if ($_SESSION["u_nivel"]) {
 

$user = $_SESSION["u_id"];
$item = $_GET["nitem"];



$stmt = mysqli_prepare($conexion, "SELECT * FROM `unidades_medida` WHERE unidad = ?");
$stmt->bind_param('s', $item);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  echo 'ye';
  exit();
}
$stmt->close();




$stmt_o = $conexion->prepare("INSERT INTO unidades_medida (user, unidad) VALUES (?, ?)");
$stmt_o->bind_param("ss", $user, $item);
$stmt_o->execute();



user_activity(2, 'Creó una unidad de medida');


if ($stmt_o) {

  

  $stmt = mysqli_prepare($conexion, "SELECT * FROM `unidades_medida` ORDER BY tipo DESC, unidad ASC");
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<option value="' . $row['unidad'] . '">' . $row['unidad'] . '</option>';
    }
  }
  $stmt->close();


  






}else {
  echo "error";
}
$stmt_o->close();




}else {
  header("Location: ../../public/index.php");
}
