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
                        <p class="text-slate-400">E-LIGTAS help you to locate evacuation center and to share
                            knowledge about disaster preparedness.</p>
                    </div>
                </div>
                <div class="login-form-section h-3/4 bg-slate-300 drop-shadow-2xl rounded">
                    <form action="{{ route('login') }}" method="POST" class="px-3">
                        @csrf
                        <div class="my-3">
                            <input type="email" name="email" class="form-control"
                                value="{{ !empty(old('email')) ? old('email') : null }}" placeholder="Email Address"
                                required>
                        </div>
                        <div class="my-3 relative">
                            <input type="password" name="password" id="password" class="form-control p-3"
                                autocomplete="off" placeholder="Password">
                            <i class="bi bi-eye-slash absolute cursor-pointer text-2xl " id="show-password"></i>
                        </div>
                        <div class="login-btn">
                            <button type="submit"
                                class="btn-login rounded text-white bg-slate-700 w-full font-extrabold hover:bg-slate-800">Login</button>
                        </div>
                    </form>
                    <form action="{{ route('resident.guideline') }}" method="POST" class="py-2 px-3">
                        @method('GET')
                        @csrf
                        <button type="submit"
                            class="btn-resident rounded text-white bg-red-600 w-full font-extrabold hover:bg-red-700">
                            Continue as resident
                        </button>
                    </form>
                    <div class="flex justify-center text-center mt-6 text-sky-600">
                        <a href="{{ route('recoverAccount') }}">Forgotten password?</a>
                    </div>
                    <hr class="my-10 mx-4">
                </div>
            </div>
        </div>
        <div class="bottom-section pb-5 l-0 w-full text-white">
            <hr>
            <p id="year" class="text-slate-400"></p>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    @include('partials.toastr')
    <script>
        document.getElementById("year").innerHTML = "E-LIGTAS @ " + new Date().getFullYear();

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
