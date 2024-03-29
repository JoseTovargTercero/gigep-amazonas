    <?php
  include('../config/conexion.php');
  require('../config/funcione_globales.php');
       


   $registro = $_POST["registro"];



   // Ver tipo de ejecución

  $stmt = mysqli_prepare($conexion, "SELECT * FROM `go_tareas` WHERE id_tarea = ?");
  $stmt->bind_param('s', $registro);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $operacion = $row['id_operacion'];
      $tipo_ejecucion = $row['tipo_ejecucion'];
      $mr_1 = $row['mr_1'];
      $mr_2 = $row['mr_2'];
      $mr_3 = $row['mr_3'];
      $mr_4 = $row['mr_4'];
    }
  }
  $stmt->close();


    // recibir los datos
   $rslt_trimestre = $_POST["rslt_trimestre"];

   $rslt_cantidad = $_POST["rslt_cantidad"];
   $rslt_personas = $_POST["rslt_personas"];
   $rslt_comunidades = $_POST["rslt_comunidades"];
   $rslt_comunas = $_POST["rslt_comunas"];

   $date = date('Y-m-d H:i:s');


   if ($tipo_ejecucion == '1') {
     // se registra por fecha unica
     $stmt2 = $conexion->prepare("UPDATE `go_tareas` SET `fecha_ejecucion`='$date', `status`='1',`cantidad_medida`=?,`atencion_personas`=?,`atencion_comunidades`=?,`atencion_comunas`=? WHERE id_tarea=?");
     $stmt2->bind_param("sssss", $rslt_cantidad, $rslt_personas, $rslt_comunidades, $rslt_comunas, $registro);

     notificar(['admin_users', 'involved_users'], 6, $registro);

   }else {
     // se registra por trimestre

     if ($mr_1 != '' && $mr_2 != '' && $mr_3  != '' && $mr_4 != '') {
      $status = '1';
      notificar(['admin_users', 'involved_users'], 6, $registro);
    }else{
      $status = '2';
      notificar(['admin_users', 'involved_users'], 16, $registro);
     }



     
     $stmt2 = $conexion->prepare("UPDATE `go_tareas` SET `fecha_ejecucion`='$date', `status`='$status',`mr_$rslt_trimestre`=?,`atencion_personas_$rslt_trimestre`=?,`atencion_comunidades_$rslt_trimestre`=?,`atencion_comunas_$rslt_trimestre`=? WHERE id_tarea=?");
     $stmt2->bind_param("sssss", $rslt_cantidad, $rslt_personas, $rslt_comunidades, $rslt_comunas, $registro);

     user_activity(3, 'Reporto la ejecución de una tarea');

   }




   $stmt2->execute();
   $stmt2 -> close();

    /*
      Esta función se encarga de cargar los archivos subidos por el usuario en la carpeta especificada.
      La función acepta dos parámetros: el nombre del archivo subido y la ruta de la carpeta donde se deben guardar los archivos.
      La función utiliza la función move_uploaded_file () para mover los archivos desde la carpeta temporal hasta la carpeta especificada.
      La función utiliza un bucle foreach para recorrer todos los archivos subidos.
      La función verifica si el archivo existe y si la ruta de destino existe. En caso de que no exista, la función crea el directorio.
      La función cierra el directorio de destino cuando se haya terminado de procesar los archivos.
     */

    function cargarArchivo($archivo, $folder)    {
      global $registro;
      global $tipo_ejecucion;
      global $rslt_trimestre;
      $nam = $registro;
      $c = 1;
      if ($tipo_ejecucion == '2') {
        $add = 't'.$rslt_trimestre.'_';
      }else {
        $add = '';
      }


      
      $dir = opendir($folder); //Abrimos el directorio de destino
      
      //Como el elemento es un arreglos utilizamos foreach para extraer todos los valores
      foreach ($_FILES[$archivo]['tmp_name'] as $key => $tmp_name) {
        //Validamos que el archivo exista
        if ($_FILES[$archivo]["name"][$key]) {
          $source = $_FILES[$archivo]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo

          $target_path = $folder . '/' . $add.$nam .'_'.$c. '.png'; //Indicamos la ruta de destino, así como el nombre del archivo
          $c++;
          move_uploaded_file($source, $target_path);  //	echo 'ok. ';
        }
      }
      closedir($dir); //Cerramos el directorio de destino

    }

    cargarArchivo('file', '../../assets/img/tareas');

    echo "ok";
   // header("Location:".$_SERVER['HTTP_REFERER']);

    ?>
 
