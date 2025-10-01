<div class="sidebar">
    <div class="logo-details">
        <div class="logo_name">NOC KITB</div>
        <i class='bx bx-menu' id="btn"></i>
    </div>

    <ul class="nav-list">
        <li>
            <a href="{{ route('settings.profile') }}">
                <i class='bx bx-user'></i>
                <span class="links_name">Profile</span>
            </a>
            <span class="tooltip">Profile</span>
        </li>

        <li>
            <a href="{{ route('settings.service-history') }}">
                <i class='bx bx-history'></i>
                <span class="links_name">Service History</span>
            </a>
            <span class="tooltip">Service History</span>
        </li>

        <!-- Tombol Home di bawah semua menu -->
        <li class="home-button">
            <a href="{{ route('home') }}">
                <i class='bx bx-home'></i>
                <span class="links_name">Home</span>
            </a>
            <span class="tooltip">Home</span>
        </li>

        <!-- Profile Logout -->
        <li class="profile">
            <div class="profile-details">
                <img src="{{ Auth::user()->profile_photo_url ?? asset('assets/img/dummy.png') }}" alt="profileImg">
                <div class="name_job">
                    <div class="name">{{ Auth::user()->name }}</div>
                    <div class="job">{{ Auth::user()->getRoleNames()->first() ?? 'User' }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="button" style="background: none; border: none; color: inherit;" onclick="showLogoutModal();">
                    <i class='bx bx-log-out' id="log_out"></i>
                </button>
            </form>
        </li>
    </ul>
</div>

<div style="display: none;">
    @include('layouts.partials.styles-sidebar-profile')
</div>

<!-- === Logout Confirmation Modal === -->
<div id="logoutModal" class="modal">
  <div class="modal-content">
    <h3>Are you sure you want to log out?</h3>
    <p>You’ll need to log in again to access your account.</p>
    <div class="modal-actions">
      <button class="btn btn-danger" onclick="confirmLogout()">Yes, Logout</button>
      <button class="btn btn-secondary" onclick="closeLogoutModal()">Cancel</button>
    </div>
  </div>
</div>

<script>
let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let searchBtn = document.querySelector(".bx-search");

// === Fungsi Toggle ===
if (closeBtn) {
    closeBtn.addEventListener("click", ()=>{
        sidebar.classList.toggle("open");
        menuBtnChange();
    });
}
if (searchBtn) {
    searchBtn.addEventListener("click", ()=>{
        sidebar.classList.toggle("open");
        menuBtnChange();
    });
}

function menuBtnChange() {
    if(sidebar.classList.contains("open")){
        closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
    } else {
        closeBtn.classList.replace("bx-menu-alt-right","bx-menu");
    }
}

// === Atur Default State Berdasarkan Resolusi ===
function setSidebarDefault() {
    if (window.innerWidth < 768) {
        // Mobile: default tertutup
        sidebar.classList.remove("open");
    } else {
        // Desktop: default terbuka
        sidebar.classList.add("open");
    }
    menuBtnChange();
}

// Panggil saat pertama kali load
setSidebarDefault();

// Update kalau window di-resize
window.addEventListener("resize", setSidebarDefault);

// === Logout Modal ===
function showLogoutModal() {
  document.getElementById('logoutModal').style.display = 'block';
}
function closeLogoutModal() {
  document.getElementById('logoutModal').style.display = 'none';
}
function confirmLogout() {
  document.getElementById('logout-form').submit();
}
</script>

<!-- Boxicons CDN Link -->
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
