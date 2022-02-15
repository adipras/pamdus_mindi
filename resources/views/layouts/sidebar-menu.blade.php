<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <router-link to="/dashboard" class="nav-link">
          <i class="nav-icon fas fa-chart-line orange"></i>
          <p>
            Dashboard
          </p>
        </router-link>
      </li>

      @can('isPelanggan')
      <li class="nav-item">
        <router-link to="/tagihan" class="nav-link">
          <i class="nav-icon fas fa-file-invoice-dollar orange"></i>
          <p>
            Tagihan
          </p>
        </router-link>
      </li>
      @endcan

      @can('isAdmin')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-faucet blue"></i>
          <p>
            Operasional PAM
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <router-link to="/pelanggans" class="nav-link">
                    <i class="fa fa-user-tag nav-icon blue"></i>
                    <p>Pelanggan</p>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link to="/meterans" class="nav-link">
                    <i class="fa fa-tachometer-alt nav-icon blue"></i>
                    <p>Pencatatan Meteran</p>
                </router-link>
            </li>
        </ul>
      </li>
      @endcan



      @can('isAdmin')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-cog green"></i>
          <p>
            Settings
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">

          <li class="nav-item">
            <router-link to="/users" class="nav-link">
              <i class="fa fa-users nav-icon blue"></i>
              <p>Users</p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/setting/usertype" class="nav-link">
              <i class="nav-icon fas fa-user-tag blue"></i>
              <p>
                User Type
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/product/category" class="nav-link">
              <i class="nav-icon fas fa-list-ol green"></i>
              <p>
                Category
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/product/tag" class="nav-link">
              <i class="nav-icon fas fa-tags green"></i>
              <p>
                Tags
              </p>
            </router-link>
          </li>

            <li class="nav-item">
              <router-link to="/developer" class="nav-link">
                  <i class="nav-icon fas fa-cogs white"></i>
                  <p>
                      Developer
                  </p>
              </router-link>
            </li>
        </ul>
      </li>

      @endcan



      <li class="nav-item">
        <a href="#" class="nav-link" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          <i class="nav-icon fas fa-power-off red"></i>
          <p>
            {{ __('Logout') }}
          </p>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>
    </ul>
  </nav>
