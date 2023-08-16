<header class="header-section">
    <div class="container-fluid">
        <div class="mobile-header">
            <button type="button" class="bi bi-list" id="btn-sidebar-mobile"></button>
        </div>
        <div class="dropdown">
            <button class="bi bi-caret-down-fill" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" id="changeTheme">
                        <i class="bi bi-moon" id="themeIcon"></i><span id="themeText">Dark Mode</span></a></li>
                @auth
                    <li><a class="changePasswordBtn dropdown-item" href="#changePasswordModal" data-bs-toggle="modal">
                            <i class="bi bi-shield-lock"></i>Change Password</a></li>
                    <li><a class="myProfile dropdown-item" href="{{ route('account.display.profile') }}">
                            <i class="bi bi-person-circle"></i>My Profile</a></li>
                    <li id="logoutBtn"><a class="logout dropdown-item" href="{{ route('logout.user') }}">
                            <i class="bi bi-box-arrow-in-left"></i>Logout</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</header>
