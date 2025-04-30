<ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item {{ request()->is('/') ? 'active' : '' }}">
        <a href="{{ url('/') }}" class="menu-link">
            <i class="menu-icon bx bx-home-circle"></i>
            <div>Dashboard</div>
        </a>
    </li>

    <!-- Manajemen Tenant -->
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Manajemen</span>
    </li>
    <li class="menu-item {{ request()->is('tenants*') ? 'active' : '' }}">
        <a href="{{ url('/tenants') }}" class="menu-link">
            <i class="menu-icon bx bx-store"></i>
            <div>Manajemen Tenant</div>
        </a>
    </li>

    <!-- Manajemen Produk -->
    <li class="menu-item {{ request()->is('products*') ? 'active' : '' }}">
        <a href="{{ url('/products') }}" class="menu-link">
            <i class="menu-icon bx bx-box"></i>
            <div>Manajemen Produk</div>
        </a>
    </li>

    <!-- Manajemen User -->
    <li class="menu-item {{ request()->is('users*') ? 'active' : '' }}">
        <a href="{{ url('/users') }}" class="menu-link">
            <i class="menu-icon bx bx-user"></i>
            <div>Manajemen User</div>
        </a>
    </li>

    <!-- Kasir -->


    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">laporan</span>
    </li>
    <!-- Laporan -->
    <li class="menu-item {{ request()->is('laporan*') ? 'active' : '' }}">
        <a href="{{ url('/laporan') }}" class="menu-link menu-toggle">
            <i class="menu-icon bx bx-line-chart"></i>
            <div>Laporan</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="extended-ui-perfect-scrollbar.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Laporan Harian">Laporan Harian</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="extended-ui-text-divider.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Laporan Bulanan">Laporan Bulanan</div>
                </a>
            </li>
        </ul>
    </li>
</ul>
