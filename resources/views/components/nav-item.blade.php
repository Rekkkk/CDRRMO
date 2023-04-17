<ul class="nav_list">
    @auth
    <li>
        <a href="{{ route('Cdashboard') }}">
            <i class="bi bi-speedometer2 text-white"></i>
            <span class="links_name">Dashboard</span>
        </a>
    </li>
    <li>
        <a href="{{ route('CrecordEvacuee') }}">
            <i class="bi bi-person-plus text-white"></i>
            <span class="links_name">Record Evacuee</span>
        </a>
    </li>
    <li>
        <a href="{{ route('Cguidelines') }}">
            <i class="bi bi-book text-white"></i>
            <span class="links_name">E-LIGTAS Guidelines</span>
        </a>
    </li>
    <li>
        <a href="{{ route('Cdisaster') }}">
            <i class="bi bi-tropical-storm text-white"></i>
            <span class="links_name">Disaster Identification</span>
        </a>
    </li>
    <li>
        <a href="{{ route('Cbaranggay') }}">
            <i class="bi bi-hospital text-white"></i>
            <span class="links_name">Baranggay Information</span>
        </a>
    </li>
    <li>
        <a href="{{ route('Cevacuationmanage') }}">
            <i class="bi bi-house-add text-white"></i>
            <span class="links_name">Manage Evacuation Center</span>
        </a>
    </li>
    <li>
        <a href="{{ route('Cevacuation') }}">
            <i class="bi bi-house text-white"></i>
            <span class="links_name">Evacuation Center Locator</span>
        </a>
    </li>
    <li>
        <a href="{{ route('Cstatistics') }}">
            <i class="bi bi-graph-up text-white"></i>
            <span class="links_name">Data Statistics</span>
        </a>
    </li>
    <li>
        <a href="{{ route('Creport') }}">
            <i class="bi bi-megaphone text-white"></i>
            <span class="links_name">Report Accident</span>
        </a>
    </li>
    <li>
        <a href="{{ route('CNumbers') }}">
            <i class="bi bi-telephone text-white"></i>
            <span class="links_name">Hotline Numbers</span>
        </a>
    </li>
    <li>
        <a href="{{ route('Cabout') }}">
            <i class="bi bi-info-circle text-white"></i>
            <span class="links_name">About</span>
        </a>
    </li>
    <li>
        <a href="{{ route('Clogout') }}">
            <i class="bi bi-box-arrow-in-left text-white"></i>
            <span class="links_name">Logout</span>
        </a>
    </li>
    @else
    <li>
        <a href="{{ route('Gdashboard') }}">
            <i class="fbi bi-tv text-white"></i>
            <span class="links_name">Dashboard</span>
        </a>
    </li>
    <li>
        <a href="{{ route('Gguidelines') }}">
            <i class="bi bi-book text-white"></i>
            <span class="links_name">E-LIGTAS Guidelines</span>
        </a>
    </li>
    <li>
        <a href="{{ route('GEvacuation') }}">
            <i class="bi bi-house text-white"></i>
            <span class="links_name">CDRRMO Evacuation Center</span>
        </a>
    </li>
    <li>
        <a href="{{ route('Greport') }}">
            <i class="bi bi-megaphone text-white"></i>
            <span class="links_name">Report Accident</span>
        </a>
    </li>
    <li>
        <a href="{{ route('GNumbers') }}">
            <i class="bi bi-telephone text-white"></i>
            <span class="links_name">Hotline Numbers</span>
        </a>
    </li>
    <li>
        <a href="{{ route('Gabout') }}">
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
    @endauth
</ul>
