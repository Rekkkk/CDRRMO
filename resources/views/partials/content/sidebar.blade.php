<div class="sidebar w-20">
    <div class="sidebar-header h-20">
        <span class="links_name text-2xl">E-LIGTAS</span>
        <button type="button" class="bi bi-list text-white cursor-pointer text-3xl" id="btn-sidebar"></button>
    </div>
    <div class="sidebar-content">
        <div class="items-center text-center">
            <x-nav-item />
        </div>
        <div class="user-footer-section absolute bottom-0 text-white">
            @if (Auth::check() && Auth::user()->user_role == 'CDRRMO')
                CDRRMO
            @elseif(Auth::check() && Auth::user()->user_role == 'CSWD')
                CSWD
            @elseif(Auth::check() && Auth::user()->user_role == 'Developer')
                Developer
            @else
                Cabuyao Resident
            @endif
        </div>
    </div>
</div>
