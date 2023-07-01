<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.headPackage')
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <title>{{ config('app.name') }}</title>
</head>

<body>
    <div class="wrapper">
        @include('sweetalert::alert')
        @include('partials.header')
        @include('partials.sidebar')
        <div class="main-content">
            <div class="account-table bg-slate-50 shadow-lg p-4 rounded">
                <div class="flex justify-between">
                    <header class="text-2xl font-semibold">User Accounts Table</header>
                    <button class="btn-submit p-2 mb-4" id="createUserAccount">
                        <i class="bi bi-person-fill-add pr-2"></i>
                        Create User Account
                    </button>
                </div>
                <table class="table data-table display nowrap" style="width:100%" id="account-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Email Address</th>
                            <th>Organization</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th class="w-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                @include('userpage.userAccount.userAccountModal')
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
        integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            let userId, defaultFormData;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let accountTable = $('.data-table').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                processing: false,
                serverSide: true,
                ajax: "{{ route('display.user.accounts') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        visible: false
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'organization',
                        name: 'organization'
                    },
                    {
                        data: 'position',
                        name: 'position'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('body').on('click', '.restrictUserAccount', function() {
                userId = $(this).data('id');

                confirmModal('Do you want to restrict this user?').then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "PUT",
                            url: "{{ route('restrict.account', ':userId') }}"
                                .replace(':userId', userId),
                            success: function(data) {
                                if (data.status == 0) {
                                    messageModal(
                                        'Warning',
                                        'Failed to restrict user details.',
                                        'warning',
                                        '#FFDF00'
                                    );
                                } else {
                                    messageModal(
                                        'Success',
                                        'Successfully User Restricted.',
                                        'success',
                                        '#3CB043'
                                    );
                                    accountTable.draw();
                                }
                            },
                            error: function() {
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
            });

            $('body').on('click', '.unRestrictUserAccount', function() {
                userId = $(this).data('id');

                confirmModal('Do you want to unrestrict this user?').then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "PUT",
                            url: "{{ route('unrestrict.account', ':userId') }}"
                                .replace(':userId', userId),
                            success: function(data) {
                                if (data.status == 0) {
                                    messageModal(
                                        'Warning',
                                        'Failed to unrestrict user.',
                                        'warning',
                                        '#FFDF00'
                                    );
                                } else {
                                    messageModal(
                                        'Success',
                                        'Successfully User Unrestricted.',
                                        'success',
                                        '#3CB043'
                                    );
                                    accountTable.draw();
                                }
                            },
                            error: function(response) {
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
            });

            $('#createUserAccount').click(function() {
                $('.modal-header').removeClass('bg-yellow-500').addClass('bg-green-600');
                $('.modal-title').text('Create User Account Form');
                $('#saveProfileDetails').removeClass('btn-edit').addClass('btn-submit');
                $('#operation').val('create');
                $('#userAccountModal').modal('show');
                $('#saveProfileDetails').text('Create');
            });

            $(document).on('click', '.editUserAccount', function() {
                $('.modal-header').removeClass('bg-green-600').addClass('bg-yellow-500');
                $('.modal-title').text('Edit User Account Form');
                $('#saveProfileDetails').removeClass('btn-submit').addClass('btn-edit');
                $('#saveProfileDetails').text('Update');

                let currentRow = $(this).closest('tr');

                if (accountTable.responsive.hasHidden())
                    currentRow = currentRow.prev('tr');

                let data = accountTable.row(currentRow).data();
                userId = data['id'];
                $('#suspend-container').hide();
                $('#organization').val(data['organization']);
                $('#position').val(data['position']);
                $('#email').val(data['email']);
                $('#operation').val('update');
                $('#userAccountModal').modal('show');
                defaultFormData = $('#accountForm').serialize();
            });

            $(document).on('click', '.removeUserAccount', function() {
                userId = $(this).data('id');

                confirmModal('Do you want to remove this user account?').then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('remove.account', ':userId') }}"
                                .replace(':userId', userId),
                            success: function(response) {
                                if (response.status == 0) {
                                    messageModal(
                                        'Warning',
                                        'Failed to remove user details.',
                                        'warning',
                                        '#FFDF00'
                                    );
                                } else {
                                    Swal.fire(
                                        'Success',
                                        'Successfully removed user account.',
                                        'success'
                                    );

                                    accountTable.draw();
                                }
                            },
                            error: function() {
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
            });

            $(document).on('click', '.suspendUserAccount', function() {
                $('.modal-header').removeClass('bg-green-600').addClass('bg-yellow-500');
                $('.modal-title').text('Suspend User Account Form');
                $('#saveProfileDetails').removeClass('btn-submit').addClass('btn-edit');
                $('#saveProfileDetails').text('Suspend');

                let currentRow = $(this).closest('tr');

                if (accountTable.responsive.hasHidden())
                    currentRow = currentRow.prev('tr');

                let data = accountTable.row(currentRow).data();
                userId = data['id'];
                
                $('#organization').val(data['organization']);
                $('#position').val(data['position']);
                $('#email').val(data['email']);
                $('#operation').val('suspend');
                $('#userAccountModal').modal('show');
                defaultFormData = $('#accountForm').serialize();
            });

            $(document).on('click', '.openUserAccount', function() {
                userId = $(this).data('id');

                confirmModal('Do you want to open this user account?').then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "PUT",
                            url: "{{ route('open.account', ':userId') }}"
                                .replace(':userId', userId),
                            success: function(response) {
                                if (response.status == 0) {
                                    messageModal(
                                        'Warning',
                                        'Failed to open user account.',
                                        'warning',
                                        '#FFDF00'
                                    );
                                } else {
                                    Swal.fire(
                                        'Success',
                                        'Successfully opened user account.',
                                        'success'
                                    );

                                    accountTable.draw();
                                }
                            },
                            error: function() {
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
                submitHandler: formSubmitHandler,
            });

            function formSubmitHandler(form) {
                let operation = $('#operation').val(),
                    url = "",
                    type = "",
                    formData = $(form).serialize(),
                    modal = $('#userAccountModal');

                if (operation == 'create') {
                    url = "{{ route('create.account') }}";
                    type = "POST";
                } else if (operation == 'update') {
                    url = "{{ route('update.account', 'userId') }}".replace('userId', userId);
                    type = "PUT";
                } else {
                    url = "{{ route('suspend.account', 'userId') }}".replace('userId', userId);
                    type = "PUT";
                }

                confirmModal(`Do you want to ${operation} this user details?`).then((result) => {
                    if (result.isConfirmed) {
                        if (operation == 'update' && defaultFormData == formData) {
                            modal.modal('hide');
                            messageModal(
                                'Info',
                                'No changes were made.',
                                'info',
                                '#B91C1C'
                            );
                            return;
                        }
                        $.ajax({
                            data: formData,
                            url: url,
                            type: type,
                            dataType: 'json',
                            success: function(response) {
                                if (response.status == 0) {
                                    $.each(response.error, function(prefix, val) {
                                        $('span.' + prefix + '_error').text(val[0]);
                                    });
                                    messageModal(
                                        'Warning',
                                        `Failed to ${operation} user details.`,
                                        'warning',
                                        '#FFDF00'
                                    );
                                } else {
                                    if (operation == 'create') {
                                        Swal.fire(
                                            'Success',
                                            `Successfully ${operation}d new user account.`,
                                            'success'
                                        )
                                    } else {
                                        messageModal(
                                            'Success',
                                            `Successfully ${operation}d the user details.`,
                                            'success',
                                            '#3CB043'
                                        );
                                    }

                                    modal.modal('hide');
                                    accountTable.draw();
                                }
                            },
                            error: function() {
                                modal.modal('hide');
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

            function datePicker(id) {
                return flatpickr(id, {
                    enableTime: true,
                    allowInput: true,
                    static: false,
                    timeFormat: "h:i K",
                    dateFormat: "D, M j, Y h:i K",
                    minuteIncrement: 1,
                    secondIncrement: 1,
                    position: "below center",
                });
            }

            let dateSuspendTime = datePicker("#suspend");

            $('#userAccountModal').on('hidden.bs.modal', function() {
                validator.resetForm();
                $('#suspend-container').show();
                $(document).find('span.error-text').text('');
                $('#accountForm').trigger("reset");
            });
        });
    </script>
</body>

</html>
