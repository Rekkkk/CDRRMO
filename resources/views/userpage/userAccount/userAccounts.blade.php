<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.headPackage')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
</head>

<body>
    <div class="wrapper">
        @include('sweetalert::alert')
        @include('partials.header')
        @include('partials.sidebar')
        <div class="main-content">
            <div class="grid grid-cols-1">
                <div class="grid col-end-1 mr-4">
                    <div class="text-2xl text-white">
                        <i class="bi bi-person-gear p-2 bg-slate-600 rounded"></i>
                    </div>
                </div>
                <span class="text-xl font-bold tracking-wider">MANAGE ACCOUNTS</span>
            </div>
            <hr class="mt-3">
            <div class="account-table bg-slate-50 shadow-lg p-3 rounded mt-3">
                <div class="flex justify-between mt-1 mb-3">
                    <header class="text-2xl font-semibold">User Accounts Table</header>
                    <button class="btn-submit p-2" id="createUserAccount">
                        <i class="bi bi-person-fill-add pr-2"></i>
                        Create User Account
                    </button>
                </div>
                <table class="table accountTable display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Email Address</th>
                            <th>Organization</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th style="width:20%">Action</th>
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
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
        integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
        crossorigin="anonymous"></script>
    @include('partials.toastr')
    <script>
        $(document).ready(function() {
            let userId, defaultFormData;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let accountTable = $('.accountTable').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                processing: false,
                serverSide: true,
                ajax: "{{ route('account.display.users') }}",
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

            $(document).on('change', '.actionSelect', function() {
                let selectedAction = $(this).val();
                let currentRow = $(this).closest('tr');

                if (accountTable.responsive.hasHidden())
                    currentRow = currentRow.prev('tr');

                let data = accountTable.row(currentRow).data();
                userId = data['id'];

                if (selectedAction === 'restrictAccount') {
                    confirmModal('Do you want to restrict this user?').then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "PUT",
                                url: "{{ route('account.restrict', ':userId') }}"
                                    .replace(':userId', userId),
                                success: function(response) {
                                    if (response.status == 0) {
                                        messageModal('Warning',
                                            'Failed to restrict user details.',
                                            'warning', '#FFDF00');
                                    } else {
                                        messageModal('Success',
                                            'Successfully User Restricted.',
                                            'success', '#3CB043');
                                        accountTable.draw();
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
                } else if (selectedAction === 'unrestrictAccount') {
                    confirmModal('Do you want to unrestrict this user?').then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "PUT",
                                url: "{{ route('account.unrestrict', ':userId') }}"
                                    .replace(':userId', userId),
                                success: function(data) {
                                    if (data.status == 0) {
                                        messageModal('Warning',
                                            'Failed to unrestrict user.', 'warning',
                                            '#FFDF00');
                                    } else {
                                        messageModal('Success',
                                            'Successfully User Unrestricted.',
                                            'success', '#3CB043');
                                        accountTable.draw();
                                    }
                                },
                                error: function(response) {
                                    messageModal('Warning',
                                        'Something went wrong, Try again later.',
                                        'warning', '#FFDF00');
                                }
                            });
                        }
                    });
                } else if (selectedAction === 'editAccount') {
                    $('.modal-header').removeClass('bg-green-600').addClass('bg-yellow-500');
                    $('.modal-title').text('Edit User Account Form');
                    $('#saveProfileDetails').removeClass('btn-submit').addClass('btn-edit').text('Update');
                    $('#suspend').prop('disabled', true);
                    $('#organization').val(data['organization']);
                    $('#position').val(data['position']);
                    $('#email').val(data['email']);
                    $('#operation').val('update');
                    $('#userAccountModal').modal('show');
                    defaultFormData = $('#accountForm').serialize();
                } else if (selectedAction === 'removeAccount') {
                    confirmModal('Do you want to remove this user account?').then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('account.remove', ':userId') }}"
                                    .replace(':userId', userId),
                                success: function(response) {
                                    if (response.status == 0) {
                                        messageModal('Warning',
                                            'Failed to remove user details.',
                                            'warning', '#FFDF00');
                                    } else {
                                        messageModal('Success',
                                            'Successfully removed user account.',
                                            'success', '#3CB043');
                                        accountTable.draw();
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
                } else if (selectedAction === 'suspendAccount') {
                    $('.modal-header').removeClass('bg-green-600').addClass('bg-yellow-500');
                    $('.modal-title').text('Suspend User Account Form');
                    $('#saveProfileDetails').removeClass('btn-submit').addClass('btn-edit').text('Suspend');
                    $('#organization').val(data['organization']);
                    $('#position').val(data['position']);
                    $('#email').val(data['email']);
                    $('#operation').val('suspend');
                    $('#userAccountModal').modal('show');
                    defaultFormData = $('#accountForm').serialize();
                } else if (selectedAction === 'openAccount') {
                    confirmModal('Do you want to open this user account?').then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "PUT",
                                url: "{{ route('account.open', ':userId') }}"
                                    .replace(':userId', userId),
                                success: function(response) {
                                    if (response.status == 0) {
                                        messageModal('Warning',
                                            'Failed to open user account.',
                                            'warning', '#FFDF00');
                                    } else {
                                        messageModal('Success',
                                            'Successfully opened user account.',
                                            'success', '#3CB043');
                                        accountTable.draw();
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

            $('#createUserAccount').click(function() {
                $('.modal-header').removeClass('bg-yellow-500').addClass('bg-green-600');
                $('.modal-title').text('Create User Account Form');
                $('#saveProfileDetails').removeClass('btn-edit').addClass('btn-submit').text('Create');
                $('#suspend-container').prop('hidden', true);
                $('#suspend').prop('disabled', true);
                $('#operation').val('create');
                $('#userAccountModal').modal('show');
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
                    },
                    suspend: {
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
                    },
                    suspend: {
                        required: 'Please Enter Suspension Time.'
                    }
                },
                errorElement: 'span',
                submitHandler: formSubmitHandler
            });

            function formSubmitHandler(form) {
                let operation = $('#operation').val(),
                    url = "",
                    type = "",
                    formData = $(form).serialize(),
                    modal = $('#userAccountModal');

                url = operation == 'create' ? "{{ route('account.create') }}" :
                    operation == 'update' ? "{{ route('account.update', 'userId') }}".replace('userId', userId) :
                    "{{ route('account.suspend', 'userId') }}".replace('userId', userId);

                type = operation == 'create' ? "POST" : "PUT";

                confirmModal(`Do you want to ${operation} this user details?`).then((result) => {
                    if (result.isConfirmed) {
                        if (operation == 'update' && defaultFormData == formData) {
                            modal.modal('hide');
                            messageModal('Info', 'No changes were made.', 'info', '#B91C1C');
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
                                    messageModal('Warning',
                                        `Failed to ${operation} user details.`, 'warning',
                                        '#FFDF00');
                                } else {
                                    messageModal('Success',
                                        `Successfully ${operation}${operation == 'create' ? 'd' : operation == 'update' ? 'd' : 'ed'} user account.`,
                                        'success', '#3CB043');

                                    modal.modal('hide');
                                    accountTable.draw();
                                }
                            },
                            error: function() {
                                modal.modal('hide');
                                messageModal('Warning',
                                    'Something went wrong, Try again later.', 'warning',
                                    '#FFDF00');
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
                $(document).find('span.error-text').text('');
                $('#suspend').prop('disabled', false);
                $('#suspend-container').prop('hidden', false);
                $('.actionSelect').val('');
                $('#accountForm').trigger("reset");
            });
        });
    </script>
</body>

</html>
