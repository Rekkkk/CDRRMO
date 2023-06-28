    <ul class="nav_list">
        @if (auth()->check() && auth()->user()->user_role == 'CDRRMO')
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
                <a href="{{ route('display.report.accident.cdrrmo') }}">
                    <i class="bi bi-megaphone text-white"></i>
                    <span class="links_name">Report Iccident</span>
                </a>
            </li>
            @if (auth()->user()->position == 'President')
                <li>
                    <a href="{{ route('display.user.accounts') }}">
                        <i class="bi bi-people text-white"></i>
                        <span class="links_name">Manage User Accounts</span>
                    </a>
                </li>
            @endif
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
        @endif
        @if (auth()->check() && auth()->user()->user_role == 'CSWD')
            <li>
                <a href="{{ route('dashboard.cswd') }}">
                    <i class="bi bi-speedometer2 text-white"></i>
                    <span class="links_name">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('manage.evacuee.record.cswd') }}">
                    <i class="bi bi-people text-white"></i>
                    <span class="links_name">Manage Evacuee Information</span>
                </a>
            </li>
            <li>
                <a href="{{ route('guideline.cswd') }}">
                    <i class="bi bi-book text-white"></i>
                    <span class="links_name">E-LIGTAS Guideline</span>
                </a>
            </li>
            <li>
                <a href="{{ route('manage.evacuation.cswd') }}">
                    <i class="bi bi-house-add text-white"></i>
                    <span class="links_name">Manage Evacuation Center</span>
                </a>
            </li>
            <li>
                <a href="{{ route('evacuation.center.locator.cswd') }}">
                    <i class="bi bi-house text-white"></i>
                    <span class="links_name">Evacuation Center Locator</span>
                </a>
            </li>
            @if (auth()->user()->position == 'Secretary')
                <li>
                    <a href="{{ route('display.user.accounts') }}">
                        <i class="bi bi-people text-white"></i>
                        <span class="links_name">Manage CSWD Accounts</span>
                    </a>
                </li>
            @endif
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
                    <span class="links_name">Report Iccident</span>
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
