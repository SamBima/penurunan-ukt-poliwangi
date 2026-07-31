<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar" style="position: sticky; top: 0; height: 100vh; background-color: #ffffff !important; border-right: 1px solid #e2e8f0; z-index: 100;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-start px-3" href="{{ route('dashboard') }}" style="height: auto; padding: 20px 14px; border-bottom: 1px solid #e2e8f0; margin-bottom: 15px;">
        <div class="sidebar-brand-icon">
            <img src="{{ url('assets/img/logo.png') }}" alt="Logo" style="width: 32px; height: 32px; object-fit: contain;">
        </div>
        <div class="sidebar-brand-text text-left ml-2" style="text-transform: none; line-height: 1.2;">
            <div style="font-size: 9px; color: #6b7280; font-weight: 500;">Sistem Informasi Akademik</div>
            <div style="font-size: 11px; color: #1e293b; font-weight: 700;">Politeknik Negeri Banyuwangi</div>
        </div>
    </a>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dasbor</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-2" style="border-top: 1px solid #e2e8f0;">

    <!-- Heading -->
    <div class="sidebar-heading" style="color: #94a3b8; font-size: 10px; font-weight: 700; text-transform: uppercase; padding-left: 16px; margin-bottom: 6px;">
        Menu Utama
    </div>

    @if (Auth::user()->role == 'mahasiswa')
        <li class="nav-item {{ request()->is('pengajuan') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('pengajuan') }}">
                <i class="fas fa-fw fa-edit"></i>
                <span>Pengajuan Penurunan</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('riwayat-pengajuan') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('riwayat-pengajuan') }}">
                <i class="fas fa-fw fa-history"></i>
                <span>Riwayat Pengajuan</span>
            </a>
        </li>
    @endif

    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'keuangan' || Auth::user()->role == 'wadir')
        <li class="nav-item {{ (request()->is('list-pengajuan') || (request()->is('list-pengajuan/*') && request('source') != 'arsip' && request('source') != 'hasil_akhir')) ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('list-pengajuan') }}">
                <i class="fas fa-fw fa-file-alt"></i>
                <span>List Pengajuan</span>
            </a>
        </li>
        <li class="nav-item {{ (request()->is('arsip-pengajuan') || (request()->is('list-pengajuan/*') && request('source') == 'arsip')) ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('arsip-pengajuan') }}">
                <i class="fas fa-fw fa-archive"></i>
                <span>Arsip</span>
            </a>
        </li>
        @if (Auth::user()->role == 'keuangan')
        <li class="nav-item {{ (request()->is('hasil-akhir-pengajuan') || (request()->is('list-pengajuan/*') && request('source') == 'hasil_akhir')) ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('hasil-akhir-pengajuan') }}">
                <i class="fas fa-fw fa-check-double"></i>
                <span>Hasil Akhir</span>
            </a>
        </li>
        @endif
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block my-2" style="border-top: 1px solid #e2e8f0;">

</ul>

