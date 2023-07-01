<div class="sidebar fixed bg-slate-700 w-20 drop-shadow-lg">
    <div class="sidebar-header h-16 text-white cursor-pointer pt-3">
        <img class="links_name text-2xl pl-4 w-36" src="{{ asset('assets/img/e-ligtas-logo.png') }}" alt="Logo">
        <button type="button" class="bi bi-x text-3xl" id="btn-sidebar-close"></button>
    </div>
    <div class="sidebar-content">
        <div class="user-details py-2 bg-slate-800">
            <div class="truncate flex justify-center items-center text-white tracking-wide font-bold gap-4">
                @if (auth()->check() && auth()->user()->organization == 'CDRRMO')
                    @if (auth()->check() && auth()->user()->status == 'Restricted')
                        <div title="Restricted" class="bg-red-600 py-2 rounded-full w-4"></div>
                    @else
                        <div title="Active" class="bg-green-600 py-2 rounded-full w-4"></div>
                    @endif
                    <img class="w-12" src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="Logo">
                    <span>CDRRMO Panel</span>
                @elseif(auth()->check() && auth()->user()->organization == 'CSWD')
                    @if (auth()->check() && auth()->user()->status == 'Restricted')
                        <div title="Restricted" class="bg-red-600 py-2 rounded-full w-4"></div>
                    @else
                        <div title="Active" class="bg-green-600 py-2 rounded-full w-4"></div>
                    @endif
                    <span>CSWD Panel</span>
                @else
                    <div title="Resident" class="bg-yellow-500 py-2 rounded-full w-4"></div>
                    <span class="py-2">Cabuyao Resident</span>
                @endif
            </div>
        </div>
        <div class="items-center text-center">
            <x-nav-item />
        </div>

    </div>
</div>
