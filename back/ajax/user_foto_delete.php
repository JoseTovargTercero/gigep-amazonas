<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"]) {
  $id = $_SESSION["u_id"];

  if (file_exists('../../assets/img/avatars/' . $id . '.png')) {
    unlink('../../assets/img/avatars/' . $id . '.png');
  }

  header("Location:" . $_SERVER['HTTP_REFERER']);
  //header("Location:".$_SERVER['HTTP_REFERER']);
  header("Cache-Control: no-cache, must-revalidate");
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  header("Content-Type: application/xml; charset=utf-8");
} else {
  header("Location: ../../public/index.php");
}
