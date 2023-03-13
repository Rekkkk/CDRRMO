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
    <link rel="stylesheet" href="{{ URL('assets/css/theme.css') }}">
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