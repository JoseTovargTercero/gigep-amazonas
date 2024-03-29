<?php
include('../config/conexion.php');
require('../config/funcione_globales.php');
if ($_SESSION["u_nivel"]) {


  $t = $_POST["t"];
  $u = $_SESSION["u_id"];
  
   echo contar("SELECT count(*) FROM `system_messages_vistos` WHERE visto='0' AND operacion='$t' AND user_2='$u'");


  echo '~';


  $stmt_msg = mysqli_prepare($conexion, "SELECT system_users.u_id, system_users.u_ente, system_users.u_nombre, system_messages.message, system_messages.date FROM `system_messages`
  LEFT JOIN system_users ON system_users.u_id = system_messages.user_1
   WHERE identificador =? AND tipo='0' ORDER BY id DESC");
  $stmt_msg->bind_param('s', $t);
  $stmt_msg->execute();
  $result_users = $stmt_msg->get_result();
  if ($result_users->num_rows > 0) {
    while ($row = $result_users->fetch_assoc()) {
     echo '
     <li class="chat-item | extra-space">
     <span class="chat-item-icon | filled-icon">
       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
         <path fill="none" d="M0 0h24v24H0z" />
         <path fill="currentColor" d="M6.455 19L2 22.5V4a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H6.455zM7 10v2h2v-2H7zm4 0v2h2v-2h-2zm4 0v2h2v-2h-2z" />
       </svg>
     </span>
     <div class="chat-item-wrapper">
       <div class="chat-item-description">
       <span class="avatar | small">';

       if (file_exists('../../assets/img/avatars/' . $row['u_id'] . '.png')) {
        echo '  <img src="../../assets/img/avatars/' . $row['u_id'] . '.png"  />';
      } else {
        echo '  <span class="avatar-initial rounded-circle bg-label-danger">' . substr($row['u_nombre'], 0, 1) . '</span>';
      }

       echo'
      </span>
      <span><b>'.$row['u_nombre'].'</b> '.$row['u_ente'].'
         <br>'.dateToTimeAgo($row['date']).'
         </span>
       </div>
       <div class="comment">'.$row['message'].'</p>
       </div>
   </li>
     ';
    }
  }else {
    echo '
    <li class="chat-item | extra-space">
    <div class="chat-item-wrapper">
      <div class="chat-item-description">
        <span style="margin-left: 13px;">No se han realizado comentarios
        </span>
      </div>
  </li>
    ';
  }
  $stmt_msg->close();


} else {
  header("Location: ../../public/index.php");
}
