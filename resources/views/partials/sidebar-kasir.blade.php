<ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item {{ request()->is('/') ? 'active' : '' }}">
        <a href="{{ url('/') }}" class="menu-link">
            <i class="menu-icon bx bx-home-circle"></i>
            <div>Dashboard</div>
        </a>
    </li>

    <li class="menu-item {{ request()->is('kasir*') ? 'active' : '' }}">
        <a href="{{ route('kasir.index') }}" class="menu-link">
            <i class="menu-icon bx bx-bxs-cart-add"></i>
            <div>POS Kasir</div>
        </a>
    </li>

</ul>
