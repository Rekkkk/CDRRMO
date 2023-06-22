<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.headPackage')
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <title>{{ config('app.name') }}</title>
</head>

<body>
    <div class="wrapper">
        @include('sweetalert::alert')
        @include('partials.header')
        @include('partials.sidebar')
        <div class="main-content pt-8 pr-8 pl-28">
            <div class="account-table bg-slate-50 shadow-lg p-4 rounded">
                <header class="text-2xl font-semibold">User Accounts</header>
                <table class="table data-table display nowrap" style="width:100%" id="account-table">
                    <thead>
                        <tr>
                            <th>Email Address</th>
                            <th>Organization</th>
                            <th>Position</th>
                            <th class="w-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                @include('userpage.userAccount.editAccount')
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var account_table = $('.data-table').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                processing: false,
                serverSide: true,
                ajax: "{{ route('display.user.accounts') }}",
                columns: [{
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'user_role',
                        name: 'user_role'
                    },
                    {
                        data: 'position',
                        name: 'position'
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
                var user_id = $(this).data('id');

                Swal.fire({
                    title: 'Would you like to restrict this user?',
                    showDenyButton: true,
                    confirmButtonText: 'Yes, restrict it.',
                    confirmButtonColor: '#334155',
                    denyButtonText: `Don't Restrict`,
                    denyButtonColor: '#b91c1c',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "PUT",
                            url: "{{ route('restrict.account', ':user_id') }}"
                                .replace(':user_id', user_id),
                            success: function(data) {
                                if (data.status == 0) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: "{{ config('app.name') }}",
                                        text: 'Failed to restrict user.',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#334155',
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: "{{ config('app.name') }}",
                                        text: 'Successfully User Restricted.',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#334155',
                                    });
                                    account_table.draw();
                                }
                            },
                            error: function(response) {
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
                })
            });

            $('body').on('click', '.unRestrictUserAccount', function() {
                var user_id = $(this).data('id');

                Swal.fire({
                    title: 'Would you like to unrestrict this user?',
                    showDenyButton: true,
                    confirmButtonText: 'Yes, unrestrict it.',
                    confirmButtonColor: '#334155',
                    denyButtonText: `Don't Unrestrict`,
                    denyButtonColor: '#b91c1c',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "PUT",
                            url: "{{ route('unrestrict.account', ':user_id') }}"
                                .replace(':user_id', user_id),
                            success: function(data) {
                                if (data.status == 0) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: "{{ config('app.name') }}",
                                        text: 'Failed to unrestrict user.',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#334155',
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: "{{ config('app.name') }}",
                                        text: 'Successfully User Unrestricted.',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#334155',
                                    });
                                    account_table.draw();
                                }
                            },
                            error: function(response) {
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
                })
            });

            $('body').on('click', '.editUserAccount', function(e) {
                var user_id = $(this).data("id");
                e.preventDefault();

                $.ajax({
                    url: "{{ route('user.details', ':user_id') }}"
                        .replace(':user_id', user_id),
                    dataType: "json",
                    success: function(response) {
                        $(document).find('span.error-text').text('');
                        $('#accountForm')[0].reset();
                        $('#accountId').val(user_id);
                        $('#user_role').val(response.result.user_role);
                        $('#position').val(response.result.position);
                        $('#email').val(response.result.email);
                        $('#editAccountModal').modal('show');
                    },
                    error: function(response) {
                        Swal.fire(
                            "{{ config('app.name') }}",
                            'Something went Wrong.',
                            'error'
                        );
                    }
                })
            });

            $('#saveProfileDetails').click(function(e) {
                var user_id = $('#accountId').val();
                e.preventDefault();

                Swal.fire({
                    icon: 'question',
                    title: 'Would you like to save profile details?',
                    showDenyButton: true,
                    confirmButtonText: 'Yes, save it.',
                    confirmButtonColor: '#334155',
                    denyButtonText: 'Double Check'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('update.account', ':user_id') }}"
                                .replace(':user_id', user_id),
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
                                            account_table.draw();
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
