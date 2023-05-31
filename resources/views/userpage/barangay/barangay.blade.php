<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.content.headPackage')
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <title>{{ config('app.name') }}</title>
</head>

<body class="bg-gray-400">
    <div class="wrapper">
        @include('sweetalert::alert')
        @include('partials.content.header')
        @include('partials.content.sidebar')

        <x-messages />

        <div class="content pt-8 pr-8 pl-28">
            <div class="dashboard-logo pb-4">
                <i class="bi bi-hospital text-2xl p-2 bg-slate-900 text-white rounded"></i>
                <span class="text-2xl font-bold tracking-wider mx-2">BARANGAY INFORMATION</span>
                <hr class="mt-4">
            </div>
            <div class="main-content flex bg-slate-50 p-4">
                <div class="barangay-form p-3 mx-2 border-r-2">
                    <header class="text-xl font-semibold">Barangay Information</header>
                    <hr>
                    <form id="addBarangayForm" name="addBarangayForm">
                        @csrf
                        <div class="form barangay my-3">
                            <div class="field">
                                <div class="flex flex-col">
                                    <label for="barangay_name">Barangay Name</label>
                                    <input type="text" name="barangay_name"
                                        value="{{ !empty(old('barangay_name')) ? old('barangay_name') : null }}"
                                        class="border-2 border-slate-400 px-3 mb-2 h-11 text-slate-600 outline-none text-sm font-normal rounded"
                                        autocomplete="off" placeholder="Barangay Name">
                                    <span class="text-danger italic text-xs error-text barangay_name_error"></span>
                                </div>
                            </div>

                            <div class="fields">
                                <div class="flex flex-col">
                                    <label for="barangay_location">Barangay Location</label>
                                    <input type="text" name="barangay_location"
                                        value="{{ !empty(old('barangay_location')) ? old('barangay_location') : null }}"
                                        class="border-2 border-slate-400 px-3 mb-2 h-11 text-slate-600 outline-none text-sm font-normal rounded"
                                        autocomplete="off" placeholder="Barangay Location">
                                    <span class="text-danger italic text-xs error-text barangay_location_error"></span>
                                </div>
                            </div>

                            <div class="fields">
                                <div class="flex flex-col">
                                    <label for="barangay_contact">Barangay Contact Number</label>
                                    <input type="text" name="barangay_contact"
                                        value="{{ !empty(old('barangay_contact')) ? old('barangay_contact') : null }}"
                                        class="border-2 border-slate-400 px-3 mb-2 h-11 text-slate-600 outline-none text-sm font-normal rounded"
                                        autocomplete="off" placeholder="Barangay Contact Number">
                                    <span class="text-danger italic text-xs error-text barangay_contact_error"></span>
                                </div>
                            </div>

                            <div class="fields">
                                <div class="flex flex-col">
                                    <label for="barangay_email">Barangay Email Address</label>
                                    <input type="text" name="barangay_email"
                                        value="{{ !empty(old('barangay_email')) ? old('barangay_email') : null }}"
                                        class="border-2 border-slate-400 px-3 mb-2 h-11 text-slate-600 outline-none text-sm font-normal rounded"
                                        autocomplete="off" placeholder="Barangay Email Address">
                                    <span class="text-danger italic text-xs error-text barangay_email_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="barangay-button text-white">
                            <a href="{{ route('dashboard.cdrrmo') }}">
                                <button type="button"
                                    class="bg-slate-700  p-2 rounded hover:bg-slate-900">Cancel</button>
                            </a>
                            <button id="addBarangay"
                                class="bg-red-700 p-2 rounded hover:bg-red-900">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="barangay-table bg-slate-100">
                    <header class="text-2xl font-semibold py-3">Barangay Table</header>
                    <table class="table data-table display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th class="w-px">Barangay Name</th>
                                <th>Location</th>
                                <th>Contact Number</th>
                                <th>Email Address</th>
                                <th class="w-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            </div>
            @include('userpage.barangay.updateBarangay')
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

            var barangayTable = $('.data-table').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                processing: false,
                serverSide: true,
                ajax: "{{ route('barangay.cdrrmo') }}",
                columns: [{
                        data: 'barangay_name',
                        name: 'barangay_name'
                    },
                    {
                        data: 'barangay_location',
                        name: 'barangay_location'
                    },
                    {
                        data: 'barangay_contact_number',
                        name: 'barangay_contact_number'
                    },
                    {
                        data: 'barangay_email_address',
                        name: 'barangay_email_address'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#addBarangay').click(function(e) {
                e.preventDefault();

                Swal.fire({
                    icon: 'question',
                    title: 'Would you like to submit this barangay?',
                    showDenyButton: true,
                    showLoaderOnConfirm: true,
                    confirmButtonText: 'Yes, submit it.',
                    confirmButtonColor: '#334155',
                    denyButtonText: `Double Check`,
                    denyButtonColor: '#b91c1c',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            data: $('#addBarangayForm').serialize(),
                            url: "{{ route('register.barangay.cdrrmo') }}",
                            type: "POST",
                            dataType: 'json',
                            beforeSend: function(response) {
                                $(document).find('span.error-text').text('');
                            },
                            success: function(response) {
                                if (response.status == 0) {
                                    $.each(response.error, function(prefix, val) {
                                        $('span.' + prefix + '_error').text(val[
                                            0]);
                                    });
                                    Swal.fire({
                                        icon: 'error',
                                        confirmButtonText: 'Understood',
                                        confirmButtonColor: '#334155',
                                        title: "{{ config('app.name') }}",
                                        text: 'Failed to submit barangay.'
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#334155',
                                        title: "{{ config('app.name') }}",
                                        text: 'Barangay Submitted Successfully.'
                                    });
                                    $('#addBarangayForm')[0].reset();
                                    barangayTable.draw();
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
                })
            });

            $(document).on('click', '.updateBarangay', function(e) {
                e.preventDefault();
                var barangay_id = $(this).data("id");

                $.ajax({
                    url: "{{ route('barangay.details.cdrrmo', ':barangay_id') }}"
                        .replace(':barangay_id', barangay_id),
                    dataType: "json",
                    success: function(response) {
                        $('#name').val(response.result.barangay_name);
                        $('#location').val(response.result.barangay_location);
                        $('#contact').val(response.result.barangay_contact_number);
                        $('#email').val(response.result.barangay_email_address);
                        $('#barangayId').val(barangay_id);
                        $('#editBarangay').modal('show');
                    },
                    error: function(response) {
                        var errors = response.responseJSON;
                    }
                })
            });

            $(document).on('click', '#editbarangay', function(e) {
                e.preventDefault();
                var barangay_id = $('#barangayId').val();

                $.ajax({
                    url: "{{ route('update.barangay.cdrrmo', ':barangay_id') }}"
                        .replace(':barangay_id', barangay_id),
                    method: 'put',
                    data: $('#editBarangayForm').serialize(),
                    dataType: "json",
                    beforeSend: function(response) {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(response) {
                        if (response.status == 0) {
                            $.each(response.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                confirmButtonText: 'Understood',
                                confirmButtonColor: '#334155',
                                title: "{{ config('app.name') }}",
                                text: 'Failed to Update Barangay.'
                            });
                        } else {
                            Swal.fire({
                                icon: 'success',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#334155',
                                title: "{{ config('app.name') }}",
                                text: 'Barangay Updated Successfully.'
                            });
                            $('#editBarangayForm')[0].reset();
                            $('#editBarangay').modal('hide');
                            barangayTable.draw();
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
                })
            });

            $('body').on('click', '.removeBarangay', function() {
                var barangay_id = $(this).data("id");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to undo this!",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#334155',
                    cancelButtonColor: '#b91c1c',
                    confirmButtonText: 'Yes, delete it.'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('remove.barangay.cdrrmo', ':barangay_id') }}"
                                .replace(':barangay_id', barangay_id),
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#334155',
                                    title: "{{ config('app.name') }}",
                                    text: 'Barangay has been deleted.'
                                });
                                barangayTable.draw();
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
                });
            });
        });
    </script>

</body>

</html>
