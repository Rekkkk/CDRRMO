<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.content.headPackage')
        <link rel="stylesheet" href="{{ asset('assets/css/guidelines-css/guidelines.css') }}">
        <title>{{ config('app.name') }}</title>
    </head>
    <body class="bg-gray-400">
        <div class="wrapper">
            @include('sweetalert::alert')
            @include('partials.content.header')
            @include('partials.content.sidebar')

            <x-messages />

            <div class="main-content">
                <div class="dashboard-logo pb-4">
                    <i class="bi bi-book text-2xl px-2 bg-slate-900 text-white rounded py-2"></i>
                    <span class="text-2xl font-bold tracking-wider mx-2">Guidelines</span>
                    <hr class="mt-4">
                </div>

                @auth
                <div class="guidelines-btn w-full py-2 flex justify-end">
                    <a href="#add" data-bs-toggle="modal">
                        <button type="submit" class="bg-slate-700 mx-2 p-2 py-2 text-white rounded shadow-lg hover:bg-slate-900 transition duration-200">
                            <i class="bi bi-file-earmark-plus-fill mr-2"></i></i> Add Guidelines
                        </button>
                    </a>
                    @include('CDRRMO.guidelines.addGuidelines')
                </div>
                @endauth

                <div class="content-item text-center mt-4">
                    <div class="row gap-4 justify-center items-center">
                        @foreach ($guidelines as $guidelinesItem)
                        <div class="col-lg-2 mb-4">
                            <a class="guidelines-item" href="{{ route('Cguide') }}">
                                <div class="widget relative w-full h-full">
                                    <img src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                                    <p>{{ $guidelinesItem->guidelines_description }}</p>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/js/landingPage.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    
    </body>
</html>