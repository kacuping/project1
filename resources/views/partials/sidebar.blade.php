<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('template/assets/img/logo.png') }}" alt="Logo" width="30" />
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">Foodcourt</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    @php $role = auth()->user()->role; @endphp

    @if ($role === 'admin')
        @include('partials.sidebar-admin')
    @elseif ($role === 'kasir')
        @include('partials.sidebar-kasir')
    @elseif ($role === 'tenant')
        @include('partials.sidebar-tenant')
    @endif

    {{-- <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('/') ? 'active' : '' }}">
            <a href="{{ url('/') }}" class="menu-link">
                <i class="menu-icon bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('') ? 'active' : '' }}">
            <a href="{{ url('') }}" class="menu-link">
                <i class="menu-icon bx bx-bxs-cart-add"></i>
                <div>POS System</div>
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

        <li class="menu-item {{ request()->is('kasir*') ? 'active' : '' }}">
            <a href="{{ url('/kasir') }}" class="menu-link">
                <i class="menu-icon bx bx-receipt"></i>
                <div>Manajemen Kasir</div>
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
    </ul> --}}
</aside>
