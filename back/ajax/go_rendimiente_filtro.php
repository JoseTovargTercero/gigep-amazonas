<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"] == '2' || $_SESSION["u_nivel"] == '1' ) {
  

  if (isset($_GET["t"])) {
    if ($_GET["t"] == '0') {
      unset($_SESSION["filter_t"]);
    }else {
      $_SESSION["filter_t"] = $_GET["t"];
    }
  }elseif (isset($_GET["a"])) {
    $_SESSION["filter_a"] = $_GET["a"];
  }
  

  header("Location:".$_SERVER['HTTP_REFERER']);


} else {
  header("Location: ../../public/index.php");
}
