<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.headPackage')
</head>

<body>
    <div class="wrapper">
        <div class="header-section w-full drop-shadow-lg"></div>
        <div class="res-password-cotainer bg-slate-50 rounded drop-shadow-lg">
            <form action="{{ route('resetPassword') }}" method="POST" class="relative w-full">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="p-3 rounded-t">
                    <h1 class="text-xl font-bold text-center text-white">Reset Password Form</h1>
                </div>
                <hr>
                <div class="pt-4 px-4">
                    <label for="email" class="pb-2">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control p-2.5"
                        placeholder="Email Address" required autofocus>
                </div>
                <div class="pt-2 px-4">
                    <label for="password" class="pb-2">Password</label>
                    <input type="password" name="password" id="password" class="form-control p-2.5"
                        placeholder="Enter Password" autocomplete="off" required autofocus>
                </div>
                <div class="py-2 px-4">
                    <label for="password_confirmation" class="pb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="form-control p-2.5" placeholder="Enter Confirm Password" autocomplete="off" required
                        autofocus>
                </div>
                <hr>
                <div class="flex justify-end items-center p-3 drop-shadow-lg">
                    <button type="submit" class="btn-submit bg-green-600 p-2 font-bold tracking-wide">Reset
                        Password</button>
                </div>
            </form>
        </div>
        <div class="bottom-section pb-5 l-0 w-full text-slate-900">
            <hr>
            <p>E-LIGTAS @ {{ date('Y') }}</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    @include('partials.toastr')
</body>

</html>
