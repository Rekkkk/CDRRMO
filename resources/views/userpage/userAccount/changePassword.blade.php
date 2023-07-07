<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.headPackage')
</head>

<body>
    <div class="wrapper">
        @include('partials.header')
        @include('partials.sidebar')
        <div class="main-content">
            <div class="grid grid-cols-1">
                <div class="grid col-end-1 mr-4">
                    <div class="text-white text-2xl">
                        <i class="bi bi-person-fill-lock p-2 bg-slate-600 rounded"></i>
                    </div>
                </div>
                <span class="text-xl font-bold tracking-wider">Change Password</span>
            </div>
            <hr class="mt-3">
            <div class="form-container">
                <form action="{{ route('account.reset.password', auth()->user()->id) }}" method="POST"
                    class="m-4 bg-slate-50 rounded drop-shadow-xl">
                    @method('PUT')
                    @csrf
                    <div class="text-center py-3 bg-green-600 text-white rounded-t">
                        <h1 class="tracking-wide text-lg font-bold px-28">Change Password Form</h1>
                    </div>
                    <hr>
                    <div class="form-content">
                        <div class="mb-2">
                            <label class="flex items-center justify-center">Current Password</label>
                            <input type="text" name="current_password" class="form-control" id="current_password"
                                value="{{ !empty(old('current_password')) ? old('current_password') : null }}"
                                autocomplete="off" required>
                            <span class="text-xs text-red-600 italic" id="currentPassword"></span>
                        </div>
                        <div class="mb-2 relative">
                            <label class="flex items-center justify-center">New Password</label>
                            <input type="password" name="password" id="password" class="form-control"
                                autocomplete="off" value="{{ !empty(old('password')) ? old('password') : null }}"
                                required>
                            <i class="bi bi-eye-slash absolute cursor-pointer text-xl" id="show-password"></i>
                        </div>
                        <div class="mb-2 relative">
                            <label class="flex items-center justify-center">Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                autocomplete="off" onpaste="return false;" required>
                            <i class="bi bi-eye-slash absolute cursor-pointer text-xl" id="show-confirm"></i>
                        </div>
                        <div class="mt-4 mb-2 text-center">
                            <button type="submit" class="btn-submit bg-green-600 p-2">Change</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
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
                            } else if (response.status == 1) {
                                $('#currentPassword').html(
                                        '* Current Password is Correct.')
                                    .removeClass('text-red-600').addClass(
                                        'text-green-600');
                            }
                        }
                    });
                }, 500));
            });
        });
    </script>
</body>

</html>
