<!-- Sidebar Menu Section -->
<div class="section-menu-left">
    <div class="menu-backdrop"></div>

    <!-- Logo -->
    <div class="box-logo">
        <a href="{{ route('dashboard.index') }}" id="site-logo-inner">
            <img id="logo_header" alt="Logo" src="{{ asset('images/logo/logo.svg') }}"
                data-light="{{ asset('images/logo/logo.svg') }}" data-dark="{{ asset('images/logo/logo-dark.svg') }}">
        </a>
        <div class="button-show-hide">
            <i class="icon-chevron-left"></i>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <div class="section-menu-left-wrap">
        <div class="center">
            <ul class="menu-list">
                <!--Cashier Dashboard -->
                <li class="menu-item">
                    <a href="{{ route('dashboard.index') }}"
                        class="menu-item-button {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                        <div class="icon"><i class="icon-house"></i></div>
                        <div class="text text-title">Dashboard</div>
                    </a>
                </li>
                <!-- Admin Dashboard Menu -->
                @role('Admin')
                    <li class="menu-item">
                        <a href="{{ route('dashboard.index') }}"
                            class="menu-item-button {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                            <div class="icon"><i class="icon-house"></i></div>
                            <div class="text text-title">Dashboard</div>
                        </a>
                    </li>
                    <!-- Staff Menu -->
                    <li class="menu-item">
                        <a href="{{ route('staff.index') }}"
                            class="menu-item-button {{ request()->routeIs('staff.index') ? 'active' : '' }}">
                            <div class="icon"><i class="icon-users"></i></div>
                            <div class="text text-title">Staff</div>
                        </a>
                    </li>

                    <!-- Category -->
                    <li class="menu-item">
                        <a href="{{ route('category.index') }}"
                            class="menu-item-button {{ request()->routeIs('category.index') ? 'active' : '' }}">
                            <div class="icon"><i class="icon-folders"></i></div>
                            <div class="text text-title">Categories</div>
                        </a>
                    </li>

                    <!-- Product -->
                    <li class="menu-item">
                        <a href="{{ route('product.index') }}"
                            class="menu-item-button {{ request()->routeIs('product.index') ? 'active' : '' }}">
                            <div class="icon"> <i class="icon-package"></i>
                            </div>
                            <div class="text text-title">Products</div>
                        </a>
                    </li>
                @endrole
                <!-- Logout -->
                <li class="menu-item">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="menu-item-button">
                        <div class="icon"><i class="icon-sign-out"></i></div>
                        <div class="text text-title">Logout</div>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>
        </div>
    </div>
</div>
