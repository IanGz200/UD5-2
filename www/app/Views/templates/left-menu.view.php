<!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?php echo $_ENV['host.folder']; ?>" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Inicio
              </p>
            </a>
          </li> 
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item <?php echo (in_array($_SERVER['REQUEST_URI'], [$_ENV['host.folder'].'demo-proveedores'])) ? 'menu-open' : '';?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Panel de control
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $_ENV['host.folder']; ?>demo-proveedores" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'].'demo-proveedores' ? 'active' : ''; ?>">
                  <i class="fas fa-laptop-code nav-icon"></i>
                  <p>Demo Proveedores</p>
                </a>
              </li>              
            </ul>
          </li>
        </ul>
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
              <li class="nav-item <?php echo in_array($_SERVER['REQUEST_URI'], [$_ENV['host.folder'].'poblacion-pontevedra', $_ENV['host.folder'].'poblacion-pontevedra-2020', $_ENV['host.folder'].'poblacion-grupos-edad']) ? 'menu-open' : '';?>">
                  <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-file-excel"></i>
                      <p>
                          CSV Población
                          <i class="right fas fa-angle-left"></i>
                      </p>
                  </a>
                  <ul class="nav nav-treeview">
                      <li class="nav-item">
                          <a href="<?php echo $_ENV['host.folder']; ?>poblacion-pontevedra" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'].'poblacion-pontevedra' ? 'active' : ''; ?>">
                              <i class="fas fa-laptop-code nav-icon"></i>
                              <p>Pontevedra</p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="<?php echo $_ENV['host.folder']; ?>poblacion-grupos-edad" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'].'poblacion-grupos-edad' ? 'active' : ''; ?>">
                              <i class="fas fa-laptop-code nav-icon"></i>
                              <p>Grupos/Edad</p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="<?php echo $_ENV['host.folder']; ?>poblacion-pontevedra-2020" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'].'poblacion-pontevedra-2020' ? 'active' : ''; ?>">
                              <i class="fas fa-laptop-code nav-icon"></i>
                              <p>Pontevedra 2020</p>
                          </a>
                      </li>
                  </ul>
              </li>
          </ul>
      </nav>
      <!-- /.sidebar-menu -->