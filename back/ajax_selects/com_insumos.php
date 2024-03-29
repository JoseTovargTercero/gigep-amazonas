<?php
include('../config/conexion.php');
if ($_SESSION["u_nivel"]) {
$c = $_GET["c"];

$stmt = mysqli_prepare($conexion, "SELECT * FROM `com_insumos` WHERE categoria = ?");
$stmt->bind_param("s", $c);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {

    echo '<option class="options opt_'.$row['id_i'].'" value="'.$row['id_i'].'~'.$row['insumo'].'">'.$row['insumo'].'</option>';
  }
}



}else {
  header("Location: ../../public/index.php");
}
?>