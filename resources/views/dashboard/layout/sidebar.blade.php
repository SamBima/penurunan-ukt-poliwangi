<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="position: sticky; top: 0; height: 100%;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ url('assets/img/logo.png') }}" alt="Logo" width="50">
        </div>
        <div class="sidebar-brand-text mx-3">SISTEM PENYESUAIAN UKT</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

    @if (Auth::user()->role == 'mahasiswa')
        <li class="nav-item {{ request()->is('pengajuan') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('pengajuan') }}">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Pengajuan Penurunan</span></a>
        </li>

        <li class="nav-item {{ request()->is('riwayat-pengajuan') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('riwayat-pengajuan') }}">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Riwayat Pengajuan</span></a>
        </li>
    @endif

    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'keuangan' || Auth::user()->role == 'wadir')
        <li class="nav-item {{ request()->is('list-pengajuan') || request()->is('list-pengajuan/*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('list-pengajuan') }}">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>List Pengajuan</span></a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Pengaturan
    </div>

    <li class="nav-item {{ request()->is('profile') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('profile') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Profile</span></a>
    </li>

    <!-- Sidebar Message -->
    {{-- <div class="sidebar-card d-none d-lg-flex">
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
    </div> --}}

</ul>
