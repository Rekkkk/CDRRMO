<ul class="nav_list">
    @auth
    <li>
        <a href="/cdrrmo/dashboard">
            <i class="fbi bi-tv text-white"></i>
            <span class="links_name">Dashboard</span>
        </a>
    </li>
    <li>
        <a href="/cdrrmo/addData">
            <i class="bi bi-person-plus text-white"></i>
            <span class="links_name">Add Data</span>
        </a>
    </li>
    <li>
        <a href="/cdrrmo/eligtasGuidelines">
            <i class="bi bi-book text-white"></i>
            <span class="links_name">E-LIGTAS Guidelines</span>
        </a>
    </li>
    <li>
        <a href="/cdrrmo/evacuationCenter">
            <i class="bi bi-house text-white"></i>
            <span class="links_name">Manage Evacuation Center</span>
        </a>
    </li>
    <li>dasdasdas
        <a href="/cdrrmo/hotlineNumbers">
            <i class="bi bi-telephone text-white"></i>
            <span class="links_name">Hotline Numbers</span>
        </a>
    </li>
    <li>
        <a href="/cdrrmo/statistics">
            <i class="bi bi-graph-up text-white"></i>
            <span class="links_name">Data Analytics</span>
        </a>
    </li>
    <li>
        <a href="/cdrrmo/about">
            <i class="bi bi-info-circle text-white"></i>
            <span class="links_name">About</span>
        </a>
    </li>
    <li>
        <form action="/cdrrmo/logout" method="POST" class="flex ites-center whitespace-nowrap hover:bg-red-900 cursor-pointer">
            @csrf
            <i class="bi bi-box-arrow-in-left text-white"></i>
            <button class="links_name">Logout</button>
        </form>
    </li>
    @else
    <li>
        <a href="/resident/dashboard">
            <i class="fbi bi-tv text-white"></i>
            <span class="links_name">Dashboard</span>
        </a>
    </li>
    <li>
        <a href="/resident/eligtasGuidelines">
            <i class="bi bi-book text-white"></i>
            <span class="links_name">E-LIGTAS Guidelines</span>
        </a>
    </li>
    <li>
        <a href="/resident/hotlineNumbers">
            <i class="bi bi-telephone text-white"></i>
            <span class="links_name">Hotline Numbers</span>
        </a>
    </li>
    <li>
        <a href="/resident/statistics">
            <i class="bi bi-graph-up text-white"></i>
            <span class="links_name">Data Analytics</span>
        </a>
    </li>
    <li>
        <a href="/resident/about">
            <i class="bi bi-info-circle text-white"></i>
            <span class="links_name">About</span>
        </a>
    </li>
    @endauth
</ul>