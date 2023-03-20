@auth
<nav class="mx-4 float-right">
  <div class="setting-container absolute">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('CEditAnnouncement', ['announcement_id' => $announcement->announcement_id]) }}">Update Announcement</a></li>
                    <li><a class="dropdown-item" href="{{ route('CDeleteAnnouncement', ['announcement_id' => $announcement->announcement_id]) }}">Delete Announcement</a></li>
                </ul>
            </li>
        </ul>
  </div>
</nav>
@endauth