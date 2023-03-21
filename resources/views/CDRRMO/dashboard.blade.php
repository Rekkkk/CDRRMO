<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <link rel="shortcut icon" href="{{ asset('assets/img/CDRRMO-LOGO.png') }}" type="image/png">
        <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
        <title>{{ config('app.name') }}</title>
        <script src="//unpkg.com/alpinejs" defer></script>
    </head>
    <body class="bg-gray-400">
        <div class="wrapper">
            <header class="header-section w-full bg-slate-50">
                <div class="container-fluid relative w-full h-full">
                    <div class="w-full h-full relative">
                        <img class="w-24 float-right h-full" src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                        <span class="float-right h-full text-xl">Cabuyao City Disaster Risk<br>Reduction and Management Office</span>
                    </div>
                </div>
            </header>
            <div class="page-wrap">
                <div class="sidebar drop-shadow-2xl fixed left-0 top-0 h-full w-20">
                    <div class="sidebar-heading flex justify-center items-center cursor-pointer text-white ">
                        <span class="links_name">E-LIGTAS</span>
                        <i class="bi bi-list absolute text-white text-center cursor-pointer text-3xl" id="btn-sidebar"></i>
                    </div>
                    <div class="h-full items-center text-center">
                        <x-nav-item />
                    </div>
                </div>
            </div>

            <x-messages />

            <div class="main-content">
                @foreach ($announcements as $announcement)
                <div class="content-item rounded-t-lg w-full">
                    <div class="content-header text-center text-white rounded-t-lg">
                        <div class="text-2xl p-2 w-full h-full">
                            @include('partials.dashboard.postBtn')
                            <span class="text-xl">{{ $announcement->announcement_description }}</span><br>
                            <span class="text-sm">{{ $announcement->created_at }}</span>
                        </div>
                    </div>
                    <div class="pt-2 bg-white rounded-b-lg p-3">
                        {{-- <img class="w-full rounded" src="{{ $announcement->announcement_image }}" width="60" height="60"> --}}
                        <p>{{ $announcement->announcement_content }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @include('partials.dashboard.createPost')
        </div>
        <script src="{{ asset('assets/js/landingPage.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>