@include('partials.authHeader')

<body class="bg-slate-700">
    <div class="wrapper">
        <div class="header-section w-full drop-shadow-lg"></div>
        <div class="res-password-cotainer relative m-auto">
            <div class="res-password-content flex justify-center">
                <div class="res-password-form bg-slate-300">
                    <form action="{{ route('resetPassword') }}" method="POST" class="relative w-full">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="p-3 rounded-t">
                            <h1 class="text-xl font-bold text-center">Reset Password Form</h1>
                        </div>
                        <hr>
                        <div class="res-input-form">
                            <label>Email Address</label>
                            <input type="email" name="email" id="email" class="form-control p-2.5"
                                value="{{ !empty(old('email')) ? old('email') : null }}" placeholder="Email Address"
                                required autofocus>
                        </div>
                        <div class="res-input-form">
                            <label>Password</label>
                            <input type="password" name="password" id="password" class="form-control p-2.5"
                                placeholder="Enter Password" autocomplete="off" required autofocus>
                        </div>
                        <div class="res-input-form mb-4">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control p-2.5" placeholder="Enter Confirm Password" autocomplete="off"
                                onpaste="return false;" required autofocus>
                        </div>
                        <hr>
                        <div class="flex justify-end items-center py-3 px-4">
                            <button type="submit" class="btn-submit bg-green-600">Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="bottom-section w-full text-white">
            <hr>
            <p class="text-slate-400">E-LIGTAS @ {{ date('Y') }}</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    @include('partials.toastr')
</body>

</html>
