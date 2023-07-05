<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.headPackage')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- @vite(['resources/js/app.js']) --}}
</head>

<body>
    <div class="wrapper">
        @include('sweetalert::alert')
        <div class="header-section w-full drop-shadow-lg"></div>
        <div class="recover-cotainer bg-slate-50 rounded drop-shadow-lg">
            <form id="recoverAccountForm" class="relative w-full">
                <input type="text" id="operation" name="operation" hidden>
                @method('GET')
                @csrf
                <div class="header-recovery p-3">
                    <h1 class="text-xl font-bold" id="formTitle">Find Your Account</h1>
                </div>
                <hr>
                <div class="p-4" id="email-container">
                    <label for="email" class="pb-4">Please enter your email address to search your
                        account.</label>
                    <input type="email" name="email" class="form-control p-2.5" placeholder="Email Address">
                </div>
                <div class="px-4" id="code-container" hidden>
                    <label for="email" class="pb-4" id="userEmail"></label>
                    <input type="text" name="code" class="form-control p-2.5" placeholder="Enter Code">
                </div>
                <span class="text-sm" id="status" hidden></span>
                <hr>
                <div class="flex justify-end items-center p-3 drop-shadow-lg">
                    <div class="">
                        <button class="btn-cancel p-2 mr-2 font-bold tracking-wide">
                            <a href="{{ route('login') }}">Cancel</a>
                        </button>
                        <button class="btn-submit p-2 font-bold tracking-wide" id="searchBtn">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="bottom-section pb-5 l-0 w-full text-white">
            <hr class="text-slate-900">
            <p id="year" class="text-slate-900"></p>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    @include('partials.toastr')
    <script>
        $(document).ready(function() {
            document.getElementById("year").innerHTML = "E-LIGTAS @ " + new Date().getFullYear();

            $('body').on('click', '#searchBtn', function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'GET',
                    url: "{{ route('findAccount') }}",
                    data: $('#recoverAccountForm').serialize(),
                    datatype: 'json',
                    success: function(response) {
                        if (response.status == 0) {
                            Swal.fire(
                                'Warning!',
                                'Invalid Email Address.',
                                'warning'
                            )
                        } else {
                            $('#operation').val('sendlink');
                            $('#email-container').hide();
                            $('#searchBtn').text('Send Password Reset Link');
                            $('#searchBtn').attr('id', 'sendResetPasswordBtn')
                            $('#userEmail').text(response.account)
                            $('#code-container').prop('hidden', false);
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'Something went wrong, Please Try Again.',
                            'error'
                        )
                    }
                });
            });

            $(document).on('click', '#sendResetPasswordBtn', function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('sendResetPasswordLink') }}",
                    data: $('#recoverAccountForm').serialize(),
                    datatype: 'json',
                    success: function(response) {
                        if (response.status == 0) {
                            Swal.fire(
                                'Error!',
                                'Failed Send Reset Password Link.',
                                'warning'
                            )
                        } else {
                            Swal.fire(
                                'Success!',
                                'Reset Password Link Sent Successfully.',
                                'success'
                            )
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'Something went wrong, Please try again.',
                            'error'
                        )
                    }
                });
            });
        });
    </script>
</body>

</html>
