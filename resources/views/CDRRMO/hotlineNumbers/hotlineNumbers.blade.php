<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.content.headPackage')
        <link rel="stylesheet" href="{{ asset('assets/css/hotlineNumber/hotline.css') }}">
        <title>{{ config('app.name') }}</title>
    </head>
    <body class="bg-gray-400">
        <div class="wrapper">

            @include('partials.content.header')
            @include('partials.content.sidebar')

            <x-messages />

            <div class="content">

                <div class="dashboard-logo pb-4">
                    <i class="bi bi-telephone text-2xl px-2 bg-slate-900 text-white rounded py-2"></i>
                    <span class="text-2xl font-bold tracking-wider mx-2">HOTLINE NUMBERS</span>
                    <hr class="mt-4">
                </div>

                <div class="main-content">
                    <div class="location-section f bg-slate-600 p-6 text-white">
                        <div class="text-center">
                            <span class="text-2xl font-bold">Hotline Numbers</span>
                        </div>
                        <div class="mt-8">
                            <span class="font-bold">
                                <i class="bi bi-hospital mr-4 text-lg"></i>
                                Hotline Numbers:
                                @auth
                                    <i class="bi bi-pencil float-right cursor-pointer px-2 py-1 bg-red-700 text-white rounded shadow-lg hover:bg-red-900 transition duration-200"></i>
                                @endauth
                            </span>
                            <hr class="mt-3 clear-both">
                            <p class="my-3">+12 3341 562 341</p>
                        </div>
                        <div class="mt-8">
                            <span class="font-bold">
                                <i class="bi bi-fire mr-4 text-lg"></i>
                                Hotline Numbers: 
                                @auth
                                    <i class="bi bi-pencil float-right cursor-pointer px-2 py-1 bg-red-600 text-white rounded shadow-lg hover:bg-red-900 transition duration-200"></i>
                                @endauth
                            </span>
                            <hr class="mt-3 clear-both">
                            <p class="my-3">+12 3341 562 341</p>
                        </div>
                        <div class="mt-8">
                            <span class="font-bold">
                                <i class="bi bi-droplet mr-4 text-lg"></i>
                                Hotline Numbers: 
                                @auth
                                    <i class="bi bi-pencil float-right cursor-pointer px-2 py-1 bg-red-600 text-white rounded shadow-lg hover:bg-red-900 transition duration-200"></i>
                                @endauth
                            </span>
                            <hr class="mt-3 clear-both">
                            <p class="my-3">+12 3341 562 341</p>
                        </div>
                        <div class="mt-8">
                            <span class="font-bold">
                                <i class="bi bi-tree mr-4 text-lg"></i>
                                Hotline Numbers: 
                                @auth
                                    <i class="bi bi-pencil float-right cursor-pointer px-2 py-1 bg-red-600 text-white rounded shadow-lg hover:bg-red-900 transition duration-200"></i>
                                @endauth
                            </span>
                            <hr class="mt-3 clear-both">
                            <p class="my-3">+12 3341 562 341</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="{{ asset('assets/js/landingPage.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    
    </body>
</html>