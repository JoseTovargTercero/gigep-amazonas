<?php
include('../config/conexion.php');
print '<option value="">Seleccione..</option>';


$query=$conexion->query("select * from local_comunas where id_parroquia=$_GET[parroquia_id]");
$states = array();
while($r=$query->fetch_object()){ $states[]=$r; }
if(count($states)>0){
foreach ($states as $s) {
	print "<option value='$s->id_Comuna'>&nbsp;$s->nombre_comuna</option>";
}
}
?>