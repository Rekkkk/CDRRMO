<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.content.headPackage')
        <link rel="stylesheet" href="{{ asset('assets/css/about.css') }}">
        <title>{{ config('app.name') }}</title>
    </head>
    <body class="bg-gray-400">
        <div class="wrapper">
            @include('partials.content.header')
            @include('partials.content.sidebar')

            <x-messages />

            <div class="main-content">
                <div class="location-section bg-slate-600 p-6 text-white">
                    <div class="text-center">
                        <span class="text-2xl font-bold">Hotline Numbers</span>
                    </div>
                    <div class="mt-8">
                        <span class="font-bold">
                            <i class="bi bi-hospital mr-4 text-lg"></i>
                            Hotline Numbers: 
                            <i class="bi bi-pencil float-right cursor-pointer px-2 py-1 bg-yellow-600 text-white rounded shadow-lg hover:bg-yellow-700 transition duration-200"></i>
                        </span>
                        <hr class="mt-3 clear-both">
                        <p class="my-3">+12 3341 562 341</p>
                    </div>
                    <div class="mt-8">
                        <span class="font-bold">
                            <i class="bi bi-fire mr-4 text-lg"></i>
                            Hotline Numbers: 
                            <i class="bi bi-pencil float-right cursor-pointer px-2 py-1 bg-yellow-600 text-white rounded shadow-lg hover:bg-yellow-700 transition duration-200"></i>
                        </span>
                        <hr class="mt-3 clear-both">
                        <p class="my-3">+12 3341 562 341</p>
                    </div>
                    <div class="mt-8">
                        <span class="font-bold">
                            <i class="bi bi-droplet mr-4 text-lg"></i>
                            Hotline Numbers: 
                            <i class="bi bi-pencil float-right cursor-pointer px-2 py-1 bg-yellow-600 text-white rounded shadow-lg hover:bg-yellow-700 transition duration-200"></i>
                        </span>
                        <hr class="mt-3 clear-both">
                        <p class="my-3">+12 3341 562 341</p>
                    </div>
                    <div class="mt-8">
                        <span class="font-bold">
                                <i class="bi bi-tree mr-4 text-lg"></i>
                                Hotline Numbers: 
                                <i class="bi bi-pencil float-right cursor-pointer px-2 py-1 bg-yellow-600 text-white rounded shadow-lg hover:bg-yellow-700 transition duration-200"></i>
                        </span>
                        <hr class="mt-3 clear-both">
                        <p class="my-3">+12 3341 562 341</p>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('assets/js/landingPage.js') }}"></script>
        @include('partials.content.footerPackage')
    </body>
</html>