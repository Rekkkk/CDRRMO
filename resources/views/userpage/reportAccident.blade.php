<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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
        {{-- @vite(['resources/js/app.js']) --}}

        <x-messages />

        <div class="main-content">
            <div class="dashboard-logo pb-4">
                <i class="bi bi-megaphone text-2xl p-2 bg-slate-600 text-white rounded"></i>
                <span class="text-2xl font-bold tracking-wider mx-2">REPORT ACCIDENT</span>
                <hr class="mt-4">
            </div>

            <div id="result"></div>

            <div class="report-table bg-slate-50 shadow-lg p-4 rounded">
                <header class="text-2xl font-semibold">Pending Accident Report</header>
                <table class="table data-table display nowrap" style="width:100%" id="report-table">
                    <thead>
                        <tr>
                            <th class="w-px">Report ID</th>
                            <th>Report Description</th>
                            <th>Accident Location</th>
                            <th>Actual Photo</th>
                            <th class="w-4">Status</th>
                            @if (auth()->check() && auth()->user()->user_role == 'CDRRMO')
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
                            <div class="modal-header bg-green-600 text-white">
                                <h1 class="modal-title fs-5 text-center text-white">Report Incident Form</h1>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('report.accident.cdrrmo') }}" method="POST" id="reportForm"
                                    name="reportForm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="report_id" id="report_id">
                                    <div class="mb-3">
                                        <label for="description" class="flex items-center justify-center">Report
                                            Description</label>
                                        <input type="text" id="description" name="description" class="form-control"
                                            placeholder="Enter Incident Description" autocomplete="off">
                                        <span class="text-danger error-text description_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="location" class="flex items-center justify-center">Report
                                            Location</label>
                                        <input type="text" id="location" name="location" class="form-control"
                                            placeholder="Enter Incident Location" autocomplete="off">
                                        <span class="text-danger error-text location_error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="photo" class="flex items-center justify-center">Report
                                            Photo</label>
                                        <input type="file" id="photo" name="photo" class="form-control"
                                            placeholder="Enter Incident Location" autocomplete="off">
                                        <span class="text-danger error-text photo_error"></span>
                                    </div>
                                    <div class="modal-footer text-white">
                                        <button type="submit"
                                            class="bg-green-600 p-2 rounded shadow-lg hover:bg-green-700 transition duration-200">Report
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
                    <a class="bg-slate-700 hover:bg-slate-800 p-3 fs-4 rounded-full" href="javascript:void(0)"
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

    @if (auth()->check() && auth()->user()->user_role == 'CDRRMO')
        <script type="text/javascript">
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var report_table = $('.data-table').DataTable({
                    rowReorder: {
                        selector: 'td:nth-child(2)'
                    },
                    responsive: true,
                    processing: false,
                    serverSide: true,
                    ajax: "{{ route('accident.report.cdrrmo') }}",
                    columns: [{
                            data: 'id',
                            name: 'id',
                            visible: false
                        },
                        {
                            data: 'description',
                            name: 'description'
                        },
                        {
                            data: 'location',
                            name: 'location'
                        },
                        {
                            data: 'photo',
                            name: 'photo',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            searchable: false
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
                        title: 'Would you like to approve this report?',
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
                                    Swal.fire({
                                        icon: 'success',
                                        title: "{{ config('app.name') }}",
                                        text: 'Successfully Approved Reported.',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#334155',
                                    });
                                    table.draw();
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

                $('body').on('click', '.removeAccidentReport', function() {
                    var report_id = $(this).data("id");

                    Swal.fire({
                        icon: 'warning',
                        title: 'Are you sure?',
                        text: "You won't be able to undo this!",
                        showCancelButton: true,
                        confirmButtonColor: '#334155',
                        cancelButtonColor: '#b91c1c',
                        confirmButtonText: 'Yes, remove it.'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('remove.accident.report.cdrrmo', ':report_id') }}"
                                    .replace(':report_id', report_id),
                                success: function(data) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: "{{ config('app.name') }}",
                                        text: 'Accident Report has been removed.',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#334155',
                                    });
                                    table.draw();
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

                Echo.channel('report-incident').listen('ReportIncident', (e) => {
                    table.draw();
                })
            });
        </script>
    @endif
    @guest
        <script type="text/javascript">
            $(document).ready(function() {
                var report_table = $('.data-table').DataTable({
                    rowReorder: {
                        selector: 'td:nth-child(2)'
                    },
                    responsive: true,
                    processing: false,
                    serverSide: true,
                    ajax: "{{ route('accident.report.resident') }}",
                    columns: [{
                            data: 'id',
                            name: 'id',
                            visible: false
                        },
                        {
                            data: 'description',
                            name: 'description'
                        },
                        {
                            data: 'location',
                            name: 'location'
                        },
                        {
                            data: 'photo',
                            name: 'photo',
                            orderable: false,
                            searchable: false
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
                        icon: 'question',
                        title: 'Would you like to report this accident?',
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
                                    if (data.condition == 1) {
                                        $.each(data.error, function(prefix, val) {
                                            $('span.' + prefix + '_error').text(val[
                                                0]);
                                        });
                                        Swal.fire({
                                            icon: 'error',
                                            title: "{{ config('app.name') }}",
                                            text: 'Failed to Reported Accident, Thanks for your concern.',
                                            confirmButtonText: 'OK',
                                            confirmButtonColor: '#334155',
                                        });
                                    } else if (data.condition == 2) {
                                        Swal.fire(
                                            "{{ config('app.name') }}",
                                            data.block_time,
                                            'error'
                                        );
                                        $('#reportForm')[0].reset();
                                        $('#createAccidentReportModal').modal('hide');
                                    } else {
                                        Swal.fire({
                                            icon: 'success',
                                            title: "{{ config('app.name') }}",
                                            text: 'Successfully Reported, Thanks for your concern.',
                                            confirmButtonText: 'OK',
                                            confirmButtonColor: '#334155',
                                        });
                                        $('#reportForm')[0].reset();
                                        $('#createAccidentReportModal').modal('hide');
                                        table.draw();
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

                Echo.channel('report-incident').listen('ReportIncident', (e) => {
                    table.draw();
                })
            });
        </script>
    @endguest
</body>

</html>
