<?php
include('../config/conexion.php');
if ($_SESSION["u_nivel"]) {
  require('../config/funcione_globales.php');








  if ($_GET["v"] == '1') { // Enlistar insumos configurados para la compra

    $id = $_GET["i"];
    $user = $_SESSION["u_ente_id"];

    $stmt = mysqli_prepare($conexion, "SELECT com_compras_estructura.id, com_compras_estructura.cantidad_i, com_insumos.insumo  FROM `com_compras_estructura`
    LEFT JOIN com_insumos ON com_insumos.id_i= com_compras_estructura.insumo_id
     WHERE compra_id = ? AND user_id='$user'");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {

        echo ' <li class="d-flex mb-4 pb-1" >
        <div class="avatar flex-shrink-0 me-3" onclick="modificarCantidad(\''.$row['id'].'\')">
          <span class="avatar-initial rounded bg-label-primary" title="Modificar cantidad"><i class="bx bx-edit-alt"></i></span>
        </div>
        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
          <div class="me-2">
            <h6 class="mb-0">'.$row['insumo'].'</h6>
            <small class="text-muted">Cantidad: <strong>'.$row['cantidad_i'].'</strong></small>
          </div>
          <div class="user-progress pointer" onclick="sacarProductoCompra(\''.$row['id'].'\')">
            <small class="fw-semibold"> <i class="bx bx-trash"></i> </small>
          </div>
        </div>
      </li>';
      }
    }
    $stmt->close(); // TODO LISTO, ACTUALIZADO
  } elseif ($_GET["v"] == '2') { // AGREGAR PRODUCTO


    $id = $_GET["i"];
    $id_copmra = $_GET["c"]; // ID_COMPRA
    $user = $_SESSION["u_ente_id"];



     // VERIFICAR SI ES UNA COMPRA PERIODICA
    $stmt = mysqli_prepare($conexion, "SELECT id_compra_periodica  FROM `com_compras` WHERE id = ?");
    $stmt->bind_param('s', $id_copmra);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
       $compraPeriodica = $row['id_compra_periodica'];
      }
    }
    $stmt->close();
    // end of: VERIFICAR SI ES UNA COMPRA PERIODICA


    // BUSCAR INFORMACION DEL INSUMO 
    $stmt = mysqli_prepare($conexion, "SELECT * FROM `com_grupo_insumos` WHERE id_g = ?");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $cantidad = $row['cantidad'];
        $insumo = $row['insumo'];
      }
    }
    $stmt->close();
    // BUSCAR INFORMACION DEL INSUMO 



    $repetidos = 0;
    $stmt2 = mysqli_prepare($conexion, "SELECT * FROM `com_compras_estructura` WHERE compra_id = ? AND insumo_id=? AND user_id=?");
    $stmt2->bind_param('sss', $id_copmra, $insumo, $user);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    if (!$result2->num_rows > 0) { // VERIFICAR QUE EL INSUMO NO ESTE REPETIDOS


      $stmt_o = $conexion->prepare("INSERT INTO com_compras_estructura (insumo_id, cantidad_i, compra_id, user_id) VALUES (?, ?, ?, ?)");
      $stmt_o->bind_param("ssss", $insumo, $cantidad, $id_copmra, $user);
      $stmt_o->execute(); // INSERTAR EL INSUMO

      if ($compraPeriodica != 0) {
        $stmt_o1 = $conexion->prepare("INSERT INTO com_compras_periodicas_configuradas (insumo_id, cantidad_i, compra_p_id, user_id) VALUES (?, ?, ?, ?)");
        $stmt_o1->bind_param("ssss", $insumo, $cantidad, $compraPeriodica, $user);
        $stmt_o1->execute();
        $stmt_o1->close();
      } // SE ACTUALIZAN LOS VALORES PREDEFINIDOS PARA LA COMPRA


    } else {
      $repetidos++;
    }

    $stmt_o->close();
    $stmt2->close();


    echo $repetidos; // TODO ACTUALIZADO
  } elseif ($_GET["v"] == '3') { // AGREGAR GRUPO DE INSUMOS
    

    $id = $_GET["i"];
    $id_copmra = $_GET["c"];
    $user = $_SESSION["u_ente_id"];


    $compraPeriodica = 0;
     // VERIFICAR SI ES UNA COMPRA PERIODICA
     $stmt = mysqli_prepare($conexion, "SELECT id_compra_periodica  FROM `com_compras` WHERE id = ?");
     $stmt->bind_param('s', $id_copmra);
     $stmt->execute();
     $result = $stmt->get_result();
     if ($result->num_rows > 0) {
       while ($row = $result->fetch_assoc()) {
        $compraPeriodica = $row['id_compra_periodica'];
       }
     }
     $stmt->close();
     // end of: VERIFICAR SI ES UNA COMPRA PERIODICA





    $repetidos = 0;
    $stmt2 = mysqli_prepare($conexion, "SELECT * FROM `com_compras_estructura` WHERE compra_id = ? AND insumo_id=? AND user_id=?");
    // QUERY PARA VERIFICAR SI EL PRODUCTO EXISTE
    $stmt_o = $conexion->prepare("INSERT INTO com_compras_estructura (insumo_id, cantidad_i, compra_id, user_id) VALUES (?, ?, ?, ?)");
    // QUERY PARA INSERTAR LA INFORMACION
    $stmt_o2 = $conexion->prepare("INSERT INTO com_compras_periodicas_configuradas (insumo_id, cantidad_i, compra_p_id, user_id) VALUES (?, ?, ?, ?)");
    // QUERY PARA INSERTAR LA INFORMACION PREDEFINIDA

    
    $stmt = mysqli_prepare($conexion, "SELECT * FROM `com_grupo_insumos` WHERE grupo = ?");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $cantidad = $row['cantidad'];
        $insumo = $row['insumo'];

        $stmt2->bind_param('sss', $id_copmra, $insumo, $user);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        if (!$result2->num_rows > 0) {

          $stmt_o->bind_param("ssss", $insumo, $cantidad, $id_copmra, $user);
          $stmt_o->execute();

          if ($compraPeriodica != 0) {
            $stmt_o2->bind_param("ssss", $insumo, $cantidad, $compraPeriodica, $user);
            $stmt_o2->execute();
          } // SE ACTUALIZAN LOS VALORES PREDEFINIDOS PARA LA COMPRA

        } else {
          $repetidos++;
        }

    
      }
    }
    $stmt->close();
    $stmt2->close();
    $stmt_o->close();
    $stmt_o2->close();

    echo $repetidos;

    // TODO ACTUALIZADO

  } elseif ($_GET["v"] == '4') { // ELIMINAR INSUMO
    

    $id = $_GET["i"];
    $user = $_SESSION["u_ente_id"];



    
        $compraPeriodica = 0;

         // VERIFICAR SI ES UNA COMPRA PERIODICA
         $stmt = mysqli_prepare($conexion, "SELECT com_compras.id_compra_periodica, com_compras_estructura.insumo_id  FROM `com_compras_estructura`
         LEFT JOIN com_compras ON com_compras.id=com_compras_estructura.compra_id
          WHERE com_compras_estructura.id = ?");
         $stmt->bind_param('s', $id);
         $stmt->execute();
         $result = $stmt->get_result();
         if ($result->num_rows > 0) {
           while ($row = $result->fetch_assoc()) {
            $compraPeriodica = $row['id_compra_periodica'];
            $insumo = $row['insumo_id'];
           }
         }
         $stmt->close();
         // end of: VERIFICAR SI ES UNA COMPRA PERIODICA
    




    $stmt2 = mysqli_prepare($conexion, "SELECT * FROM `com_compras_estructura` WHERE id=? AND user_id=?");
    $stmt2->bind_param('ss', $id, $user);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    if ($result2->num_rows > 0) {
      $stmt = $conexion->prepare("DELETE FROM `com_compras_estructura` WHERE id = ?");
      $stmt->bind_param("i", $id);
      $stmt->execute();
      if ($stmt) {
        echo "ok";
      }
      $stmt->close();


      if ($compraPeriodica != 0) {
        $stmt = $conexion->prepare("DELETE FROM `com_compras_periodicas_configuradas` WHERE compra_p_id = ? AND insumo_id=? AND user_id=?");
        $stmt->bind_param("sss", $compraPeriodica, $insumo, $user);
        $stmt->execute();
        $stmt->close();
      } // SE ACTUALIZAN LOS VALORES PREDEFINIDOS PARA LA COMPRA



    }
    $stmt2->close();


  } elseif ($_GET["v"] == '5') { // EDITAR INSUMO
    

    $id = $_GET["i"];
    $cantidad = $_GET["c"];
    $user = $_SESSION["u_ente_id"];


    $compraPeriodica = 0;

    // VERIFICAR SI ES UNA COMPRA PERIODICA
    $stmt = mysqli_prepare($conexion, "SELECT com_compras.id_compra_periodica, com_compras_estructura.insumo_id  FROM `com_compras_estructura`
    LEFT JOIN com_compras ON com_compras.id=com_compras_estructura.compra_id
     WHERE com_compras_estructura.id = ?");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
       $compraPeriodica = $row['id_compra_periodica'];
       $insumo = $row['insumo_id'];
      }
    }
    $stmt->close();
    // end of: VERIFICAR SI ES UNA COMPRA PERIODICA



    


    $stmt2 = mysqli_prepare($conexion, "SELECT * FROM `com_compras_estructura` WHERE id=? AND user_id=?");
    $stmt2->bind_param('ss', $id, $user);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    if ($result2->num_rows > 0) {

      $stmt3 = $conexion->prepare("UPDATE `com_compras_estructura` SET `cantidad_i`=? WHERE id=?");
      $stmt3->bind_param("ss", $cantidad, $id);
      $stmt3->execute();
      if ($stmt3) {
        echo "ok";
      }
      $stmt3 -> close();


      if ($compraPeriodica != 0) {
      $stmt4 = $conexion->prepare("UPDATE `com_compras_periodicas_configuradas` SET `cantidad_i`=? WHERE compra_p_id = ? AND insumo_id=? AND user_id=?");
      $stmt4->bind_param("ssss", $cantidad, $compraPeriodica, $insumo, $user);
      $stmt4->execute();
      $stmt4 -> close();
      } // SE ACTUALIZAN LOS VALORES PREDEFINIDOS PARA LA COMPRA


 
    }
    $stmt2->close();

  }



}
