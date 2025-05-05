<ul class="menu-inner py-1">
    <!-- Dashboard -->
    {{-- <li class="menu-item {{ request()->is('/') ? 'active' : '' }}">
        <a href="{{ url('/') }}" class="menu-link">
            <i class="menu-icon bx bx-home-circle"></i>
            <div>Dashboard</div>
        </a>
    </li> --}}

    <li class="menu-item {{ request()->is('pos*') ? 'active' : '' }}">
        <a href="{{ url('/tenant/pos') }}" class="menu-link">
            <i class="menu-icon bx bx-bxs-cart-add"></i>
            <div>POS System</div>
        </a>
    </li>

    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Order</span>
    </li>

    <li class="menu-item {{ route('tenant.orders.status') }}">
        <a href="{{ route('tenant.orders.status') }}" class="menu-link">
            <i class="menu-icon bx bx-bxs-comment-check"></i>
            <div>Status Order</div>
        </a>
    </li>

    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Report</span>
    </li>

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
