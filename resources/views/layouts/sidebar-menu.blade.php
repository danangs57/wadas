<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <router-link to="/dashboard" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt blue"></i>
          <p>
            Dashboard
          </p>
        </router-link>
      </li>

      <li class="nav-item">
        <router-link to="/products" class="nav-link">
          <i class="nav-icon fas fa-list orange"></i>
          <p>
            Product
          </p>
        </router-link>
      </li>

        <li class="nav-item">
          <router-link to="/users" class="nav-link">
            <i class="fa fa-users nav-icon blue"></i>
            <p>User</p>
          </router-link>
        </li>

        <li class="nav-item">
          <router-link to="/companies" class="nav-link">
            <i class="fa fa-building nav-icon green"></i>
            <p>Company</p>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/transactions" class="nav-link">
            <i class="fa fa-shopping-cart nav-icon yellow"></i>
            <p>Transaction</p>
          </router-link>
        </li>

      


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