<?php
include('../config/conexion.php');
if ($_SESSION["u_nivel"] && isset($_GET["plan"])) {
$plan = $_GET["plan"];

$stmt = mysqli_prepare($conexion, "SELECT * FROM `go_sectores` WHERE id_p = ?");
$stmt->bind_param("s", $plan);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {

    echo '<option value="'.$row['id_s'].'">'.$row['sector'].'</option>';
  }
}



}else {
  header("Location: ../../public/index.php");
}
?>