<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.headPackage')
</head>

<body id="login-container">
    <div class="wrapper">
        <div class="header-section w-full drop-shadow-lg"></div>
        <div class="login-section relative m-auto">
            <div class="login-content flex justify-around">
                <div class="header-desc py-5">
                    <h1 class="text-white tracking-wide font-extrabold">{{ config('app.name') }}</h1>
                    <div class="pt-4">
                        <p class="text-slate-400">E-LIGTAS can help you locate an evacuation center in Cabuyao, Laguna,
                            and learn about disaster preparedness.</p>
                    </div>
                </div>
                <div class="login-form-section bg-slate-300 mr-2    ">
                    <form action="{{ route('login') }}" method="POST" class="px-3">
                        @csrf
                        <div class="my-3">
                            <input type="email" name="email" class="form-control"
                                value="{{ !empty(old('email')) ? old('email') : null }}" placeholder="Email Address"
                                required>
                        </div>
                        <div class="my-3 relative">
                            <input type="password" name="password" id="authPassword" class="form-control p-3"
                                autocomplete="off" placeholder="Password">
                            <i class="bi bi-eye-slash absolute cursor-pointer text-2xl " id="showAuthPassword"></i>
                        </div>
                        <div class="login-btn">
                            <button type="submit" class="btn-login bg-slate-700 hover:bg-slate-800">Login</button>
                        </div>
                    </form>
                    <form action="{{ route('resident.guideline') }}" method="POST" class="py-2 px-3">
                        @method('GET')
                        @csrf
                        <button type="submit" class="btn-resident bg-red-600 hover:bg-red-700">
                            Continue as resident
                        </button>
                    </form>
                    <div class="flex justify-center text-center my-10 text-sky-600">
                        <a href="{{ route('recoverAccount') }}">Forgotten password?</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-section w-full text-white">
            <hr>
            <p class="text-slate-400">E-LIGTAS @ {{ date('Y') }}</p>
        </div>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    @include('partials.toastr')
</body>

</html>
