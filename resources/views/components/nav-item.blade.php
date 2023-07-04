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
                        <i class="bi bi-people text-white"></i>
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
                    <i class="bi bi-house-add text-white"></i>
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
                        <i class="bi bi-people text-white"></i>
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
                    <span class="links_name">Report Iccident</span>
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
