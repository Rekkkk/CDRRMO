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

                <div class="dashboard-logo pb-4">
                    <i class="bi bi-book text-2xl px-2 bg-slate-900 text-white rounded py-2"></i>
                    <span class="text-2xl font-bold tracking-wider mx-2">Guidelines</span>
                    <hr class="mt-4">
                </div>

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
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    
    </body>
</html>