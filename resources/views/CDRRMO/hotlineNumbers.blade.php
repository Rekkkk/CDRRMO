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
                <div class="location-section bg-slate-600 p-6 text-white rounded">
                    <div class="text-center">
                        <span class="text-2xl font-bold">Hotline Numbers</span>
                    </div>
                    <div class="mt-8">
                        <span class="font-bold">
                            <i class="bi bi-phone-vibrate-fill mr-4 text-lg"></i>
                            Hotline Numbers: 
                        </span>
                        <hr>
                        <p class="my-3">+12 3341 562 341</p>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('assets/js/landingPage.js') }}"></script>
        @include('partials.content.footerPackage')
    </body>
</html>