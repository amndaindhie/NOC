<header id="header" class="header d-flex align-items-center fixed-top">
  <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

    <a href="{{ route('home') }}" class="logo d-flex align-items-center">
      <h1 class="sitename">NOC</h1>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li>
          <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
        </li>
        <li>
          <a href="{{ route('frontend.about') }}" class="{{ request()->routeIs('frontend.about') ? 'active' : '' }}">About</a>
        </li>

        {{-- Dropdown Services --}}
        <li class="dropdown {{ request()->routeIs('noc.instalasi.*') || request()->routeIs('noc.maintenance.*') || request()->routeIs('noc.keluhan.*') || request()->routeIs('noc.terminasi.*') ? 'active' : '' }}">
          <a href="#">
            <span>Services</span>
            <i class="bi bi-chevron-down toggle-dropdown"></i>
          </a>
          <ul>
            <li>
              <a href="{{ route('noc.instalasi.form') }}" class="{{ request()->routeIs('noc.instalasi.*') ? 'active' : '' }}">Network Installation</a>
            </li>
            <li>
              <a href="{{ route('noc.maintenance.form') }}" class="{{ request()->routeIs('noc.maintenance.*') ? 'active' : '' }}">Maintenance</a>
            </li>
            <li>
              <a href="{{ route('noc.keluhan.form') }}" class="{{ request()->routeIs('noc.keluhan.*') ? 'active' : '' }}">Network Complaints</a>
            </li>
            <li>
              <a href="{{ route('noc.terminasi.form') }}" class="{{ request()->routeIs('noc.terminasi.*') ? 'active' : '' }}">Service Termination</a>
            </li>
          </ul>
        </li>

        <li>
          <a href="{{ route('frontend.tracking') }}" class="{{ request()->routeIs('frontend.tracking') ? 'active' : '' }}">Tracking Request</a>
        </li>
        <li>
          <a href="{{ route('frontend.contact') }}" class="{{ request()->routeIs('frontend.contact') ? 'active' : '' }}">Contact</a>
        </li>
        <li>
          <a href="{{ route('frontend.showpdf') }}" class="{{ request()->routeIs('frontend.showpdf') ? 'active' : '' }}">Regulasi</a>
        </li>

        @guest
        <li class="nav-profile">
          <a href="#" class="btn btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
        </li>
        @endguest

        @auth
        <li class="nav-profile dropdown">
          <a href="#" class="d-flex align-items-center" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle" style="font-size: 27px;"></i>
            <i class="bi bi-chevron-down ms-1"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
            <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item">Logout</button>
              </form>
            </li>
          </ul>
        </li>
        @endauth
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>
  </div>
</header>
<style>
.navmenu a {
  color: #ffffff;
  text-decoration: none;
  transition: color 0.2s;
}

.navmenu a:hover {
  color: #0d6efd;
}

/* Active link sederhana */
.navmenu a.active {
  color: #a9dcf8;
  font-weight: 500; /* opsional, biar agak menonjol */
}

/* Dropdown parent tetap simpel */
.navmenu .dropdown.active > a {
  color: #a9dcf8;
  font-weight: 500;
}
</style>


