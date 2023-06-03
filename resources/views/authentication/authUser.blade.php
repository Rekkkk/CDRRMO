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
    </script>
    <link rel="shortcut icon" href="{{ asset('assets/img/CDRRMO-LOGO.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    <title>{{ config('app.name') }}</title>
</head>

<body class="bg-slate-900">
    <header class="h-20 w-full">
        <div class="relative bg-red-900 h-full">
            <img class="w-22 m-auto h-full" src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
        </div>
    </header>
    <div class="login-container pb-28 pt-16">
        <div class="login-section relative py-4 m-auto w-3/5">
            <div class="login-content flex justify-around">
                <div class="header-desc w-1/2">
                    <h1 class="text-white py-2 text-4xl font-semibold">{{ config('app.name') }}</h1>
                    <div class="pt-4">
                        <span class="text-slate-400 text-lg">E-LIGTAS help you to locate evacuation center and to share
                            knowledge on disaster
                            preparedness.</span>
                    </div>
                </div>
                <div class="login-form-section w-96 h-3/4 bg-slate-100 drop-shadow-2xl rounded">
                    <form action="{{ route('login') }}" method="POST" class="px-3">
                        @csrf
                        <div class="my-3">
                            <input type="email" name="email" class="form-control p-3"
                                value="{{ !empty(old('email')) ? old('email') : null }}" placeholder="Email address"
                                required>
                        </div>
                        <div class="my-3 relative">
                            <input type="password" name="password" id="password" class="form-control p-3"
                                autocomplete="off" placeholder="Password" style="padding-right: 3rem;">
                            <i class="bi bi-eye-slash absolute top-0 right-0 cursor-pointer text-2xl" id="show-password"
                                style="margin: 0.8rem;"></i>
                        </div>
                        <div class="login-btn">
                            <button type="submit"
                                class="font-bold text-lg w-full bg-slate-800 text-white p-3 rounded shadow-lg hover:bg-slate-900">Log
                                in</button>
                        </div>
                    </form>
                    <form action="{{ route('guideline.resident') }}" method="POST" class="cursor-pointer py-2 px-3">
                        @method('GET')
                        @csrf
                        <button type="submit"
                            class="font-bold text-lg w-full bg-red-800 text-white p-3 rounded shadow-lg hover:bg-red-900">
                            Continue as resident
                        </button>
                    </form>
                    <div class="forgot-password flex justify-center text-center mt-6 text-sky-600">
                        <a href="">Forgotten password?</a>
                    </div>
                    <hr class="my-10 mx-4">
                </div>
            </div>
        </div>
    </div>

    <div class="login-footer-container text-white">
        <div class="pt-5">
            <div class="px-8 m-auto">
                <hr>
                <span id="year" class="text-slate-400 text-sm"></span>
            </div>
        </div>
    </div>

    <x-errorMessage />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>

    <script>
        document.getElementById("year").innerHTML = "CDRRMO @ " + new Date().getFullYear();

        let eyeicon = document.getElementById("show-password"),
            password = document.getElementById("password");
        eyeicon.onclick = function() {
            if (password.type == "password") {
                this.classList.toggle("bi-eye");
                password.type = "text";
            } else {
                this.classList.toggle("bi-eye");
                password.type = "password";
            }
        }
    </script>

</body>

</html>
