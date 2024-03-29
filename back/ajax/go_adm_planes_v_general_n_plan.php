<?php
include('../config/conexion.php');
include('../config/funcione_globales.php');

if ($_SESSION["u_nivel"] == '1' && isset($_POST["a"])) {


$tipo = '1';
$ano = $_POST["a"];
$nombre = 'Plan Sectorial';
$user = $_SESSION["u_id"];

// verificar si los planes para ese ano no existen

$stmt = mysqli_prepare($conexion, "SELECT * FROM `go_planes` WHERE ano = ?");
$stmt->bind_param("s", $ano);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {

  
  // REGISTRAR EL PLAN
  $stmt_p = $conexion->prepare("INSERT INTO go_planes (tipo, ano, nombre, user) VALUES (?,?,?,?)");
  $stmt_p->bind_param("ssss", $tipo, $ano, $nombre, $user);
  $stmt_p->execute();
  $id_p = $conexion->insert_id;
  user_activity(2, 'Registro un nuevo plan sectorial');
  
  // REGISTRAR LOS SECTORES DEL PLAN
  $stmt_s = $conexion->prepare("INSERT INTO go_sectores (id_p, sector, sector_id) VALUES (?,?,?)");
  foreach (array(['1', 'Servicios'], ['2', 'Económico productivo'], ['3', 'Social']) as $item) {
    $v1 = $item[1];
    $v2 = $item[0];
    $stmt_s->bind_param("sss", $id_p, $v1, $v2);
    $stmt_s->execute();
  }


}
$stmt->close();

notificar(['global_users'], 11, $id_p);


}else {
  header("Location: ../../public/index.php");
}
?>