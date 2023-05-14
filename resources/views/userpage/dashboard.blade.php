<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="shortcut icon" href="{{ asset('assets/img/CDRRMO-LOGO.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">

    <title>{{ config('app.name') }}</title>
</head>

<body class="bg-gray-400">
    <div class="wrapper">
        @include('partials.content.header')
        @include('partials.content.sidebar')

        <x-messages />

        <div class="main-content pt-8 pr-8 pl-28">

            <div class="dashboard-logo pb-4">
                <i class="bi bi-speedometer2 text-2xl px-2 bg-slate-900 text-white rounded py-2"></i>
                <span class="text-2xl font-bold tracking-wider mx-2">DASHBOARD</span>
                <hr class="mt-4">
            </div>

            <div class="grid grid-rows-3 grid-flow-col gap-4">
                <div class="bg-slate-50 p-2.5 drop-shadow-lg border-t-4 border-red-800 rounded">
                    <div class="content-logo">
                        <div class="content-header float-left bg-sky-500 rounded">
                            <img class="m-2" src="{{ asset('assets/img/male_person.png') }}" style="width:50px;"
                                alt="logo">
                        </div>
                        <div class="content-description float-left py-3 px-2">
                            <h5 class="tracking-wider font-bold">MALE</h5>
                            <span>2,021</span>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 p-2.5 drop-shadow-lg border-t-4 border-red-800 rounded">
                    <div class="content-logo">
                        <div class="content-header float-left bg-pink-500 rounded">
                            <img class="m-2" src="{{ asset('assets/img/female_person.png') }}" style="width:50px;"
                                alt="logo">
                        </div>
                        <div class="content-description float-left py-3 px-2">
                            <h5 class="tracking-wider font-bold">FEMALE</h5>
                            <span>1,502</span>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 p-2.5 drop-shadow-lg border-t-4 border-red-800 rounded">
                    <div class="content-logo">
                        <div class="content-header float-left bg-yellow-500 rounded">
                            <img class="m-2" src="{{ asset('assets/img/baranggay.png') }}" style="width:50px;"
                                alt="logo">
                        </div>
                        <div class="content-description float-left py-3 px-2">
                            <h5 class="tracking-wider font-bold">BARANGGAY</h5>
                            <span>123</span>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 p-2.5 drop-shadow-lg border-t-4 border-red-800 rounded">
                    <div class="content-logo">
                        <div class="content-header float-left bg-sky-500 rounded">
                            <img class="m-2" src="{{ asset('assets/img/evacuation.png') }}" style="width:50px;"
                                alt="logo">
                        </div>
                        <div class="content-description float-left py-3 px-2">
                            <h5 class="tracking-wider font-bold">EVACUATION CENTERS</h5>
                            <span>50</span>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 p-2.5 drop-shadow-lg border-t-4 border-red-800 rounded">
                    <div class="content-logo">
                        <div class="content-header float-left bg-sky-500 rounded">
                            <img class="m-2" src="{{ asset('assets/img/family.png') }}" style="width:50px;"
                                alt="logo">
                        </div>
                        <div class="content-description float-left py-3 px-2">
                            <h5 class="tracking-wider font-bold">FAMILIES</h5>
                            <span>123</span>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 p-2.5 drop-shadow-lg border-t-4 border-red-800 rounded">
                    <div class="content-logo">
                        <div class="content-header float-left bg-sky-500 rounded">
                            <img class="m-2" src="{{ asset('assets/img/fire_trucks.png') }}" style="width:50px;"
                                alt="logo">
                        </div>
                        <div class="content-description float-left py-3 px-2">
                            <h5 class="tracking-wider font-bold">FIRE TRUCKS</h5>
                            <span>5</span>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 p-2.5 drop-shadow-lg border-t-4 border-red-800 rounded">
                    <div class="content-logo">
                        <div class="content-header float-left bg-sky-500 rounded">
                            <img class="m-2" src="{{ asset('assets/img/ambulance.png') }}" style="width:50px;"
                                alt="logo">
                        </div>
                        <div class="content-description float-left py-3 px-2">
                            <h5 class="tracking-wider font-bold">AMBULANCE</h5>
                            <span>5</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>

</body>

</html>