    <ul class="nav_list">
        @if (Auth::check() && Auth::user()->user_role == 'CDRRMO')
            <li>
                <a href="{{ route('dashboard.cdrrmo') }}">
                    <i class="bi bi-speedometer2 text-white"></i>
                    <span class="links_name">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('guideline.cdrrmo') }}">
                    <i class="bi bi-book text-white"></i>
                    <span class="links_name">E-LIGTAS Guideline</span>
                </a>
            </li>
            <li>
                <a href="{{ route('disaster.cdrrmo') }}">
                    <i class="bi bi-tropical-storm text-white"></i>
                    <span class="links_name">Disaster Identification</span>
                </a>
            </li>
            <li>
                <a href="{{ route('manage.evacuation.cdrrmo') }}">
                    <i class="bi bi-house-add text-white"></i>
                    <span class="links_name">Manage Evacuation Center</span>
                </a>
            </li>
            <li>
                <a href="{{ route('evacuation.center.locator.cdrrmo') }}">
                    <i class="bi bi-house text-white"></i>
                    <span class="links_name">Evacuation Center Locator</span>
                </a>
            </li>
            <li>
                <a href="{{ route('statistics.cdrrmo') }}">
                    <i class="bi bi-graph-up text-white"></i>
                    <span class="links_name">Data Statistics</span>
                </a>
            </li>
            <li>
                <a href="{{ route('display.report.accident.cdrrmo') }}">
                    <i class="bi bi-megaphone text-white"></i>
                    <span class="links_name">Report Accident</span>
                </a>
            </li>
            <li>
                <a href="{{ route('hotline.number.cdrrmo') }}">
                    <i class="bi bi-telephone text-white"></i>
                    <span class="links_name">Hotline Numbers</span>
                </a>
            </li>
            <li>
                <a href="{{ route('about.cdrrmo') }}">
                    <i class="bi bi-info-circle text-white"></i>
                    <span class="links_name">About</span>
                </a>
            </li>
            <li>
                <a href="{{ route('logout.user') }}">
                    <i class="bi bi-box-arrow-in-left text-white"></i>
                    <span class="links_name">Logout</span>
                </a>
            </li>
        @endif
        @if (Auth::check() && Auth::user()->user_role == 'CSWD')
            <li>
                <a href="{{ route('dashboard.cswd') }}">
                    <i class="bi bi-speedometer2 text-white"></i>
                    <span class="links_name">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('display.record.evacuee.cswd') }}">
                    <i class="bi bi-person-plus text-white"></i>
                    <span class="links_name">Record Evacuee</span>
                </a>
            </li>
            <li>
                <a href="{{ route('statistics.cswd') }}">
                    <i class="bi bi-graph-up text-white"></i>
                    <span class="links_name">Data Statistics</span>
                </a>
            </li>
            <li>
                <a href="{{ route('logout.user') }}">
                    <i class="bi bi-box-arrow-in-left text-white"></i>
                    <span class="links_name">Logout</span>
                </a>
            </li>
        @endif
        @if (Auth::check() && Auth::user()->user_role == 'Developer')
            <li>
                <a href="{{ route('logout.user') }}">
                    <i class="bi bi-box-arrow-in-left text-white"></i>
                    <span class="links_name">Logout</span>
                </a>
            </li>
        @endif
        @guest
            <li>
                <a href="{{ route('guideline.resident') }}">
                    <i class="bi bi-book text-white"></i>
                    <span class="links_name">E-LIGTAS Guidelines</span>
                </a>
            </li>
            <li>
                <a href="{{ route('evacuation.center.resident') }}">
                    <i class="bi bi-house text-white"></i>
                    <span class="links_name">CDRRMO Evacuation Center</span>
                </a>
            </li>
            <li>
                <a href="{{ route('display.report.accident.resident') }}">
                    <i class="bi bi-megaphone text-white"></i>
                    <span class="links_name">Report Accident</span>
                </a>
            </li>
            <li>
                <a href="{{ route('hotline.number.resident') }}">
                    <i class="bi bi-telephone text-white"></i>
                    <span class="links_name">Hotline Numbers</span>
                </a>
            </li>
            <li>
                <a href="{{ route('about.resident') }}">
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
