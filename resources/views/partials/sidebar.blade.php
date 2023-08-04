<div class="sidebar">
    <div class="sidebar-header">
        <img id="logo" src="{{ asset('assets/img/e-ligtas-logo.png') }}" alt="Logo">
        <button type="button" class="bi bi-x" id="btn-sidebar-close"></button>
    </div>
    <div class="sidebar-content">
        <div class="user-details">
            <div class="details-content">
                @if (auth()->check() && auth()->user()->organization == 'CDRRMO')
                    @if (auth()->user()->is_disable == 0)
                        <div title="Active" class="user-active"></div>
                    @else
                        <div title="Currently Disabled" class="user-disable"></div>
                    @endif
                    <img src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="Logo">
                    <span>CDRRMO Panel</span>
                @elseif (auth()->check() && auth()->user()->organization == 'CSWD')
                    @if (auth()->user()->is_disable == 0)
                        <div title="Active" class="user-active"></div>
                    @else
                        <div title="Currently Disabled" class="user-disable"></div>
                    @endif
                    <img src="{{ asset('assets/img/CSWDO-LOGO.png') }}" alt="Logo">
                    <span>CSWDO Panel</span>
                @else
                    <div title="Resident" class="resident"></div>
                    <span class="py-2">Cabuyao Resident</span>
                @endif
            </div>
        </div>
        <div class="text-center">
            <ul class="nav_list">
                @if (auth()->check() && auth()->user()->organization == 'CDRRMO')
                    <li>
                        <a href="{{ route('dashboard.cdrrmo') }}" class="menu-link">
                            <i class="bi bi-speedometer2"></i>
                            <span class="links_name">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('guideline.display') }}" class="menu-link">
                            <i class="bi bi-book"></i>
                            <span class="links_name">E-LIGTAS Guideline</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('display.incident.report') }}" class="menu-link">
                            <i class="bi bi-megaphone"></i>
                            <span class="links_name">Report Incident</span>
                        </a>
                    </li>
                    @if (auth()->user()->position == 'President')
                        <li>
                            <a href="{{ route('account.display.users') }}" class="menu-link">
                                <i class="bi bi-person-gear"></i>
                                <span class="links_name">Manage User Accounts</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('hotline.number') }}" class="menu-link">
                            <i class="bi bi-telephone"></i>
                            <span class="links_name">Hotline Numbers</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="menu-link">
                            <i class="bi bi-info-circle"></i>
                            <span class="links_name">About</span>
                        </a>
                    </li>
                @endif
                @if (auth()->check() && auth()->user()->organization == 'CSWD')
                    <li>
                        <a href="{{ route('dashboard.cswd') }}" class="menu-link">
                            <i class="bi bi-speedometer2"></i>
                            <span class="links_name">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('guideline.display') }}" class="menu-link">
                            <i class="bi bi-book"></i>
                            <span class="links_name">E-LIGTAS Guideline</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('disaster.display') }}" class="menu-link">
                            <i class="bi bi-tropical-storm"></i>
                            <span class="links_name">Manage Disaster Information</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('manage.evacuee.record') }}" class="menu-link">
                            <i class="bi bi-people"></i>
                            <span class="links_name">Manage Evacuee Information</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('manage.evacuation') }}" class="menu-link">
                            <i class="bi bi-house-gear"></i>
                            <span class="links_name">Manage Evacuation Center</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('evacuation.center.locator') }}" class="menu-link">
                            <i class="bi bi-house"></i>
                            <span class="links_name">Evacuation Center Locator</span>
                        </a>
                    </li>
                    @if (auth()->user()->position === 'Focal')
                        <li>
                            <a href="{{ route('account.display.users') }}" class="menu-link">
                                <i class="bi bi-person-gear"></i>
                                <span class="links_name">Manage User Accounts</span>
                            </a>
                        </li>
                    @endif
                @endif
                @guest
                    <li>
                        <a href="{{ route('resident.guideline') }}" class="menu-link">
                            <i class="bi bi-book"></i>
                            <span class="links_name">E-LIGTAS Guidelines</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('resident.evacuation.center.locator') }}" class="menu-link">
                            <i class="bi bi-house"></i>
                            <span class="links_name">Evacuation Center Locator</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('resident.display.incident.report') }}" class="menu-link">
                            <i class="bi bi-megaphone"></i>
                            <span class="links_name">Report Incident</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('resident.hotline.number') }}" class="menu-link">
                            <i class="bi bi-telephone"></i>
                            <span class="links_name">Hotline Numbers</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('resident.about') }}" class="menu-link">
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
