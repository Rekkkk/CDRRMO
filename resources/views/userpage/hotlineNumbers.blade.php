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
                <div class="grid col-end-1">
                    <div class="text-2xl text-white">
                        <i class="bi bi-telephone p-2 bg-slate-600"></i>
                    </div>
                </div>
                <span class="text-xl font-bold">HOTLINE NUMBERS</span>
            </div>
            <hr class="mt-4">
            <div class="hotline-content flex mt-3">
                <div class="number-section rounded">
                    <div class="">
                        <div class="font-bold">
                            <i class="bi bi-hospital mr-4 text-lg"></i>
                            Hotline Numbers:
                        </div>
                        <hr class="mt-3 clear-both">
                        <p class="my-3">+12 3341 562 341</p>
                    </div>
                    <div class="mt-8">
                        <span class="font-bold">
                            <i class="bi bi-fire mr-4 text-lg"></i>
                            Hotline Numbers:
                        </span>
                        <hr class="mt-3 clear-both">
                        <p class="my-3">+12 3341 562 341</p>
                    </div>
                    <div class="mt-8">
                        <span class="font-bold">
                            <i class="bi bi-droplet mr-4 text-lg"></i>
                            Hotline Numbers:
                        </span>
                        <hr class="mt-3 clear-both">
                        <p class="my-3">+12 3341 562 341</p>
                    </div>
                    <div class="mt-8">
                        <span class="font-bold">
                            <i class="bi bi-tree mr-4 text-lg"></i>
                            Hotline Numbers:
                        </span>
                        <hr class="mt-3 clear-both">
                        <p class="mt-3">+12 3341 562 341</p>
                    </div>
                </div>
            </div>
        </div>
        @auth
            @include('userpage.changePasswordModal')
        @endauth
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    @auth
        <script src="{{ asset('assets/js/script.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
            integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
            crossorigin="anonymous"></script>
    @endauth
</body>

</html>
