<header id="header" class="header d-flex align-items-center fixed-top">
  <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo d-flex align-items-center">
      <h1 class="sitename">NOC KITB</h1>
    </a>

    <!-- Navigation -->
    <nav id="navmenu" class="navmenu">
      <ul>
        <li>
          <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
        </li>
        <li>
          <a href="{{ route('frontend.about') }}" class="{{ request()->routeIs('frontend.about') ? 'active' : '' }}">About</a>
        </li>

        <!-- Services Dropdown -->
        <li class="dropdown {{ request()->routeIs('noc.instalasi.*') || request()->routeIs('noc.maintenance.*') || request()->routeIs('noc.keluhan.*') || request()->routeIs('noc.terminasi.*') ? 'active' : '' }}">
          <a href="#"><span>Services</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="{{ route('noc.instalasi.form') }}" class="{{ request()->routeIs('noc.instalasi.*') ? 'active' : '' }}">Network Installation</a></li>
            <li><a href="{{ route('noc.maintenance.form') }}" class="{{ request()->routeIs('noc.maintenance.*') ? 'active' : '' }}">Maintenance</a></li>
            <li><a href="{{ route('noc.keluhan.form') }}" class="{{ request()->routeIs('noc.keluhan.*') ? 'active' : '' }}">Network Complaints</a></li>
            <li><a href="{{ route('noc.terminasi.form') }}" class="{{ request()->routeIs('noc.terminasi.*') ? 'active' : '' }}">Service Termination</a></li>
          </ul>
        </li>

        <li><a href="{{ route('frontend.tracking') }}" class="{{ request()->routeIs('frontend.tracking') ? 'active' : '' }}">Track Request</a></li>
        <li><a href="{{ route('frontend.showpdf') }}" class="{{ request()->routeIs('frontend.showpdf') ? 'active' : '' }}">Regulations</a></li>
        <li><a href="{{ route('frontend.contact') }}" class="{{ request()->routeIs('frontend.contact') ? 'active' : '' }}">Contact</a></li>

        <!-- Login / Profile -->
        @guest
        <li class="nav-profile">
          <a href="#" class="btn btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
        </li>
        @endguest

@auth
<li class="dropdown">
  <a href="#">
    <i class="bi bi-person me-2 fs-5 mb-1"></i> <!-- Icon profil ditambahkan -->
    <span>{{ Auth::user()->name }}</span> 
    <i class="bi bi-chevron-down toggle-dropdown"></i>
  </a>

  <ul>
    <li>
      <a href="{{ route('settings.profile') }}">
        Profile
      </a>
    </li>
    <li>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button style="font-size: 14px" type="submit" class="text-danger">
          <i class="bi bi-box-arrow-right me-2"></i>
          Logout
        </button>
      </form>
    </li>
  </ul>
</li>
@endauth

      </ul>

      <!-- Mobile toggle -->
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>
  </div>
</header>

<style>
/* Navbar links */
.navmenu a {
  color: #ffffff;
  text-decoration: none;
  transition: color 0.2s;
}
.navmenu a:hover {
  color: #0d6efd;
}
.navmenu a.active {
  color: #a9dcf8;
  font-weight: 500;
}

/* Dropdown parent */
.navmenu .dropdown.active > a {
  color: #a9dcf8;
  font-weight: 500;
}

/* Profile Link */
.nav-profile-link {
  color: #fff;
  text-decoration: none;
  transition: color 0.2s;
}
.nav-profile-link:hover {
  color: #a9dcf8;
}

/* Dropdown Items - Desktop */
/* Dropdown Items - Desktop */
.dropdown ul {
  min-width: 250px;
  position: absolute;
  background-color: #fff;
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
  border-radius: 0.375rem;
  z-index: 2000;
}

.dropdown ul li a,
.dropdown ul button {
  font-size: 14px;
  padding: 10px 16px;
  transition: background 0.2s, color 0.2s;
  color: #ffffff; /* 🔥 ganti dari putih ke hitam elegan */
  display: block;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  cursor: pointer;
}

.dropdown ul li a:hover,
.dropdown ul button:hover {
  background-color: #f1f5f9;
  color: #0d6efd;
}

.dropdown ul button.text-danger {
  color: #dc3545 !important;
}

.dropdown ul button.text-danger:hover {
  color: #dc3545 !important;
  background-color: #f1f5f9;
}

/* Fix dropdown mobile */
@media (max-width: 991px) {
  .dropdown ul {
    position: absolute;
    background-color: #1e4356;
    margin-top: 5px;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border-radius: 0.375rem;
    left: 0;
    min-width: 250px;
  }
  .dropdown ul a,
  .dropdown ul button {
    color: #ffffff; /* 🔥 mobile tetap putih biar kontras */
    display: block;
    padding: 10px 16px;
    font-size: 14px;
    transition: background 0.2s, color 0.2s;
  }
  .dropdown ul a:hover,
  .dropdown ul button:hover {
    background-color: #0d6efd;
    color: #ffffff;
  }
}

</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

