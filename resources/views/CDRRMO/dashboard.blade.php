<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.content.headPackage')
        <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
        <title>{{ config('app.name') }}</title>
    </head>
    <body class="bg-gray-400">
        @include('sweetalert::alert')
        <div class="wrapper">
            @include('partials.content.header')
            @include('partials.content.sidebar')
            
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
        @include('partials.content.footerPackage')
    </body>
</html>