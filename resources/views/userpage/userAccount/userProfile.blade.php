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

        <div class="main-content">
            <div class="user-profile-container rounded shadow-lg mt-4">
                @include('userpage.userAccount.editAccount')
                <div class="mt-20">
                    <div class="flex justify-center items-center pt-4 pb-2">
                        <div class="bg-slate-300 w-60 h-60 rounded-full overflow-hidden border-4 border-indigo-500">
                            <img src="{{ asset('assets/img/profile.png') }}" alt="Profile" id="profile">
                        </div>
                    </div>
                    <div class="flex justify-end pb-2 pr-4">
                        <button class=" btn-edit top-50 right-0 p-2 rounded font-medium"
                            id="editProfileBtn">
                            <i class="bi bi-pencil pr-2"></i>
                            Edit Profile
                        </button>
                    </div>
                    <hr class="mx-6 mb-4">
                    <form id='userProfileForm' class="relative flex-auto">
                        <div class="flex flex-wrap">
                            <div class="relative w-full mb-3 lg:w-2/12 px-4 text-center">
                                @if (auth()->user()->user_role == 'CDRRMO')
                                    <label class="w-full bg-red-700 profile-details-label">Position</label>
                                    <p class="profile-details">{{ auth()->user()->position }}
                                    </p>
                                @else
                                    <label class="w-full bg-green-600 profile-details-label">Position</label>
                                    <p class="profile-details">{{ auth()->user()->position }}
                                    </p>
                                @endif
                            </div>
                            <div class="relative w-full mb-3 lg:w-5/12 px-4 text-center">
                                @if (auth()->user()->user_role == 'CDRRMO')
                                    <label class="w-full bg-red-700 profile-details-label">Organization</label>
                                    <p class="profile-details">Cabuyao Disaster Risk Reduction
                                        and Management Office ({{ auth()->user()->user_role }})</p>
                                @else
                                    <label class="w-full bg-green-600 profile-details-label">Organization</label>
                                    <p class="profile-details">City Social Welfare and
                                        Development ({{ auth()->user()->user_role }})
                                    </p>
                                @endif
                            </div>
                            <div class="relative w-full mb-3 lg:w-5/12 px-4 text-center">
                                @if (auth()->user()->user_role == 'CDRRMO')
                                    <label class="w-full bg-red-700 profile-details-label">Email
                                        Address</label>
                                    <p class="profile-details">{{ auth()->user()->email }}</p>
                                @else
                                    <label class="w-full bg-green-600 profile-details-label">Email
                                        Address</label>
                                    <p class="profile-details">{{ auth()->user()->email }}
                                    </p>
                                @endif
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
        integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('#editProfileBtn').click(function() {
                $('.modal-header').removeClass('bg-green-700').addClass('bg-yellow-500');
                $('.modal-title').text('Edit User Account Form');
                $('#saveProfileDetails').removeClass('btn-submit').addClass('btn-edit');
                $('#saveProfileDetails').text('Update');
                $('#accountForm')[0].reset();
                $('#accountId').val('{{ auth()->user()->id }}');
                $('#user_role').val('{{ auth()->user()->user_role }}');
                $('#position').val('{{ auth()->user()->position }}');
                $('#email').val('{{ auth()->user()->email }}');
                $('#userAccountModal').modal('show');
            });

            let validator = $("#accountForm").validate({
                rules: {
                    user_role: {
                        required: true
                    },
                    position: {
                        required: true
                    },
                    email: {
                        required: true
                    }
                },
                messages: {
                    user_role: {
                        required: 'Please Enter Your Organization.'
                    },
                    position: {
                        required: 'Please Enter Your Position.'
                    },
                    email: {
                        required: 'Please Enter Your Email Address.'
                    }
                },
                errorElement: 'span',
                submitHandler: formSubmitHandler,
            });

            function formSubmitHandler(form) {
                var accountid = $('#accountId').val();

                confirmModal('Do you want to update this user details?').then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('update.account', ':accountid') }}"
                                .replace(':accountid', accountid),
                            method: 'put',
                            data: $('#accountForm').serialize(),
                            dataType: 'json',
                            beforeSend: function() {
                                $(document).find('span.error-text').text('');
                            },
                            success: function(response) {
                                if (response.status == 0) {
                                    $.each(response.error, function(prefix, val) {
                                        $('span.' + prefix + '_error').text(val[0]);
                                    });
                                    messageModal(
                                        'Warning',
                                        `Failed to update user details.`,
                                        'warning',
                                        '#FFDF00'
                                    );
                                } else {
                                    messageModal(
                                        'Success',
                                        `Successfully updated the user details.`,
                                        'success',
                                        '#3CB043'
                                    ).then(function() {
                                        $('#editAccountModal').modal('hide');
                                        location.reload();
                                    });
                                }
                            },
                            error: function() {
                                $('#editAccountModal').modal('hide');
                                messageModal(
                                    'Warning',
                                    'Something went wrong, Try again later.',
                                    'warning',
                                    '#FFDF00'
                                );
                            }
                        });
                    }
                });
            }

            $('#userAccountModal').on('hidden.bs.modal', function() {
                validator.resetForm();
                $(document).find('span.error-text').text('');
                $('#accountForm').trigger("reset");
            });
        });
    </script>
</body>

</html>
