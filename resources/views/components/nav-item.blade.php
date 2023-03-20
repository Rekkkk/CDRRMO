<ul class="nav_list">
    @auth
    <li>
        <a href="{{ route('Cdashboard') }}">
            <i class="fbi bi-tv text-white"></i>
            <span class="links_name">Dashboard</span>
        </a>
    </li>
    <li>
        <a href="{{ route('CaddData') }}">
            <i class="bi bi-person-plus text-white"></i>
            <span class="links_name">Add Data</span>
        </a>
    </li>
    <li>
        <a href="{{ route('Cguidelines') }}">
            <i class="bi bi-book text-white"></i>
            <span class="links_name">E-LIGTAS Guidelines</span>
        </a>
    </li>
    <li>
        <a href="{{ route('Cevacuation') }}">
            <i class="bi bi-house text-white"></i>
            <span class="links_name">Manage Evacuation Center</span>
        </a>
    </li>
    <li>
        <a href="{{ route('CNumbers') }}">
            <i class="bi bi-telephone text-white"></i>
            <span class="links_name">Hotline Numbers</span>
        </a>
    </li>
    <li>
        <a href="{{ route('Cstatistics') }}">
            <i class="bi bi-graph-up text-white"></i>
            <span class="links_name">Data Analytics</span>
        </a>
    </li>
    <li>
        <a href="{{ route('Cabout') }}">
            <i class="bi bi-info-circle text-white"></i>
            <span class="links_name">About</span>
        </a>
    </li>
    <li>
        <form action="{{ route('Clogout') }}" method="POST" class="flex ites-center whitespace-nowrap hover:bg-red-900 cursor-pointer">
            @csrf
            <i class="bi bi-box-arrow-in-left text-white"></i>
            <button class="links_name">Logout</button>
        </form>
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