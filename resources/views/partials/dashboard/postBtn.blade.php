{{-- @auth
    <form action="#" method="#" class="rounded text-sm p-3 bg-red-700 mx-2 absolute my-4">
        <button type="submit" class="bi bi-trash3-fill text-base"></button>
    </form>
    <form action="#" method="#" class="rounded text-sm p-3 bg-yellow-600 hover:bg-yellow-500 mx-16 absolute my-4">
        <button type="submit" class="bi bi-pencil-fill text-base"></button>
    </form>
@endauth --}}
@auth
<nav class="mx-4 float-right">
  <div class="setting-container absolute">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Update Announcement</a></li>
                    <li><a class="dropdown-item" href="#">Delete Announcement</a></li>
                </ul>
            </li>
        </ul>
  </div>
</nav>
@endauth