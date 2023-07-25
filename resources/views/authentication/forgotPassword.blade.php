<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.headPackage')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div class="wrapper">
        @include('sweetalert::alert')
        <div class="header-section w-full drop-shadow-lg"></div>
        <div class="recover-container bg-slate-100">
            <form action="{{ route('findAccount') }}" method="POST" class="relative w-full">
                @csrf
                <div class="header-recovery p-3">
                    <h1 class="text-xl font-bold" id="formTitle">Find Your Account</h1>
                </div>
                <hr>
                <div class="p-4" id="email-container">
                    <label for="email">Please enter your email address to search your
                        account.</label>
                    <input type="email" name="email" class="form-control p-2.5" placeholder="Email Address"
                        required>
                </div>
                <hr>
                <div class="flex justify-end items-center px-4 py-3">
                    <button class="btn-remove bg-red-700 p-2 mr-2">
                        <a href="{{ route('login') }}">Cancel</a>
                    </button>
                    <button type="submit" class="btn-submit bg-green-600">Search</button>
                </div>
            </form>
        </div>
        <div class="bottom-section pb-5 l-0 w-full">
            <hr>
            <p>E-LIGTAS @ {{ date('Y') }}</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    @include('partials.toastr')
</body>

</html>
