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
                <div class="grid col-end-1">
                    <div class="text-2xl text-white">
                        <i class="bi bi-person-circle p-2 bg-slate-600"></i>
                    </div>
                </div>
                <span class="text-xl font-bold">MY PROFILE</span>
            </div>
            <hr class="mt-4">
            <div class="user-profile-container rounded shadow-lg mt-3">
                <div class="profile-section flex justify-center items-center py-4">
                    <div class="bg-slate-300 w-60 h-60 rounded-full overflow-hidden border-4 border-blue-500">
                        <img src="{{ asset('assets/img/profile.png') }}" alt="Profile" id="profile">
                    </div>
                </div>
                @if (auth()->user()->is_disable == 0)
                    <div class="flex justify-end pb-3 pr-6">
                        <button class="btn-update p-2" id="editProfileBtn">
                            <i class="bi bi-pencil-square pr-2"></i>
                            Edit Profile
                        </button>
                    </div>
                @endif
                <hr class="mx-6 mb-3">
                <form id='userProfileForm' class="relative flex-auto">
                    <div class="flex flex-wrap text-center pb-2">
                        <div class="details-section lg:w-2/12">
                            <label class="bg-red-700 rounded-t profile-details-label">Position</label>
                            <p class="profile-details rounded-b">{{ auth()->user()->position }}</p>
                        </div>
                        <div class="details-section lg:w-4/12">
                            <label class="bg-red-700 rounded-t profile-details-label">Organization</label>
                            @if (auth()->user()->organization == 'CDRRMO')
                                <p class="profile-details rounded-b">Cabuyao Disaster Risk Reduction
                                    and Management Office (CDRRMO)</p>
                            @else
                                <p class="profile-details rounded-b">City Social Welfare and
                                    Development (CSWD)
                                </p>
                            @endif
                        </div>
                        <div class="details-section lg:w-4/12">
                            <label class="bg-red-700 rounded-t profile-details-label">Email
                                Address</label>
                            <p class="profile-details rounded-b">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="details-section lg:w-2/12">
                            <label class="bg-red-700 rounded-t profile-details-label">Account Status</label>
                            <p class="profile-details rounded-b">{{ auth()->user()->status }}</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if (auth()->user()->is_disable == 0)
            @include('userpage.userAccount.userAccountModal')
        @endif
        @include('userpage.changePasswordModal')
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
        integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
        crossorigin="anonymous"></script>
    @include('partials.toastr')
    @if (auth()->user()->is_disable == 0)
        <script>
            $(document).ready(function() {
                let defaultFormData, modal = $('#userAccountModal');

                $(document).on('click', '#editProfileBtn', function() {
                    $('.modal-header').removeClass('bg-green-600').addClass('bg-yellow-500');
                    $('.modal-title').text('Edit Profile Account');
                    $('#saveProfileDetails').removeClass('btn-submit').addClass('btn-update').text('Update');
                    $('#suspend-container').hide();
                    $('#account_operation').val('update');
                    $('#accountId').val('{{ auth()->user()->id }}');
                    $('#organization').val('{{ auth()->user()->organization }}');
                    $('#position').val('{{ auth()->user()->position }}');
                    $('#email').val('{{ auth()->user()->email }}');
                    modal.modal('show');
                    defaultFormData = $('#accountForm').serialize();
                });

                let validator = $("#accountForm").validate({
                    rules: {
                        organization: {
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
                        organization: {
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
                    submitHandler: formSubmitHandler
                });

                function formSubmitHandler(form) {
                    let accountid = $('#accountId').val(),
                        operation = $('#account_operation').val(),
                        formData = $(form).serialize();

                    confirmModal('Do you want to update this user details?').then((result) => {
                        if (result.isConfirmed) {
                            if (operation == 'update' && defaultFormData == formData) {
                                showWarningMessage('No changes were made.');
                                return;
                            }
                            $.ajax({
                                url: "{{ route('account.update', ':accountid') }}"
                                    .replace(':accountid', accountid),
                                method: 'PUT',
                                data: formData,
                                success: function(response) {
                                    if (response.status == 'warning') {
                                        showWarningMessage(response.message);
                                    } else {
                                        showSuccessMessage(
                                            'Successfully updated the account details.');
                                    }
                                },
                                error: function() {
                                    modal.modal('hide');
                                    showErrorMessage();
                                }
                            });
                        }
                    });
                }

                modal.on('hidden.bs.modal', function() {
                    validator.resetForm();
                    $('#accountForm').trigger("reset");
                });
            });
        </script>
    @endif
</body>

</html>
