    <!-- header-dashboard -->
    <div class="header-dashboard">
        <div class="wrap">
            <div class="header-left">
                <div class="button-show-hide">
                    <i class="icon-chevron-right"></i>
                </div>
            </div>
            <div class="header-grid">
                <div class="popup-wrap user type-header">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton3"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="header-user wg-user">
                                <span class="image">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&size=100&rounded=true&color=fff&background=111c43&format=svg"
                                        alt="img" width="32" height="32" class="rounded-circle">
                                </span>
                                <span class="content">
                                    <span
                                        class="text-button name">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</span>
                                </span>
                                <i class="icon icon-arrow-down"></i>
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end has-content" aria-labelledby="dropdownMenuButton3">
                            <li>
                                <a href="{{ route('admin.profile') }}" class="user-item link">
                                    <div class="text-title">Account</div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('login') }}" class="user-item link text-title"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Log out
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /header-dashboard -->
