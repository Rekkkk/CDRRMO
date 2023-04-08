<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.content.headPackage')
        <link rel="stylesheet" href="{{ asset('assets/css/guidelines.css') }}">
        <title>{{ config('app.name') }}</title>
    </head>
    <body class="bg-gray-400">
        <div class="wrapper">
            @include('sweetalert::alert')
            @include('partials.content.header')
            @include('partials.content.sidebar')

            <x-messages />

            <h1 class="text-center bg-slate-700 w-full mt-2 text-white mb-2 text-4xl p-3 font-bold">"E-LIGTAS Guidelines"</h1>
            
            @auth
            <div class="guidelines-btn w-full py-2 flex justify-end">
                <button type="submit" class="bg-slate-700 mx-2 p-2 py-2 text-white rounded shadow-lg hover:bg-slate-900 transition duration-200" >
                    <i class="bi bi-pencil mr-2"></i> Edit Quiz
                </button>
                <a href="#add" data-bs-toggle="modal">
                    <button type="submit" class="bg-red-700 mx-2 p-2 py-2 text-white rounded shadow-lg hover:bg-red-900 transition duration-200" >
                        <i class="bi bi-bag-plus-fill mr-2"></i> Add Guidelines
                    </button>
                </a>
                @include('CDRRMO.guidelines.addGuide')
            </div>
            @endauth
           
            <div class="main-content">
                @foreach ($guide as $guideItem)
                <div class="guideline-container w-full">
                    <div class="guideline-content">
                        <div class="label">
                            {{ $guideItem->guide_description }}
                        </div>
                        <div class="content">
                            <p class="mb-2">
                                {{ $guideItem->guide_content }}
                            </p>
                            @auth
                            <div class="action-btn w-full py-2 flex justify-start">
                                <a href="#edit{{ $guideItem->guide_id }}" data-bs-toggle="modal">
                                    <button type="submit" class="bg-slate-700 p-2 py-2 text-white rounded shadow-lg hover:bg-slate-900 transition duration-200" >
                                        <i class="bi bi-pencil text-sm mr-2"></i>Edit
                                    </button>
                                </a>
                                <a href="{{ route('Cremoveguide', $guideItem->guide_id) }}">
                                    <button type="submit" class="bg-red-700 ml-2 p-2 py-2 text-white rounded shadow-lg hover:bg-red-900 transition duration-200" >
                                        <i class="bi bi-trash mr-2"></i>Delete
                                    </button>
                                </a>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>
                {{-- @include('CDRRMO.guidelines.updateGuidelines') --}}
                @endforeach
            </div>
        </div>
        <script>
            const accordion = document.getElementsByClassName('guideline-content');

            for(i = 0; i < accordion.length; i++){
                accordion[i].addEventListener('click', function(){
                    this.classList.toggle('active')
                })
            }
        </script>

        <script src="{{ asset('assets/js/landingPage.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        
    </body>
</html>