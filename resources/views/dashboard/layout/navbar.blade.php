<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light topbar static-top" style="background-color: #badefc !important; height: 70px; padding: 0 24px; box-shadow: none !important;">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3" style="color: #1e293b !important; font-size: 1.25rem;">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto align-items-center">

        <!-- Nav Item - Layout Grid Icon -->
        <li class="nav-item mx-1">
            <a class="nav-link" href="#" style="color: #1e293b !important; font-size: 1.2rem; cursor: default;">
                <i class="fas fa-th-large"></i>
            </a>
        </li>

        <div class="topbar-divider d-none d-sm-block" style="border-right: 1px solid rgba(0, 0, 0, 0.15) !important; height: 28px; margin: 0 15px;"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 0;">
                <span class="mr-2 d-none d-lg-inline font-weight-600" style="color: #1e293b !important; font-size: 14px;">{{ Auth::user()->name }}</span>
                <img class="img-profile rounded-circle" style="width: 38px; height: 38px; border: 2px solid #ffffff; object-fit: cover;"
                    src="{{ url('assets/dashboard/img/undraw_profile.svg') }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow-lg border-0 animated--grow-in"
                aria-labelledby="userDropdown" style="border-radius: 8px; font-size: 14px;">
                <a class="dropdown-item py-2" href="{{ route('profile') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-500"></i>
                    Profile
                </a>
                <div class="dropdown-divider" style="border-top: 1px solid #f1f5f9;"></div>
                <a class="dropdown-item py-2 text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-danger"></i>
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->

