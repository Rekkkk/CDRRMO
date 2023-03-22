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
            
            <h1 class="text-center bg-slate-700 w-full mt-2 text-white mb-2 text-4xl p-3 font-bold">Background Information</h1>

            <div class="main-content">
                <div class="location-section bg-slate-600 p-6 text-white rounded">
                    <div class="text-center">
                        <span class="text-2xl font-bold">Location</span>
                    </div>
                    <div class="mt-8">
                        <span class="font-bold">
                            <i class="bi bi-geo-alt-fill mr-4 text-lg"></i>
                            Address: 
                        </span>
                        <hr>
                        <a href="https://www.google.com/maps/place/Retail+Plaza+City+of+Cabuyao/@14.2772989,121.1214,17z/data=!3m1!4b1!4m6!3m5!1s0x3397d8604aa8f17d:0x4e0371b3a9d5540e!8m2!3d14.2772937!4d121.1235887!16s%2Fg%2F11bxg2qw2w">
                            <p class="my-3">2nd Floor, Cabuyao Retail Plaza 4025 Cabuyao, Philippines</p>
                        </a>
                    </div>
                </div>

                <div class="right-side flex-1 flex flex-col">
                    <div class="social-section bg-slate-600 mb-4 text-white rounded">
                        <div class="text-center py-4">
                            <span class="text-lg font-bold">Social</span>
                        </div>
                        <hr>
                        <a href="https://www.facebook.com/CabuyaoCDRRMO">
                            <p class="p-4">
                                <i class="bi bi-facebook mr-4"></i>CDRRMO CABUYAO
                            </p>
                        </a>
                        <hr>
                        <a href="#">
                            <p class="p-4">
                                <i class="bi bi-twitter mr-4"></i> Example 2
                            </p>
                        </a>
                        <hr>
                        <a href="#">
                            <p class="p-4">
                                <i class="bi bi-youtube mr-4"></i> Example 3
                            </p>
                        </a>
                        <hr>
                        <a href="#">
                            <p class="p-4">
                                <i class="bi bi-instagram mr-4"></i> Example 4
                            </p>
                        </a>    
                    </div>

                    <div class="telephone-section flex-1 bg-slate-600 text-white rounded">
                        <div class="text-center py-4 font-bold">
                            <span class="text-lg">Contact</span>
                        </div>
                        <hr>
                        <p class="p-4">
                            <i class="bi bi-telephone-outbound-fill mr-4 text-lg"></i> +49 5081 159
                        </p>
                        <hr>
                        <a href="https://www.facebook.com/messages/t/242799609519367">
                            <p class="p-4">
                                <i class="bi bi-messenger mr-4 text-lg"></i> CDRRMO CABUYAO
                            </p>
                        </a>
                        <p class="p-4">
                            <i class="bi bi-envelope-at mr-4 text-lg"></i> cdrrmocabuyao@gmail.com
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('assets/js/landingPage.js') }}"></script>
        @include('partials.content.footerPackage')
    </body>
</html>