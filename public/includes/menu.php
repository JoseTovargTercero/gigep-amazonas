      <?php


      $pages = array(
        'go' => [[
          'link' => 'go_adm_planes',
          'texto' => 'Gestor de planes',
          'niveles' => [1],
        ], [
          'link' => 'go_muro',
          'texto' => 'Muro de operaciones',
          'niveles' => [1, 2, 3],
        ], [
          'link' => 'go_rendimiento',
          'texto' => 'Rendimiento operacional',
          'niveles' => [1, 2],
        ]],
        'com' => [[
          'link' => 'com_admin',
          'texto' => 'Administrador de compras',
          'niveles' => [1],
        ], [
          'link' => 'com_categorias',
          'texto' => 'Categorías',
          'niveles' => [1, 2, 3],
        ], [
          'link' => 'com_insumos',
          'texto' => 'Insumos',
          'niveles' => [1, 2, 3],
        ], [
          'link' => 'com_gestor_compras',
          'texto' => 'Gestor de compras',
          'niveles' => [1, 2, 3],
        ]],
        'veh' => [
          [
            'link' => 'veh_vehiculos',
            'texto' => 'Vehículos',
            'niveles' => [1, 2, 3],
          ],
          [
            'link' => 'veh_estado_flota',
            'texto' => 'Estado de la flota',
            'niveles' => [1, 2],
          ]
        ],
        'epa' => [
          [
            'link' => 'epa_facturacion',
            'texto' => 'Facturación por caja',
            'niveles' => [1],
          ],
          [
            'link' => 'epa_dash',
            'texto' => 'Pago online',
            'niveles' => [1],
          ],
          [
            'link' => 'epa_soporte',
            'texto' => 'Linea de comunicación',
            'niveles' => [1],
          ]
        ]
      );


      ?>
      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
          <a class="app-brand-link">
            <img src="../../assets/img/logo.png" width="35px" alt="logo">
            <span class="app-brand-text demo menu-text fw-bolder ms-2" style="text-transform: none;">SIGEP</span>
          </a>
          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
          </a>
        </div>
        <div class="menu-inner-shadow"></div>
        <ul class="menu-inner py-1">
          <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Modulos</span>
          </li>

          <?php
          $usr = $_SESSION["u_id"];

          if ($_SESSION["sa"] == '1') {
            $stmt = mysqli_prepare($conexion, "SELECT * FROM `system_modulos`");
          } else {
            $stmt = mysqli_prepare($conexion, "SELECT system_modulos.modulo, system_modulos.nombre, system_modulos.icono FROM `user_permisos` LEFT JOIN system_modulos ON system_modulos.modulo = user_permisos.modulo WHERE user=$usr");
          }


          $stmt->execute();
          $result = $stmt->get_result();
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

              $modulo = $row['modulo'];
              if (@$pages[$row['modulo']]) {
                echo '<li class="menu-item" id="' . $modulo . '">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <i class="menu-icon  bx ' . $row['icono'] . '"></i>
                  <div >' . $row['nombre'] . '</div>
                </a><ul class="menu-sub">';


                foreach ($pages[$row['modulo']] as $value) {
                  if (in_array($_SESSION["u_nivel"], $value['niveles'])) {
                    echo '<li class="menu-item">
                        <a href="' . $value['link'] . '" class="menu-link">
                          <div data-i18n="Account">' . $value['texto'] . '</div>
                        </a>
                      </li>';
                  }
                }

                echo '</ul>
                </li>';
              }
            }
          }
          $stmt->close();
          ?>





          <?php if ($_SESSION["sa"] == '1') { ?>



            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Administrativo</span>
            </li>


            <li class="menu-item" id="us">
              <a href="veh_vehiculos.php" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div>Usuarios</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="admi_user_list.php" class="menu-link">
                    <div>Nuevo usuario</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="admi_user_actividad.php" class="menu-link">
                    <div>Actividad</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="admi_user_permisos.php" class="menu-link">
                    <div>Permisos</div>
                  </a>
                </li>

              <?php } ?>
              </ul>
            </li>












        </ul>
      </aside>

      <script>
        var elemento = document.getElementById('title');
        var atributo = elemento.getAttribute('class');
        if (atributo != 'x') {
          var elemento = document.getElementById(atributo);
          elemento.setAttribute('class', 'menu-item active');
        }
      </script>