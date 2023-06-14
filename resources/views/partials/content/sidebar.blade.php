<div class="sidebar bg-slate-700 w-20 shadow-lg">
    <div class="sidebar-header h-20">
        <span class="links_name text-2xl">E-LIGTAS</span>
        <button type="button" class="bi bi-pin text-white cursor-pointer text-2xl" id="btn-sidebar"></button>
        <button type="button" class="bi bi-x text-white cursor-pointer text-3xl" id="btn-sidebar-close"></button>
    </div>
    <div class="sidebar-content">
        <div class="items-center text-center">
            <x-nav-item />
        </div>
        <div class="user-footer-section absolute left-2 bottom-2 text-white">
            @if (Auth::check() && Auth::user()->user_role == 'CDRRMO')
                CDRRMO Panel
            @elseif(Auth::check() && Auth::user()->user_role == 'CSWD')
                CSWD Panel
            @elseif(Auth::check() && Auth::user()->user_role == 'Developer')
                Developer Panel
            @else
                Cabuyao Resident
            @endif
        </div>
    </div>
</div>
