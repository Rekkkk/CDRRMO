<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="{{ URL('assets/img/CDRRMO-LOGO.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ URL('assets/css/about.css') }}">
    <title>{{ config('app.name')}}</title>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-400">
    <div class="wrapper">
        <header class="header-section w-full bg-slate-50">
            <div class="container-fluid relative w-full h-full">
                <div class="w-full h-full relative">
                    <img class="w-24 float-right h-full" src="{{ URL('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                    <span class="float-right h-full text-lg font-semibold">Cabuyao City Disaster Risk<br>Reduction and Management Office</span>
                </div>
            </div>
        </header>

        <div class="page-wrap">
            <div class="sidebar drop-shadow-2xl fixed left-0 top-0 h-full w-20">
                <div class="sidebar-heading flex justify-center items-center cursor-pointer text-white ">
                    <span class="links_name">E-LIGTAS</span>
                    <i class="bi bi-list absolute text-white text-center cursor-pointer text-3xl" id="btn-sidebar"></i>
                </div>
                <div class="h-full items-center text-center">
                    <x-nav-item />
                </div>
            </div>
        </div>

        <x-messages />

        <div class="main-content">
            <div class="content-item m-4">
                <div class="content-header w-full h-full p-3">
                    <div class="text-center">
                        <img id="header-logo-right" src="{{ url('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                        <span class="relative w-full text-2xl text-white">{{ config('app.name')}}</span>
                        <img id="header-logo-left" src="{{ url('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                    </div>
                </div>
                <div class="content-details w-full p-2">
                    <img src="{{ url('assets/img/Sample-Picture1.jpg') }}" alt="picture">
                    <div class="content-body">
                        <h1 class="text-center">Background Information</h1>
                        <hr>
                        <div class="container text-center">
                            <div class="row">
                                <div class="col">
                                    <span>Facebook: </span>
                                    <p>
                                        <a href="https://www.facebook.com/CabuyaoCDRRMO">{{ config('app.name')}}</a>
                                    </p>
                                </div>
                                <div class="col">
                                    <span>Email: </span>
                                    <p>cdrrmo.cabuyao@gmail.com</p>
                                </div>
                                <div class="col">
                                    <span>Address: </span>
                                    <p>3/F Cabuyao Retail Plaza</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>

@include('partials.footer')