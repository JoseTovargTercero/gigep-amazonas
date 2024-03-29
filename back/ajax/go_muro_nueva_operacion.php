<?php
include('../config/conexion.php');
include('../config/funcione_globales.php');

if ($_SESSION["u_nivel"] && isset($_POST["tipo"])) {

$tipo = $_POST["tipo"];
$plan = $_POST["plan"];
$plan_sector = $_POST["plan_sector"]; // solo si es un plan sectorial
$nombre_o = $_POST["nombre_o"];
$descripcion_o = $_POST["descripcion_o"];
$ano = date('Y');




if ($_SESSION["u_nivel"] == '1') {
  $tipo_r = 1; // cunando la responsabilidad es puesta por epa
  $user_id = $_SESSION["u_id"];
  $empresa_id = $_POST["empresa"]; // REGISTRA LA EP
}elseif ($_SESSION["u_nivel"] == '2') {
  $tipo_r = 2; // cuando la responsabilidad es tomada
  $user_id = $_SESSION["u_id"];
  $empresa_id = $_SESSION["u_id"]; // REGISTRA LA EMP
}elseif ($_SESSION["u_nivel"] == '3') {
  $tipo_r = 2; // cuando la responsabilidad es tomada
  $user_id = $_SESSION["u_id"];
  $empresa_id = $_SESSION["u_ente_id"]; // REGISTRA TRABAJADOR DE LA EMP
}

$tipo_o = 0;
// VERIFICAR LOS DATOS DEL PLAN
  if ($tipo == '1' || $tipo == '2' ) {

    $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_planes` WHERE id = ?");
    $stmt->bind_param('s', $var);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $ano = $row['ano'];
      }
    }
    $stmt->close();
  }else {
    $plan = 0;
    $plan_sector = 0;
  }
// VERIFICAR LOS DATOS DEL PLAN


$trimestre = trimestre();
$month = date('m');

$stmt_o = $conexion->prepare("INSERT INTO go_operaciones (tipo_p, id_p, id_s, ano, nombre, descripcion, tipo_o, tipo_resp, users_id, empresa_id, trimestre, mes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ?)");
$stmt_o->bind_param("iiiissssssss", $tipo, $plan, $plan_sector, $ano, $nombre_o, $descripcion_o, $tipo_o, $tipo_r, $user_id, $empresa_id, $trimestre, $month);
$stmt_o->execute();
if ($stmt_o) {

  printf($stmt_o->error);


  $idregistro = mysqli_insert_id($conexion);
  echo $idregistro;
 
 
  user_activity(2, 'Agregó una nueva operación');
  notificar([$empresa_id], 1, $idregistro);
  notificar(['global_users', 'admin_users'], 4, $idregistro, '', $empresa_id);
}else {
  echo "error";
}
$stmt_o->close();

}else {
  header("Location: ../../public/index.php");
}
?>