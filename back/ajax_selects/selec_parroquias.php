<?php
include('../config/conexion.php');

print '<option value="">Seleccione..</option>';


$query=$conexion->query("select * from local_parroquia where id_municipio=$_GET[municipio_id]");
$states = array();
while($r=$query->fetch_object()){ $states[]=$r; }
if(count($states)>0){

foreach ($states as $s) {
	print "<option value='$s->id_parroquias'>&nbsp;$s->nombre_parroquia</option>";
}
}



?>