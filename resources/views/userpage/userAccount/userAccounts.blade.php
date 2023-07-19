<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.headPackage')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
</head>

<body>
    <div class="wrapper">
        @include('partials.header')
        @include('partials.sidebar')
        <div class="main-content">
            <div class="grid grid-cols-1">
                <div class="grid col-end-1">
                    <div class="text-2xl text-white">
                        <i class="bi bi-person-gear p-2 bg-slate-600 rounded"></i>
                    </div>
                </div>
                <span class="text-xl font-bold">MANAGE ACCOUNTS</span>
            </div>
            <hr class="mt-4">
            <div class="flex justify-end my-3">
                <button class="btn-submit p-2 createUserAccount">
                    <i class="bi bi-person-fill-add pr-2"></i>
                    Create User Account
                </button>
            </div>
            <div class="table-container p-3 shadow-lg rounded-lg">
                <header class="text-2xl font-semibold mb-3">User Accounts Table</header>
                <div class="block w-full overflow-auto">
                    <table class="table accountTable" width="100%">
                        <thead class="thead-light">
                            <tr>
                                <th></th>
                                <th>Email Address</th>
                                <th>Organization</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th width="20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                @include('userpage.userAccount.userAccountModal')
                @include('userpage.changePasswordModal')
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
    @can('view', \App\Models\User::class)
        <script>
            $(document).ready(function() {
                let userId, defaultFormData, dateSuspendTime = datePicker("#suspend");

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

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $(document).on('change', '.actionSelect', function() {
                    let selectedAction = $(this).val();
                    let currentRow = $(this).closest('tr');

                    if (accountTable.responsive.hasHidden())
                        currentRow = currentRow.prev('tr');

                    let data = accountTable.row(currentRow).data();
                    userId = data['id'];

                    if (selectedAction == 'disableAccount') {
                        confirmModal('Do you want to disable this account?').then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "PUT",
                                    url: "{{ route('account.disable', ':userId') }}"
                                        .replace(':userId', userId),
                                    success: function() {
                                        toastr.success('Successfully disabled account.',
                                            'Success');
                                        accountTable.draw();
                                    },
                                    error: function() {
                                        toastr.error(
                                            'An error occurred while processing your request.',
                                            'Error');
                                    }
                                });
                            } else {
                                $('.actionSelect').val('');
                            }
                        });
                    } else if (selectedAction == 'enableAccount') {
                        confirmModal('Do you want to enable this account?').then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "PUT",
                                    url: "{{ route('account.enable', ':userId') }}"
                                        .replace(':userId', userId),
                                    success: function() {
                                        toastr.success('Successfully enabled account.',
                                            'Success');
                                        accountTable.draw();
                                    },
                                    error: function() {
                                        toastr.error(
                                            'An error occurred while processing your request.',
                                            'Error');
                                    }
                                });
                            } else {
                                $('.actionSelect').val('');
                            }
                        });
                    } else if (selectedAction == 'editAccount') {
                        $('.modal-header').attr('class', 'modal-header bg-yellow-500');
                        $('.modal-title').text('Edit User Account');
                        $('#saveProfileDetails').attr('class', 'btn-edit p-2 float-right').text('Update');
                        $('#suspend-container').prop('hidden', true);
                        $('#organization').val(data['organization']);
                        $('#position').val(data['position']);
                        $('#email').val(data['email']);
                        $('#operation').val('update');
                        $('#userAccountModal').modal('show');
                        defaultFormData = $('#accountForm').serialize();
                    } else if (selectedAction == 'removeAccount') {
                        confirmModal('Do you want to remove this user account?').then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "DELETE",
                                    url: "{{ route('account.remove', ':userId') }}"
                                        .replace(':userId', userId),
                                    success: function() {
                                        toastr.success('Successfully removed account.',
                                            'Success');
                                        accountTable.draw();
                                    },
                                    error: function() {
                                        toastr.error(
                                            'An error occurred while processing your request.',
                                            'Error');
                                    }
                                });
                            } else {
                                $('.actionSelect').val('');
                            }
                        });
                    } else if (selectedAction == 'suspendAccount') {
                        $('.modal-header').removeClass('bg-green-600').addClass('bg-yellow-500');
                        $('.modal-title').text('Suspend User Account Form');
                        $('#saveProfileDetails').removeClass('btn-submit').addClass('btn-edit').text('Suspend');
                        $('#organization').val(data['organization']);
                        $('#position').val(data['position']);
                        $('#email').val(data['email']);
                        $('#operation').val('suspend');
                        $('#userAccountModal').modal('show');
                        defaultFormData = $('#accountForm').serialize();
                    } else if (selectedAction == 'openAccount') {
                        confirmModal('Do you want to open this user account?').then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "PUT",
                                    url: "{{ route('account.open', ':userId') }}"
                                        .replace(':userId', userId),
                                    success: function() {
                                        toastr.success('Successfully opened account.',
                                            'Success');
                                        accountTable.draw();
                                    },
                                    error: function() {
                                        toastr.error(
                                            'An error occurred while processing your request.',
                                            'Error');
                                    }
                                });
                            } else {
                                $('.actionSelect').val('');
                            }
                        });
                    }
                });

                $(document).on('click', '.createUserAccount', function() {
                    $('.modal-header').attr('class', 'modal-header bg-green-600');
                    $('.modal-title').text('Create User Account Form');
                    $('#saveProfileDetails').attr('class', 'btn-submit p-2 float-right').text('Create');
                    $('#suspend-container').prop('hidden', true);
                    $('#suspend').prop('disabled', true);
                    $('#operation').val('create');
                    $('#userAccountModal').modal('show');
                });

                $('#userAccountModal').on('hidden.bs.modal', function() {
                    validator.resetForm();
                    $('#suspend-container').prop('hidden', false);
                    $('#suspend').prop('disabled', false);
                    $('.actionSelect').val('');
                    $('#accountForm')[0].reset();
                });

                function formSubmitHandler(form) {
                    let operation = $('#operation').val(),
                        url, type, formData = $(form).serialize(),
                        modal = $('#userAccountModal');

                    url = operation == 'create' ? "{{ route('account.create') }}" :
                        operation == 'update' ? "{{ route('account.update', 'userId') }}".replace('userId', userId) :
                        "{{ route('account.suspend', 'userId') }}".replace('userId', userId);

                    type = operation == 'create' ? "POST" : "PUT";

                    confirmModal(`Do you want to ${operation} this user details?`).then((result) => {
                        if (result.isConfirmed) {
                            if (operation == 'update' && defaultFormData == formData) {
                                toastr.warning('No changes were made.', 'Warning');
                                return;
                            }
                            $.ajax({
                                data: formData,
                                url: url,
                                type: type,
                                success: function(response) {
                                    if (response.status == "warning") {
                                        toastr.warning(response.message, 'Warning');
                                    } else {
                                        toastr.success(
                                            `Successfully ${operation}${operation == 'create' ? 'd' : operation == 'update' ? 'd' : 'ed'} user account.`,
                                            'Success');
                                        modal.modal('hide');
                                        accountTable.draw();
                                    }
                                },
                                error: function() {
                                    modal.modal('hide');
                                    toastr.error('An error occurred while processing your request.',
                                        'Error');
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
                        position: "below center"
                    });
                }
            });
        </script>
    @endcan
</body>

</html>
