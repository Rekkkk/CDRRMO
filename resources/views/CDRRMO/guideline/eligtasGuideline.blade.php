<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.content.headPackage')
        <link rel="stylesheet" href="{{ asset('assets/css/guideline-css/guideline.css') }}">
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
                    <span class="text-2xl font-bold tracking-wider mx-2">Guideline</span>
                    <hr class="mt-4">
                </div>

                @auth
                <div class="guidelines-btn w-full py-2 flex justify-end">
                    <a href="#add" data-bs-toggle="modal">
                        <button type="submit" class="bg-slate-700 mx-2 p-2 py-2 text-white rounded shadow-lg hover:bg-slate-900 transition duration-200">
                            <i class="bi bi-file-earmark-plus-fill mr-2"></i></i> Add Guideline
                        </button>
                    </a>
                    @include('CDRRMO.guideline.addGuideline')
                </div>
                @endauth

                <div class="content-item text-center mt-4">
                    <div class="row gap-4 justify-center items-center">
                        @forelse ($guideline as $guidelineItem)
                        <div class="col-lg-2 mb-4 relative">
                        @auth
                            <a href="{{ route('Cremoveguideline', $guidelineItem->guideline_id) }}" class="absolute right-0 ">
                                <i class="bi bi-x-lg cursor-pointer p-2.5 bg-red-700 text-white rounded-full shadow-lg hover:bg-red-900 transition duration-200"></i>
                            </a>
                            <a href="#edit{{ $guidelineItem->guideline_id }}" data-bs-toggle="modal" class="absolute left-4 top-3">
                                <i class="bi bi-pencil cursor-pointer p-2 bg-slate-600 text-white rounded shadow-lg hover:bg-slate-900 transition duration-200"></i>
                            </a>
                        @include('CDRRMO.guideline.updateGuideline')
                            
                            <a class="guidelines-item" href="{{ route('Cguide', $guidelineItem->guideline_id) }}">
                                <div class="widget relative w-full h-full">
                                    <img src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                                    <p>{{ $guidelineItem->guideline_description }}</p>
                                </div>
                            </a>
                        
                        @endauth
                        @guest
                            <a class="guidelines-item" href="{{ route('Gguide', $guidelineItem->guideline_id) }}">
                                <div class="widget relative w-full h-full">
                                    <img src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                                    <p>{{ $guidelineItem->guideline_description }}</p>
                                </div>
                            </a>
                        @endguest
                        @empty
                            <div class="empty-record bg-slate-900 p-5 rounded text-white">
                                <div class="image-container flex justify-center items-center">
                                    <img src="{{ asset('assets/img/emptyRecord.svg') }}" alt="image" style="width:300px;">
                                </div>
                                <h1 class="fs-2 text-red-700 font-bold mt-10">{{ config('app.name') }}</h1>
                                <span class="font-semibold">No Record Found!</span>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/js/landingPage.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    
    </body>
</html>