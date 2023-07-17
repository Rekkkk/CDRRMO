<header class="header-section bg-red-600 drop-shadow-lg h-16 w-full">
    <div class="container-fluid relative flex justify-between items-center h-full">
        <div class="mobile-header">
            <button type="button" class="bi bi-list text-white cursor-pointer text-2xl" id="btn-sidebar-mobile"></button>
        </div>

        @if (auth()->check())
            <div class="dropdown">
                <button class="text-white text-sm bi bi-caret-down-fill" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                </button>
                <ul class="dropdown-menu">
                    @can('view', \App\Models\User::class)
                        <li class="px-2"><a class="dropdown-item rounded-sm hover:bg-gray-200 active:bg-blue-600"
                                href="{{ route('account.change.password') }}"><i class="bi bi-shield-lock pr-2"></i>Change
                                Password</a></li>
                        <li class="px-2"><a class="dropdown-item rounded-sm hover:bg-gray-200 active:bg-green-600"
                                href="{{ route('account.display.profile') }}"><i class="bi bi-person-circle pr-2"></i>My
                                Profile</a></li>
                    @endcan
                    <li class="px-2" id="logoutBtn"><a class="dropdown-item rounded-sm hover:bg-gray-200 active:bg-red-600"
                            href="{{ route('logout.user') }}"><i class="bi bi-box-arrow-in-left pr-2"></i>Logout</a>
                    </li>
                </ul>
            </div>
        @endif
    </div>
</header>
