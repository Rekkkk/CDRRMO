<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="{{ asset('assets/img/CDRRMO-LOGO.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/css/landingPage.css') }}">
    <title>{{ config('app.name') }}</title>
</head>

<body class="bg-slate-900">
    <div class="wrapper">
        <header class="header-section h-20 w-full bg-slate-50">
            <div class="container-fluid bg-red-900 relative w-full h-full">
                <div class="w-full h-full relative">
                    <img class="w-22 float-right h-full" src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                    <span class="float-right h-full text-xl text-white py-2.5">Cabuyao City Disaster Risk<br>Reduction
                        and Management Office</span>
                </div>
            </div>
        </header>
        <main class="main-content py-60 mx-3">
            <div class="content-container max-w-lg mx-auto p-6 my-10 rounded-lg shadow-2xl bg-slate-800 ">
                <header class="header-content">
                    <section class="py-4">
                        <h3 class="font-bold text-3xl text-white mb-2">Welcome to E-LIGTAS</h3>
                        <span class="text-white font-light">We care Cabuyao Resident's</span>
                    </section>
                </header>
                <div class="content-body">
                    <form action="{{ route('Gdashboard') }}" method="POST" class="cursor-pointer mb-3">
                        @method('GET')
                        @csrf
                        <button type="submit" class="btn w-full py-2 bg-red-800 text-white hover:bg-red-900">
                            <i class="bi bi-person float-left"></i>
                            Continue as Resident
                        </button>
                    </form>
                    <button type="button" class="btn w-full py-2 bg-green-800 text-white hover:bg-green-900"
                        data-bs-toggle="modal" data-bs-target="#adminMode">
                        <i class="bi bi-person-lock float-left"></i>
                        Continue to Admin Panel
                    </button>

                    <div class="modal fade" id="adminMode" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-red-900">
                                    <h1 class="modal-title fs-5 text-center text-white">{{ config('app.name') }}</h1>
                                </div>
                                <form action="{{ route('login') }}" method="POST" class="bg-slate-100 rounded-lg">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="id">Admin Number</label>
                                            <input type="text" name="id" class="form-control"
                                                autocomplete="off">
                                        </div>
                                        <div class="mb-3 relative">
                                            <label for="password">Admin Password</label>
                                            <input type="password" name="password" id="password" class="form-control"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-center">
                                        <button type="submit"
                                            class="bg-green-800 text-white p-2 py-2 rounded shadow-lg hover:bg-green-900 transition duration-200">Authenticate</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <x-errorMessage />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>

</body>

</html>
