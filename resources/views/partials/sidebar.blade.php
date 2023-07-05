<div class="sidebar fixed bg-slate-700 w-20 drop-shadow-lg">
    <div class="sidebar-header h-16 text-white cursor-pointer pt-3">
        <img class="links_name text-2xl pl-4 w-36" src="{{ asset('assets/img/e-ligtas-logo.png') }}" alt="Logo">
        <button type="button" class="bi bi-x text-3xl" id="btn-sidebar-close"></button>
    </div>
    <div class="sidebar-content">
        <div class="user-details py-2 bg-slate-800">
            <div class="truncate flex justify-center items-center text-white tracking-wide font-bold gap-4">
                @if (auth()->check() && auth()->user()->organization == 'CDRRMO')
                    @if (auth()->check() && auth()->user()->status == 'Restricted')
                        <div title="Restricted" class="bg-red-600 py-2 rounded-full w-4"></div>
                    @else
                        <div title="Active" class="bg-green-600 py-2 rounded-full w-4"></div>
                    @endif
                    <img class="w-12" src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="Logo">
                    <span>CDRRMO Panel</span>
                @elseif(auth()->check() && auth()->user()->organization == 'CSWD')
                    @if (auth()->check() && auth()->user()->status == 'Restricted')
                        <div title="Restricted" class="bg-red-600 py-2 rounded-full w-4"></div>
                    @else
                        <div title="Active" class="bg-green-600 py-2 rounded-full w-4"></div>
                    @endif
                    <span>CSWD Panel</span>
                @else
                    <div title="Resident" class="bg-yellow-500 py-2 rounded-full w-4"></div>
                    <span class="py-2">Cabuyao Resident</span>
                @endif
            </div>
        </div>
        <div class="items-center text-center">
            <ul class="nav_list">
                @if (auth()->check() && auth()->user()->organization == 'CDRRMO')
                    <li>
                        <a href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 text-white"></i>
                            <span class="links_name">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('guideline.display') }}">
                            <i class="bi bi-book text-white"></i>
                            <span class="links_name">E-LIGTAS Guideline</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('display.report.accident') }}">
                            <i class="bi bi-megaphone text-white"></i>
                            <span class="links_name">Report Incident</span>
                        </a>
                    </li>
                    @if (auth()->user()->position == 'President')
                        <li>
                            <a href="{{ route('account.display.users') }}">
                                <i class="bi bi-person-gear text-white"></i>
                                <span class="links_name">Manage User Accounts</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('hotline.number') }}">
                            <i class="bi bi-telephone text-white"></i>
                            <span class="links_name">Hotline Numbers</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}">
                            <i class="bi bi-info-circle text-white"></i>
                            <span class="links_name">About</span>
                        </a>
                    </li>
                @endif
                @if (auth()->check() && auth()->user()->organization == 'CSWD')
                    <li>
                        <a href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 text-white"></i>
                            <span class="links_name">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('manage.evacuee.record') }}">
                            <i class="bi bi-people text-white"></i>
                            <span class="links_name">Manage Evacuee Information</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('guideline.display') }}">
                            <i class="bi bi-book text-white"></i>
                            <span class="links_name">E-LIGTAS Guideline</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('manage.evacuation') }}">
                            <i class="bi bi-house-gear text-white"></i>
                            <span class="links_name">Manage Evacuation Center</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('evacuation.center.locator') }}">
                            <i class="bi bi-house text-white"></i>
                            <span class="links_name">Evacuation Center Locator</span>
                        </a>
                    </li>
                    @if (auth()->user()->position == 'Secretary')
                        <li>
                            <a href="{{ route('account.display.users') }}">
                                <i class="bi bi-person-gear text-white"></i>
                                <span class="links_name">Manage CSWD Accounts</span>
                            </a>
                        </li>
                    @endif
                @endif
                @guest
                    <li>
                        <a href="{{ route('resident.guideline') }}">
                            <i class="bi bi-book text-white"></i>
                            <span class="links_name">E-LIGTAS Guidelines</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('resident.evacuation.center') }}">
                            <i class="bi bi-house text-white"></i>
                            <span class="links_name">CDRRMO Evacuation Center</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('resident.display.report.accident') }}">
                            <i class="bi bi-megaphone text-white"></i>
                            <span class="links_name">Report Incident</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('resident.hotline.number') }}">
                            <i class="bi bi-telephone text-white"></i>
                            <span class="links_name">Hotline Numbers</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('resident.about') }}">
                            <i class="bi bi-info-circle text-white"></i>
                            <span class="links_name">About</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right text-white"></i>
                            <span class="links_name">Login</span>
                        </a>
                    </li>
                @endguest
            </ul>

        </div>
    </div>
</div>
