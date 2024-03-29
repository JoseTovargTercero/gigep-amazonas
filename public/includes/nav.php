<?php
if (!@$_SESSION["u_nivel"]) {
  header("Location: ../../login/logout.php");
  exit();
}

?>


<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0   d-xl-none ">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="bx bx-menu bx-sm"></i>
    </a>
  </div>

  <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <!-- 
    <div class="navbar-nav align-items-center">
      <div class="nav-item d-flex align-items-center">
        <i class="bx bx-search fs-4 lh-0"></i>
        <input type="text" class="form-control border-0 shadow-none" placeholder="Buscar..." aria-label="Buscar..." />
      </div>
    </div>
    -->

    <ul class="navbar-nav flex-row align-items-center ms-auto">
      <!-- Place this tag where you want the button to render. -->


      <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
          <i class="bx bx-bell bx-sm"></i>
          <span class="badge bg-danger rounded-pill badge-notifications" style="display: none;" id="count_notifications"></span>

        </a>
        <ul class="dropdown-menu dropdown-menu-end py-0">
          <li class="dropdown-menu-header border-bottom">
            <div class="dropdown-header d-flex align-items-center py-3">
              <h5 class="text-body mb-0 me-auto">Notificaciones</h5>
              <i class="bx fs-4 bx-envelope-open"></i>
            </div>
          </li>
          <li class="dropdown-notifications-list scrollable-container ps" style="    overflow-y: auto !important;">
            <ul class="list-group list-group-flush" id="notifications">
            </ul>
            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
              <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
            </div>
            <div class="ps__rail-y" style="top: 0px; right: 0px;">
              <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
            </div>
          </li>
   

          <li class="dropdown-menu-footer border-top p-3">
                <a href="user_notification.php" class="btn btn-primary text-uppercase w-100">Ver todas las notificaciones</a>
              </li>
        </ul>
      </li>
      <!-- User -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar">
            <?php

            if (file_exists('../../assets/img/avatars/' . $_SESSION['u_id'] . '.png')) {
              echo '  <img src="../../assets/img/avatars/' . $_SESSION['u_id'] . '.png" alt class="w-px-40 h-px-40 rounded-circle" />';
            } else {
              echo '  <span class="avatar-initial rounded-circle bg-label-danger">' . substr($_SESSION['u_nombre'], 0, 1) . '</span>';
            }
            ?>


          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="user_profile.php">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar ">
                    <i class="bx bx-user" style="    font-size: 39px;"></i>
                  </div>
                </div>
                <div class="flex-grow-1">
                  <span class="fw-semibold d-block"><?php echo $_SESSION['u_nombre'] ?></span>
                  <small class="text-muted"><?php echo $_SESSION['u_ente'] ?></small>
                </div>
              </div>
            </a>
          </li>
      


          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <a class="dropdown-item" href="../../login/logout.php">
              <i class="bx bx-power-off me-2"></i>
              <span class="align-middle">Salir</span>
            </a>
          </li>
        </ul>
      </li>
      <!--/ User -->
    </ul>
  </div>
</nav>

<script>
  function getNotifications() {
    $.get("../../back/ajax/notificaciones_nav.php", "", function(data) {
      $('#notifications').html(data.split('~')[1])
      if (data.split('~')[0] != '0') {
        $('#count_notifications').show(300)
        $('#count_notifications').html(data.split('~')[0])
      } else {
        $('#count_notifications').hide(300)
      }
    });
  }
  getNotifications()

  var notice;
  var seguidor;
  var u1;

  function verNotification(id, guia, user_1) {
    notice = id;
    seguidor = guia;
    u1 = user_1;
    
    $.get("../../back/ajax/go_notificaciones_set_visto.php", "i=" + id, function(data) {
      $('#cuerpoNotice').html(data)
      $('#modalNotification').modal('toggle')
      getNotifications()
    });
  }

  function aceptar() {
    $.get("../../back/ajax/go_notificaciones_set_status.php", "i=" + notice + '&s=1&g=' + seguidor + '&u=' + u1, function(data) {
      location.href="go_tarea.php?t="+data.trim();
      $('#modalNotification').modal('toggle')

    });
  }


  function rechazar(c) {

    $.get("../../back/ajax/go_notificaciones_set_status.php", "i=" + notice + "&s=2&c=" + c + "&g=" + seguidor + '&u=' + u1, function(data) {
      $('#noti_razon_rechazo').val('')
      $('#footer_noti').toggle('300')
    });
  }

  async function pre_rechazar() {
    $('#modalNotification').modal('toggle')


    const { value: ipAddress } = await Swal.fire({
      title: "Ingrese un comentario",
      input: "text",
      inputLabel: "Comentario",
      showCancelButton: true,
      confirmButtonColor: "#69a5ff",
      cancelButtonText: `Cancelar`,
      inputValidator: (value) => {
        if (!value) {
          return "¡Es necesario realizar un comentario!";
        }
      }
    });
    if (ipAddress) {
      rechazar(ipAddress)
    }
    if (!ipAddress) {
      $('#modalNotification').modal('toggle')
    }
   
  }





  

  function aceptar_v(g, c) {
    $.get("../../back/ajax/go_notificaciones_set_status_vehiculo.php", "v=" + g + "&s=1&t=" + c, function(data) {
      location.href="go_tarea.php?t="+c;
    });
  }


  async function pre_rechazar_v(g, c) {
    $('#modalNotification').modal('toggle')


    const { value: ipAddress } = await Swal.fire({
      title: "Ingrese un comentario",
      input: "text",
      inputLabel: "Comentario",
      showCancelButton: true,
      confirmButtonColor: "#69a5ff",
      cancelButtonText: `Cancelar`,
      inputValidator: (value) => {
        if (!value) {
          return "¡Es necesario realizar un comentario!";
        }
      }
    });
    if (ipAddress) {
      rechazar_v(g, c, ipAddress)
    }
    if (!ipAddress) {
      $('#modalNotification').modal('toggle')
    }
   
  }

  
  function rechazar_v(g, t, c) {
    $.get("../../back/ajax/go_notificaciones_set_status_vehiculo.php", "v=" + g + '&s=2&t=' + t + '&c=' + c, function(data) {
      $('#footer_noti').toggle('300')
    });
  }
</script>


<div class="modal fade" id="modalNotification" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered " role="document">
    <div class="modal-content ">
      <div class="modal-body">
        <div class="card-body" id="cuerpoNotice">
        </div>
      </div>
    </div>
  </div>
</div>