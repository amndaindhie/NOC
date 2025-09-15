<header id="header" class="header d-flex align-items-center fixed-top">
  <div
    class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between"
  >
    <a href="{{ route('home') }}" class="logo d-flex align-items-center">
      <h1 class="sitename">NOC</h1>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="{{ route('home') }}" class="active">Home</a></li>
        <li><a href="{{ route('frontend.about') }}">About</a></li>
        <li class="dropdown">
          <a href="#"
            ><span>Services</span>
            <i class="bi bi-chevron-down toggle-dropdown"></i
          ></a>
          <ul>
            <li>
              <a href="{{ route('noc.instalasi.form') }}"
                >Network Installation</a
              >
            </li>
            <li><a href="{{ route('noc.maintenance.form') }}">Maintenance</a></li>
            <li><a href="{{ route('noc.keluhan.form') }}">Network Complaints</a></li>
            <li>
              <a href="{{ route('noc.terminasi.form') }}"
                >Service Termination</a
              >
            </li>
          </ul>
        </li>
        <li><a href="{{ route('frontend.tracking') }}">Tracking Request</a></li>
        <li><a href="{{ route('frontend.contact') }}">Contact</a></li>
        @guest
        <li class="nav-profile">
          <a
            href="#"
            class="btn btn-login"
            title="Login"
            data-bs-toggle="modal"
            data-bs-target="#loginModal"
          >
            Login
          </a>
        </li>
        @endguest

        @auth
        <li class="nav-profile dropdown">
          <a href="#" class="d-flex align-items-center" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle" style="font-size: 32px;"></i>
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
