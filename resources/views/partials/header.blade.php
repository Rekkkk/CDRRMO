<header class="header-section">
    <div class="container-fluid">
        <div class="mobile-header">
            <button type="button" class="bi bi-list" id="btn-sidebar-mobile"></button>
        </div>
        @auth
            <div class="dropdown">
                <button class="bi bi-caret-down-fill" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                </button>
                <ul class="dropdown-menu">
                    <li><a class="changePasswordBtn dropdown-item" href="#changePasswordModal" data-bs-toggle="modal"><i
                                class="bi bi-shield-lock"></i>Change
                            Password</a></li>
                    <li><a class="myProfile dropdown-item" href="{{ route('account.display.profile') }}"><i
                                class="bi bi-person-circle"></i>My
                            Profile</a></li>
                    <li id="logoutBtn"><a class="logout dropdown-item" href="{{ route('logout.user') }}"><i
                                class="bi bi-box-arrow-in-left"></i>Logout</a>
                    </li>
                </ul>
            </div>
        @endauth
    </div>
</header>
