<div class="sidebar fixed bg-slate-700 w-20 drop-shadow-lg">
    <div class="sidebar-header h-16 text-white cursor-pointer pt-3">
        <img class="links_name text-2xl pl-4 w-36" src="{{ asset('assets/img/e-ligtas-logo.png') }}" alt="Logo">
        <button type="button" class="bi bi-x text-3xl" id="btn-sidebar-close"></button>
    </div>
    <div class="sidebar-content">
        <div class="user-details py-2 bg-slate-800">
            <div class="truncate flex justify-center items-center text-white tracking-wide font-bold gap-4">
                @if (auth()->check() && auth()->user()->organization == 'CDRRMO')
                    <img class="w-12" src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="Logo">
                    <span>CDRRMO Panel</span>
                @elseif(auth()->check() && auth()->user()->organization == 'CSWD')
                    <span>CSWD Panel</span> 
                @else
                    <span class="py-2">Cabuyao Resident</span>
                @endif
            </div>
        </div>
        <div class="items-center text-center">
            <x-nav-item />
        </div>
    </div>
</div>
