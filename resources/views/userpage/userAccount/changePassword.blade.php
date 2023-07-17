<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.headPackage')
</head>

<body>
    <div class="wrapper">
        @include('sweetalert::alert')
        @include('partials.header')
        @include('partials.sidebar')
        <div class="main-content">
            <div class="grid grid-cols-1">
                <div class="grid col-end-1 mr-4">
                    <div class="text-white text-2xl">
                        <i class="bi bi-person-fill-lock p-2 bg-slate-600 rounded"></i>
                    </div>
                </div>
                <span class="text-xl font-bold ml-2">CHANGE PASSWORD</span>
            </div>
            <hr class="mt-4">
            <div class="form-container mt-3 flex justify-center">
                <div class="w-full sm:w-10/12 md:w-8/12 lg:w-6/12 xl:w-4/12">
                    <form id="changePasswordForm" class="bg-slate-50 rounded drop-shadow-xl">
                        @csrf
                        <div class="text-center py-3 bg-green-600 text-white rounded-t">
                            <h1 class="text-lg font-bold">Change Password</h1>
                        </div>
                        <hr>
                        <div class="form-content">
                            <div class="mb-2">
                                <label>Current Password</label>
                                <input type="text" name="current_password" class="form-control" id="current_password"
                                    autocomplete="off">
                                <span class="text-xs text-red-600 italic" id="currentPassword"></span>
                            </div>
                            <div class="mb-2 relative">
                                <label>New Password</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    autocomplete="off" disabled>
                                <i class="bi bi-eye-slash absolute cursor-pointer text-xl mt-1" id="showPassword"></i>
                            </div>
                            <div class="mb-2 relative">
                                <label>Confirm Password</label>
                                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control"
                                    autocomplete="off" onpaste="return false;" disabled>
                                <i class="bi bi-eye-slash absolute cursor-pointer text-xl mt-1"
                                    id="showConfirmPassword"></i>
                            </div>
                            <div class="mt-4 flex justify-end">
                                <button id="changePasswordBtn" class="btn-submit p-2 mb-3"
                                    disabled>Change</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
        integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
        crossorigin="anonymous"></script>
    @include('partials.toastr')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#current_password').on('input', function() {
                var current_password = $('#current_password').val();

                if (current_password === '')
                    return $('#currentPassword').html('');

                clearTimeout($(this).data('checkingDelay'));

                $(this).data('checkingDelay', setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('account.check.password') }}",
                        data: {
                            current_password: current_password
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 0) {
                                $('#currentPassword').html(
                                        '* Current Password is Incorrect.')
                                    .removeClass('text-green-600').addClass(
                                        'text-red-600');
                                $('#password ,#confirmPassword, #changePasswordBtn')
                                    .prop('disabled',
                                        true);
                            } else if (response.status == 1) {
                                $('#currentPassword').html(
                                        '* Current Password is Correct.')
                                    .removeClass('text-red-600').addClass(
                                        'text-green-600');
                                $('#password, #confirmPassword, #changePasswordBtn')
                                    .prop('disabled',
                                        false);
                            }
                        }
                    });
                }, 500));
            });

            $("#changePasswordForm").validate({
                rules: {
                    current_password: {
                        required: true
                    },
                    password: {
                        required: true
                    },
                    confirmPassword: {
                        required: true
                    }
                },
                messages: {
                    current_password: {
                        required: 'Current password is required.'
                    },
                    password: {
                        required: 'Password field is required.'
                    },
                    confirmPassword: {
                        required: 'Confirm password field is required.'
                    }
                },
                errorElement: 'span',
                submitHandler: formSubmitHandler
            });

            function formSubmitHandler(form) {
                let userId = '{{ auth()->user()->id }}';

                confirmModal('Do you want to change your password?').then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "PUT",
                            url: "{{ route('account.reset.password', ':userId') }}"
                                .replace(':userId', userId),
                            data: $(form).serialize(),
                            dataType: 'json',
                            success: function(response) {
                                if (response.status == 0) {
                                    messageModal('Warning',
                                        'Current password is incorrect.',
                                        'warning', '#FFDF00');
                                } else if (response.status == 1) {
                                    messageModal('Success',
                                        'Password successfully changed.',
                                        'success', '#3CB043');
                                    $('#changePasswordForm').trigger("reset");
                                    $('#currentPassword').html("");
                                } else {
                                    messageModal('Warning',
                                        'Password and Confirm Password is not match.',
                                        'warning', '#FFDF00');
                                    $('#confirmPassword').val('');
                                }
                            },
                            error: function() {
                                messageModal('Warning',
                                    'Something went wrong, Try again later.',
                                    'warning', '#FFDF00');
                            }
                        });
                    }
                });
            }
        });
    </script>
</body>

</html>
