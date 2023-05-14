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

        <div class="main-content pt-8 pr-8 pl-28">
            <div class="dashboard-logo pb-4">
                <i class="bi bi-megaphone text-2xl px-2 bg-slate-900 text-white rounded py-2"></i>
                <span class="text-2xl font-bold tracking-wider mx-2">REPORT ACCIDENT</span>
                <hr class="mt-4">
            </div>

            <div class="report-table bg-slate-100 p-4 rounded">
                <header class="text-2xl font-semibold">Pending Accident Report</header>
                <table class="table data-table display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th class="w-px">Report ID</th>
                            <th>Report Description</th>
                            <th>Accident Location</th>
                            <th>Contact</th>
                            <th>Email Address</th>
                            <th class="w-4">Status</th>
                            @if (Auth::check() && Auth::user()->user_role == '1')
                                <th class="w-4">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            @guest
                <div class="modal fade" id="createAccidentReportModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-red-900 text-white">
                                <h1 class="modal-title fs-5 text-center text-white">{{ config('app.name') }}</h1>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('report.accident.cdrrmo') }}" method="POST" id="reportForm"
                                    name="reportForm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="report_id" id="report_id">
                                    <div class="mb-3">
                                        <label for="report_description" class="flex items-center justify-center">Report
                                            Description</label>
                                        <input type="text" id="report_description" name="report_description"
                                            class="form-control" placeholder="Enter Incident Description"
                                            autocomplete="off">
                                        <span class="text-danger error-text report_description_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="report_location" class="flex items-center justify-center">Report
                                            Location</label>
                                        <input type="text" id="report_location" name="report_location"
                                            class="form-control" placeholder="Enter Incident Location" autocomplete="off">
                                        <span class="text-danger error-text report_location_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="contact" class="flex items-center justify-center">Contact
                                            Number</label>
                                        <input type="text" id="contact" name="contact" class="form-control"
                                            placeholder="Enter Contact Number" autocomplete="off">
                                        <span class="text-danger error-text contact_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="flex items-center justify-center">Email
                                            Address</label>
                                        <input type="text" id="email" name="email" class="form-control"
                                            placeholder="Enter Email Address" autocomplete="off">
                                        <span class="text-danger error-text email_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="report_photo" class="flex items-center justify-center">Report
                                            Photo</label>
                                        <input type="file" id="report_photo" name="report_photo" class="form-control"
                                            placeholder="Enter Incident Location" autocomplete="off">
                                        <span class="text-danger error-text report_photo_error"></span>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button"
                                            class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit"
                                            class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Report
                                            Accident</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            @endguest
        </div>
        @guest
            <div class="report-button">
                <div class="report-form absolute bottom-7 right-5">
                    <a class="bg-slate-800 hover:bg-slate-900 p-3 fs-4 rounded-full" href="javascript:void(0)"
                        id="createReport">
                        <i class="bi bi-megaphone text-white"></i>
                    </a>
                </div>
            </div>
        @endguest
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>

    @if (Auth::check() && Auth::user()->user_role == '1')
        <script type="text/javascript">
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var table = $('.data-table').DataTable({
                    rowReorder: {
                        selector: 'td:nth-child(2)'
                    },
                    responsive: true,
                    processing: false,
                    serverSide: true,
                    ajax: "{{ route('accident.report.cdrrmo') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'report_description',
                            name: 'report_description'
                        },
                        {
                            data: 'report_location',
                            name: 'report_location'
                        },
                        {
                            data: 'contact',
                            name: 'contact'
                        },
                        {
                            data: 'email',
                            name: 'email'
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

                $('body').on('click', '.approveAccidentReport', function() {
                    var report_id = $(this).data('id');

                    Swal.fire({
                        title: 'Do you want to approve this report?',
                        showDenyButton: true,
                        confirmButtonText: 'Yes, approve it.',
                        confirmButtonColor: '#334155',
                        denyButtonText: `Don't Approve`,
                        denyButtonColor: '#b91c1c',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('approve.accident.report.cdrrmo', ':report_id') }}"
                                    .replace(':report_id', report_id),
                                success: function(data) {
                                    Swal.fire(
                                        "{{ config('app.name') }}",
                                        'Successfully Approved Reported!',
                                        'success'
                                    );
                                    table.draw();
                                },

                                error: function(data) {
                                    Swal.fire(
                                        "{{ config('app.name') }}",
                                        'Failed to approve Accident Report.',
                                        'error'
                                    );
                                    console.log('Error:', data);
                                }
                            });
                        } else if (result.isDenied) {
                            Swal.fire(
                                "{{ config('app.name') }}",
                                'Accident is not already approved!',
                                'info'
                            )
                        }
                    })
                });

                $('body').on('click', '.removeAccidentReport', function() {
                    var report_id = $(this).data("id");

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to undo this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#334155',
                        cancelButtonColor: '#b91c1c',
                        confirmButtonText: 'Yes, delete report!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('remove.accident.report.cdrrmo', ':report_id') }}"
                                    .replace(':report_id', report_id),
                                success: function(data) {
                                    Swal.fire(
                                        "{{ config('app.name') }}",
                                        'Accident Report has been deleted.',
                                        'success'
                                    )
                                    table.draw();
                                },

                                error: function(data) {
                                    "{{ config('app.name') }}",
                                    'Failed to delete Accident Report.',
                                    'error'
                                }
                            });
                        }
                    });
                });
            });
        </script>
    @endif

    @guest
        <script type="text/javascript">
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var table = $('.data-table').DataTable({
                    rowReorder: {
                        selector: 'td:nth-child(2)'
                    },
                    responsive: true,
                    processing: false,
                    serverSide: true,
                    ajax: "{{ route('accident.report.resident') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'report_description',
                            name: 'report_description'
                        },
                        {
                            data: 'report_location',
                            name: 'report_location'
                        },
                        {
                            data: 'contact',
                            name: 'contact'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });

                $('#createReport').click(function() {
                    $('#report_id').val('');
                    $('#reportForm').trigger("reset");
                    $('#createAccidentReportModal').modal('show');
                });

                $('#report_photo').change(function() {
                    let reader = new FileReader();

                    reader.onload = (e) => {
                        $('#preview-image').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(this.files[0]);

                });

                $('#reportForm').submit(function(e) {
                    let formData = new FormData(this);
                    e.preventDefault();

                    Swal.fire({
                        title: 'Do you want to report this accident?',
                        showDenyButton: true,
                        confirmButtonText: 'Yes, report it.',
                        confirmButtonColor: '#334155',
                        denyButtonText: `Double Check`,
                        denyButtonColor: '#b91c1c',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('report.accident.resident') }}",
                                data: formData,
                                contentType: false,
                                processData: false,
                                beforeSend: function(data) {
                                    $(document).find('span.error-text').text('');
                                },
                                success: function(data) {
                                    if (data.condition == 0) {
                                        $.each(data.error, function(prefix, val) {
                                            $('span.' + prefix + '_error').text(val[
                                                0]);
                                        });
                                        Swal.fire(
                                            "{{ config('app.name') }}",
                                            'Failed to Reported Accident, Thanks for your concern!',
                                            'error'
                                        );
                                    } else {
                                        Swal.fire(
                                            "{{ config('app.name') }}",
                                            'Successfully Reported, Thanks for your concern!',
                                            'success'
                                        );
                                        $('#reportForm')[0].reset();
                                        $('#createAccidentReportModal').modal('hide');
                                        table.draw();
                                    }
                                },
                                error: function(data) {
                                    Swal.fire(
                                        "{{ config('app.name') }}",
                                        'Failed to Report Accident, Thanks for your concern!',
                                        'error'
                                    );
                                }
                            });
                        }
                    })
                });
            });
        </script>
    @endguest
</body>

</html>
