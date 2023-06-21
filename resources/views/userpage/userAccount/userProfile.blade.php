<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.headPackage')
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    <title>{{ config('app.name') }}</title>
</head>

<body>
    <div class="wrapper">
        @include('sweetalert::alert')
        @include('partials.header')
        @include('partials.sidebar')
        <x-messages />

        <div class="main-content pt-8 pr-8 pl-28">
            <div class="user-profile-container relative bg-slate-50 rounded shadow-lg mt-4">
                <div class="bg-red-700 h-60 rounded-t-lg">
                </div>
                <div class="flex justify-center items-center">
                    <div class="absolute bg-slate-300 w-60 h-60 rounded-full overflow-hidden">
                        <img src="{{ asset('assets/img/profile.png') }}" alt="Profile" id="profile">
                    </div>
                </div>
                <button
                    class="float-right bg-yellow-500 hover:bg-yellow-600 p-2 mt-2 mr-4 rounded font-medium text-white drop-shadow-xl transition ease-in-out delay-150 hover:scale-105 duration-100"
                    id="editProfileBtn">
                    <i class="bi bi-pencil pr-2"></i>
                    Edit Profile
                </button>
                @include('userpage.userAccount.editAccount')
                <div class="mt-40">
                    <form id='userProfileForm' class="relative">
                        <div class="w-full px-4 mb-12 drop-shadow-xl">
                            <label for="user_position"
                                class="bg-red-700 w-full rounded-t-lg text-white py-3 px-2 text-lg font-semibold tracking-wide">User
                                Role</label><br>
                            <div class="flex justify-between bg-slate-50">
                                <div class="py-3 px-2 font-bold">{{ Auth::user()->user_role }}</div>
                            </div>
                        </div>
                        <div class="w-full px-4 mb-12 drop-shadow-xl">
                            <label for="user_position"
                                class="bg-red-700 w-full rounded-t-lg text-white py-3 px-2 text-lg font-semibold tracking-wide">Position</label><br>
                            <div class="flex justify-between bg-slate-50">
                                <div class="py-3 px-2 font-bold">{{ Auth::user()->position }}</div>
                            </div>
                        </div>
                        <div class="w-full px-4 drop-shadow-xl">
                            <label for="user_position"
                                class="bg-red-700 w-full rounded-t-lg text-white py-3 px-2 text-lg font-semibold tracking-wide">Email
                                Address</label><br>
                            <div class="flex justify-between bg-slate-50">
                                <div class="py-3 px-2 font-bold">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $('#editProfileBtn').click(function() {
                $('#accountForm')[0].reset();
                $('#accountId').val('{{ Auth::user()->id }}');
                $('#user_role').val('{{ Auth::user()->user_role }}');
                $('#position').val('{{ Auth::user()->position }}');
                $('#email').val('{{ Auth::user()->email }}');
                $('#editAccountModal').modal('show');
            });

            $('#saveProfileDetails').click(function(e) {
                var accountid = $('#accountId').val();
                e.preventDefault();

                Swal.fire({
                    icon: 'question',
                    title: 'Would you like to save your profile details?',
                    showDenyButton: true,
                    confirmButtonText: 'Yes, save it.',
                    confirmButtonColor: '#334155',
                    denyButtonText: 'Double Check'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('update.account.cdrrmo', ':accountid') }}"
                                .replace(':accountid', accountid),
                            method: 'put',
                            data: $('#accountForm').serialize(),
                            dataType: 'json',
                            beforeSend: function(data) {
                                $(document).find('span.error-text').text('');
                            },
                            success: function(data) {
                                if (data.condition == 0) {
                                    $.each(data.error, function(prefix, val) {
                                        $('span.' + prefix + '_error').text(val[
                                            0]);
                                    });
                                    Swal.fire({
                                        icon: 'error',
                                        confirmButtonText: 'Understood',
                                        confirmButtonColor: '#334155',
                                        title: "{{ config('app.name') }}",
                                        text: 'Failed to Edit Account Details.'
                                    });
                                } else {
                                    $('#accountForm')[0].reset();
                                    $('#editAccountModal').modal('hide');
                                    Swal.fire({
                                        title: "{{ config('app.name') }}",
                                        text: 'Account Details Successfully Updated.',
                                        icon: 'success'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                }
                            },
                            error: function(data) {
                                Swal.fire({
                                    icon: 'error',
                                    confirmButtonText: 'Understood',
                                    confirmButtonColor: '#334155',
                                    title: "{{ config('app.name') }}",
                                    text: 'Something went wrong, try again later.'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>
