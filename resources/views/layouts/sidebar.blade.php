<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/home">
        <div class="sidebar-brand-text mx-3">X Media Nusantara</div>
    </a>
    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
        <a class="nav-link" href="/home">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ request()->is('packages*') ? 'active' : '' }}">
        <a class="nav-link" href="/packages">
            <i class="fa fa-fw fa-cube"></i>
            <span>Paket Internet</span></a>
    </li>

    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ request()->is('invoices*') ? 'active' : '' }}">
        <a class="nav-link" href="/invoices">
            <i class="fa fa-fw fa-receipt"></i>
            <span>Tagihan</span></a>
    </li>

    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ request()->is('payments*') ? 'active' : '' }}">
        <a class="nav-link" href="/payments">
            <i class="fa fa-fw fa-receipt"></i>
            <span>Metode Pembayaran</span></a>
    </li>

    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ request()->is('content*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#contentCollapse"
            aria-expanded="{{ request()->is('content*') ? 'true' : 'false' }}" aria-controls="contentCollapse">
            <i class="fas fa-fw fa-tasks"></i>
            <span>CMS</span>
        </a>
        <div id="contentCollapse" class="collapse {{ request()->is('content*') ? 'show' : '' }}"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('content/articles*') ? 'active' : '' }}"
                    href="/content/articles">Artikel</a>
                <a class="collapse-item {{ request()->is('content/promos*') ? 'active' : '' }}"
                    href="/content/promos">Promo</a>
                <a class="collapse-item {{ request()->is('content/notifications*') ? 'active' : '' }}"
                    href="/content/notifications">Notifikasi</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ request()->is('user*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#userCollapse"
            aria-expanded="{{ request()->is('user*') ? 'true' : 'false' }}" aria-controls="userCollapse">
            <i class="fas fa-fw fa-users"></i>
            <span>Pengguna</span>
        </a>
        <div id="userCollapse" class="collapse {{ request()->is('user*') ? 'show' : '' }}"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('user/clients*') ? 'active' : '' }}"
                    href="/user/clients">Daftar
                    Pelanggan</a>
                <a class="collapse-item {{ request()->is('user/employees*') ? 'active' : '' }}"
                    href="/user/employees">Daftar Teknisi</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
