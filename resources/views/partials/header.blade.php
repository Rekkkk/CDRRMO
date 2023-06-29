<header class="header-section bg-red-700 drop-shadow-lg h-16 w-full">
    <div class="container-fluid relative flex justify-between items-center h-full">
        <div class="mobile-header">
            <button type="button" class="bi bi-list text-white cursor-pointer text-2xl" id="btn-sidebar-mobile"></button>
        </div>
        @if (
            (auth()->check() && auth()->user()->user_role == 'CDRRMO') ||
                (auth()->check() && auth()->user()->user_role == 'CSWD'))
            <div class="dropdown px-2">
                <button class="text-white text-sm bi bi-caret-down-fill" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item text-sm" href="{{ route('display.user.profile') }}"><i
                                class="bi bi-person pr-2"></i>My Profile</a></li>
                    <li><a class="dropdown-item text-sm" href="{{ route('logout.user') }}"><i
                                class="bi bi-box-arrow-in-left pr-2"></i>Logout</a></li>
                </ul>
            </div>
        @endif
    </div>
</header>
