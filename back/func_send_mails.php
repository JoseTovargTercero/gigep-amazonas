<?php 

function sendMails($email, $titulo, $mensaje){

    $headers = "MIME-Version: 1.0\r\n"; 
    $headers .= "Content-type: text/html; charset=utf-8\r\n"; 
    $headers .= "From: Soporte de Usuarios GITCOM <soporte@gitcom.com.ve>\r\n"; 
    $headers .= "Return-path: soporte@gitcom.com.ve\r\n"; 
    $headers .= "Cc: soporte@gitcom.com.ve\r\n"; 
    $headers .= "Bcc: soporte@gitcom.com.ve\r\n"; 
  
    
    if (mail($email, $titulo, $mensaje, $headers)) {
      return 1;
    }else {
      return 0;
    }
  }
  
?>