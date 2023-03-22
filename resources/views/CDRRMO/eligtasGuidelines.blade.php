<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.content.headPackage')
        <link rel="stylesheet" href="{{ asset('assets/css/guidelines.css') }}">
        <title>{{ config('app.name') }}</title>
    </head>
    <body class="bg-gray-400">
        <div class="wrapper">
            @include('partials.content.header')
            @include('partials.content.sidebar')

            <x-messages />

            <div class="main-content">
                <div class="content-item text-center">
                    <div class="row gap-4 justify-center items-center">
                        @auth
                        <div class="col-lg-2 mb-4">
                            <a class="guidelines-item" href="{{ route('Cguide') }}">
                                <div class="widget relative w-full h-full">
                                    <img src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                                    <p>E-LIGTAS Typhoon Guidelines</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 mb-4">
                            <a class="guidelines-item" href="{{ route('Cguide') }}">
                                <div class="widget relative w-full h-full">
                                    <img src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                                    <p>E-LIGTAS Road Accident Guidelines</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 mb-4">
                            <a class="guidelines-item" href="{{ route('Cguide') }}">
                                <div class="widget relative w-full h-full">
                                    <img src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                                    <p>E-LIGTAS Earthquake Guidelines</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 mb-4">
                            <a class="guidelines-item" href="{{ route('Cguide') }}">
                                <div class="widget relative w-full h-full">
                                    <img src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                                    <p>E-LIGTAS Flooding Guidelines</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 mb-4">
                            <a class="guidelines-item" href="{{ route('Cguide') }}">
                                <div class="widget relative w-full h-full">
                                    <img src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                                    <p>E-LIGTAS Typhoon Guidelines</p>
                                </div>
                            </a>
                        </div>
                        @else
                        <div class="col-lg-2 mb-4">
                            <a class="guidelines-item" href="{{ route('Gguide') }}">
                                <div class="widget relative w-full h-full">
                                    <img src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                                    <p>E-LIGTAS Typhoon Guidelines</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 mb-4">
                            <a class="guidelines-item" href="{{ route('Gguide') }}">
                                <div class="widget relative w-full h-full">
                                    <img src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                                    <p>E-LIGTAS Road Accident Guidelines</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 mb-4">
                            <a class="guidelines-item" href="{{ route('Gguide') }}">
                                <div class="widget relative w-full h-full">
                                    <img src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                                    <p>E-LIGTAS Earthquake Guidelines</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 mb-4">
                            <a class="guidelines-item" href="{{ route('Gguide') }}">
                                <div class="widget relative w-full h-full">
                                    <img src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                                    <p>E-LIGTAS Flooding Guidelines</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-2 mb-4">
                            <a class="guidelines-item" href="{{ route('Gguide') }}">
                                <div class="widget relative w-full h-full">
                                    <img src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                                    <p>E-LIGTAS Typhoon Guidelines</p>
                                </div>
                            </a>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('assets/js/landingPage.js') }}"></script>
        @include('partials.content.footerPackage')
    </body>
</html>