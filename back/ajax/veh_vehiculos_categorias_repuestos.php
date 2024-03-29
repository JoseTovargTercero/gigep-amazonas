<?php
include('../config/conexion.php');


if ($_SESSION["u_nivel"]) {
  require('../config/funcione_globales.php');

  $a = $_GET["a"];
  $user = $_SESSION["u_id"];

  function mostrarCategorias(){
    global $conexion;
    echo '<option value="">Seleccione</option>';
    $stmt = mysqli_prepare($conexion, "SELECT * FROM `veh_categoria_partes` WHERE tipo='1' ORDER BY nombre");
    $stmt->bind_param('s', $var);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
      }
    }
    $stmt->close();

  }

  if ($a == 'rc') {
    $c = $_GET["c"];

    $tipo = '1';
    $stmt_o = $conexion->prepare("INSERT INTO veh_categoria_partes (nombre, user, tipo) VALUES (?,?,?)");
    $stmt_o->bind_param("sss", $c, $user, $tipo);
    $stmt_o->execute();
    echo $conexion->insert_id;
    $stmt_o->close();
  
    user_activity(2, 'Creó una categoría de partes de vehículos');
//    mostrarCategorias();

  }elseif ($a == 'cc') {
    mostrarCategorias();
  }elseif ($a == 'rr') {

    $c = $_GET["c"];
    $r = $_GET["r"];

    $tipo = '1';
    $stmt_o = $conexion->prepare("INSERT INTO veh_partes (insumo, categoria, user, tipo) VALUES (?,?,?,?)");
    $stmt_o->bind_param("ssss", $r, $c, $user, $tipo);
    $stmt_o->execute();
    $stmt_o->close();
    echo $conexion->insert_id;

    user_activity(2, 'Registró un repuesto');



  }elseif ($a == 'cr') {
    $c = $_GET["c"];
    echo '<option value="">Seleccione</option>';
    $stmt = mysqli_prepare($conexion, "SELECT id_i, insumo FROM `veh_partes` WHERE categoria='$c' ORDER BY insumo");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo '<option value="'.$row['id_i'].'">'.$row['insumo'].'</option>';
      }
    }
    $stmt->close();
  }















} 