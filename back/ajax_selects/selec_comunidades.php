<?php
include('../config/conexion.php');
echo '<option value="">Seleccione..</option>';

$query = "SELECT * FROM local_comunidades WHERE id_comuna='$_GET[comuna_id]' AND id_user=''";
$search = $conexion->query($query);
if ($search->num_rows > 0) {
    while ($row = $search->fetch_assoc()) {
		echo "<option value='".$row['id_consejo']."'>&nbsp;".$row['nombre_c_comunal']."</option>";
    }
}
?>