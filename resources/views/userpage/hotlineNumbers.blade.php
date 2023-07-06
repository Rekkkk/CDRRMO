<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.headPackage')
</head>

<body>
    <div class="wrapper">
        @include('partials.header')
        @include('partials.sidebar')
        <div class="main-content">
            <div class="grid grid-cols-1">
                <div class="grid col-end-1 mr-4">
                    <div class="text-2xl text-white">
                        <i class="bi bi-telephone p-2 bg-slate-600 rounded"></i>
                    </div>
                </div>
                <span class="text-xl font-bold tracking-wider">HOTLINE NUMBERS</span>
            </div>
            <hr class="mt-4">
            <div class="hotline-content flex mt-4">
                <div class="number-section">
                    <div class="mt-8">
                        <div class="font-bold">
                            <i class="bi bi-hospital mr-4 text-lg"></i>
                            Hotline Numbers:
                            @if (auth()->check() && auth()->user()->organization == 'CDRRMO')
                                <a class="bi bi-pencil btn-edit"></a>
                            @endif
                        </div>
                        <hr class="mt-3 clear-both">
                        <p class="my-3">+12 3341 562 341</p>
                    </div>
                    <div class="mt-8">
                        <span class="font-bold">
                            <i class="bi bi-fire mr-4 text-lg"></i>
                            Hotline Numbers:
                            @if (auth()->check() && auth()->user()->organization == 'CDRRMO')
                                <a class="bi bi-pencil btn-edit"></a>
                            @endif
                        </span>
                        <hr class="mt-3 clear-both">
                        <p class="my-3">+12 3341 562 341</p>
                    </div>
                    <div class="mt-8">
                        <span class="font-bold">
                            <i class="bi bi-droplet mr-4 text-lg"></i>
                            Hotline Numbers:
                            @if (auth()->check() && auth()->user()->organization == 'CDRRMO')
                                <a class="bi bi-pencil btn-edit"></a>
                            @endif
                        </span>
                        <hr class="mt-3 clear-both">
                        <p class="my-3">+12 3341 562 341</p>
                    </div>
                    <div class="mt-8">
                        <span class="font-bold">
                            <i class="bi bi-tree mr-4 text-lg"></i>
                            Hotline Numbers:
                            @if (auth()->check() && auth()->user()->organization == 'CDRRMO')
                                <a class="bi bi-pencil btn-edit"></a>
                            @endif
                        </span>
                        <hr class="mt-3 clear-both">
                        <p class="my-3">+12 3341 562 341</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    @include('partials.toastr')
</body>

</html>
