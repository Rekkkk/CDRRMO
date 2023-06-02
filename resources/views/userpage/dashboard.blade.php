<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="shortcut icon" href="{{ asset('assets/img/CDRRMO-LOGO.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    <title>{{ config('app.name') }}</title>
</head>

<body class="bg-slate-300">
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

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
                {{-- <div class="bg-slate-50 p-2.5 drop-shadow-lg border-t-4 border-red-800 rounded">
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
                </div> --}}
                <div class="widget bg-green-400 drop-shadow-lg max-w-full">
                    <div class="widget-logo flex justify-center items-center">
                        <img class="pt-52" src="{{ asset('assets/img/CDRRMO-LOGO.png') }}">
                    </div>
                    <div class="content-logo flex justify-between my-3 p-1">
                        <div class="content-description px-2">
                            <h5 class="font-bold text-slate-800">Evacuation Center (Active)</h5>
                            <span class="text-4xl font-bold">2,021</span>
                        </div>
                        <div class="content-header rounded">
                            <img src="{{ asset('assets/img/evacuation.png') }}" style="width:50px;">
                        </div>
                    </div>
                    {{-- <a href=""
                        class="edit-btn p-2 flex justify-center gap-2 text-center bg-slate-700 hover:bg-slate-900 text-white">
                        <i class="bi bi-pencil-fill"></i>
                        <span>Edit</span>
                    </a> --}}
                </div>
                <div class="widget bg-red-500 drop-shadow-lg max-w-full">
                    <div class="widget-logo flex justify-center items-center">
                        <img class="pt-52" src="{{ asset('assets/img/CDRRMO-LOGO.png') }}">
                    </div>
                    <div class="content-logo flex justify-between my-3 p-1">
                        <div class="content-description px-2">
                            <h5 class="font-bold">Evacuation Center (Inactive)</h5>
                            <span class="text-4xl font-bold">2,021</span>
                        </div>
                        <div class="content-header rounded">
                            <img src="{{ asset('assets/img/evacuation.png') }}" style="width:50px;">
                        </div>
                    </div>
                    {{-- <a href=""
                        class="edit-btn p-2 flex justify-center gap-2 text-center bg-slate-700 hover:bg-slate-900 text-white">
                        <i class="bi bi-pencil-fill"></i>
                        <span>Edit</span>
                    </a> --}}
                </div>
                {{-- <div class="bg-slate-50 p-2.5 drop-shadow-lg border-t-4 border-red-800">
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
                <div class="bg-slate-50 p-2.5 drop-shadow-lg border-t-4 border-red-800">
                    <div class="content-logo">
                        <div class="content-header float-left bg-yellow-500 rounded">
                            <img class="m-2" src="{{ asset('assets/img/baranggay.png') }}" style="width:50px;"
                                alt="logo">
                        </div>
                        <div class="content-description float-left py-3 px-2">
                            <h5 class="tracking-wider font-bold">BARANGAY</h5>
                            <span>123</span>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 p-2.5 drop-shadow-lg border-t-4 border-red-800">
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
                <div class="bg-slate-50 p-2.5 drop-shadow-lg border-t-4 border-red-800">
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
                </div> --}}
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>

</body>

</html>
