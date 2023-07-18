<div class="sidebar fixed bg-slate-700 w-20 drop-shadow-lg">
    <div class="sidebar-header h-16 text-white cursor-pointer pt-3">
        <img id="logo" src="{{ asset('assets/img/e-ligtas-logo.png') }}" alt="Logo">
        <button type="button" class="bi bi-x text-3xl" id="btn-sidebar-close"></button>
    </div>
    <div class="sidebar-content">
        <div class="user-details py-2 bg-slate-800">
            <div class="truncate flex justify-center items-center text-white tracking-wide font-bold gap-4">
                @if (auth()->check() && auth()->user()->organization == 'CDRRMO')
                    <div title="Active" class="bg-green-600 py-2 rounded-full w-4"></div>
                    <img class="w-12" src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="Logo">
                    <span>CDRRMO Panel</span>
                @elseif (auth()->check() && auth()->user()->organization == 'CSWD')
                    <div title="Active" class="bg-green-600 py-2 rounded-full w-4"></div>
                    <span>CSWD Panel</span>
                @else
                    <div title="Resident" class="bg-yellow-500 py-2 rounded-full w-4"></div>
                    <span class="py-2">Cabuyao Resident</span>
                @endif
            </div>
        </div>
        <div class="text-center">
            <ul class="nav_list">
                @if (auth()->check() && auth()->user()->organization == 'CDRRMO')
                    <li>
                        <a href="{{ route('dashboard.cdrrmo') }}" class="menuLink">
                            <i class="bi bi-speedometer2"></i>
                            <span class="links_name">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('guideline.display') }}" class="menuLink">
                            <i class="bi bi-book"></i>
                            <span class="links_name">E-LIGTAS Guideline</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('display.report.accident') }}" class="menuLink">
                            <i class="bi bi-megaphone"></i>
                            <span class="links_name">Report Incident</span>
                        </a>
                    </li>
                    @if (auth()->user()->position == 'President')
                        <li>
                            <a href="{{ route('account.display.users') }}" class="menuLink">
                                <i class="bi bi-person-gear"></i>
                                <span class="links_name">Manage User Accounts</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('hotline.number') }}" class="menuLink">
                            <i class="bi bi-telephone"></i>
                            <span class="links_name">Hotline Numbers</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="menuLink">
                            <i class="bi bi-info-circle"></i>
                            <span class="links_name">About</span>
                        </a>
                    </li>
                @endif
                @if (auth()->check() && auth()->user()->organization == 'CSWD')
                    <li>
                        <a href="{{ route('dashboard.cswd') }}" class="menuLink">
                            <i class="bi bi-speedometer2"></i>
                            <span class="links_name">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('guideline.display') }}" class="menuLink">
                            <i class="bi bi-book"></i>
                            <span class="links_name">E-LIGTAS Guideline</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('disaster.display') }}" class="menuLink">
                            <i class="bi bi-tropical-storm"></i>
                            <span class="links_name">Manage Disaster Information</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('manage.evacuee.record') }}" class="menuLink">
                            <i class="bi bi-people"></i>
                            <span class="links_name">Manage Evacuee Information</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('manage.evacuation') }}" class="menuLink">
                            <i class="bi bi-house-gear"></i>
                            <span class="links_name">Manage Evacuation Center</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('evacuation.center.locator') }}" class="menuLink">
                            <i class="bi bi-house"></i>
                            <span class="links_name">Evacuation Center Locator</span>
                        </a>
                    </li>
                    @if (auth()->user()->position === 'Focal')
                        <li>
                            <a href="{{ route('account.display.users') }}" class="menuLink">
                                <i class="bi bi-person-gear"></i>
                                <span class="links_name">Manage CSWD Accounts</span>
                            </a>
                        </li>
                    @endif
                @endif
                @guest
                    <li>
                        <a href="{{ route('resident.guideline') }}" class="menuLink">
                            <i class="bi bi-book"></i>
                            <span class="links_name">E-LIGTAS Guidelines</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('resident.evacuation.center.locator') }}" class="menuLink">
                            <i class="bi bi-house"></i>
                            <span class="links_name">Evacuation Center Locator</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('resident.display.report.accident') }}" class="menuLink">
                            <i class="bi bi-megaphone"></i>
                            <span class="links_name">Report Incident</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('resident.hotline.number') }}" class="menuLink">
                            <i class="bi bi-telephone"></i>
                            <span class="links_name">Hotline Numbers</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('resident.about') }}" class="menuLink">
                            <i class="bi bi-info-circle"></i>
                            <span class="links_name">About</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}" id="loginLink">
                            <i class="bi bi-box-arrow-in-right"></i>
                            <span class="links_name">Login</span>
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</div>
