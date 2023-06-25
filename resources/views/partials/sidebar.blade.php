<div class="sidebar fixed bg-slate-700 w-20 drop-shadow-lg">
    <div class="sidebar-header h-20 text-white cursor-pointer pt-3">
        <img class="links_name text-2xl pl-4 w-36" src="{{ asset('assets/img/e-ligtas-logo.png') }}" alt="Logo">
        <button type="button" class="bi bi-pin text-2xl" id="btn-sidebar"></button>
        <button type="button" class="bi bi-x text-3xl" id="btn-sidebar-close"></button>
    </div>
    <div class="sidebar-content">
        <div class="user-details py-2 bg-slate-800">
            <div class="truncate flex justify-center items-center text-white tracking-wide font-bold gap-4">
                <img class="w-12" src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="Logo">
                @if (auth()->check() && auth()->user()->user_role == 'CDRRMO')
                    <span>CDRRMO Panel</span>
                @elseif(auth()->check() && auth()->user()->user_role == 'CSWD')
                    <span>CSWD Panel</span>
                @else
                    <span>Cabuyao Resident</span>
                @endif
            </div>
        </div>
        <div class="items-center text-center">
            <x-nav-item />
        </div>
    </div>
</div>
