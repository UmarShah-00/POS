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
                <!-- Dashboard Menu -->
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
            </ul>
        </div>
    </div>
</div>
