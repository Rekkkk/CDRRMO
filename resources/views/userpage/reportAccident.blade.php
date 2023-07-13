<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.headPackage')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
</head>

<body>
    <div class="wrapper">
        @include('sweetalert::alert')
        @include('partials.header')
        @include('partials.sidebar')
        {{-- @vite(['resources/js/app.js']) --}}
        <div class="main-content">
            <div class="grid grid-cols-1">
                <div class="grid col-end-1 mr-4">
                    <div class="text-2xl text-white">
                        <i class="bi bi-megaphone p-2 bg-slate-600 rounded"></i>
                    </div>
                </div>
                <span class="text-xl font-bold tracking-wider">REPORT INCIDENT</span>
            </div>
            <hr class="mt-3">
            <div class="report-table bg-slate-50 shadow-lg p-4 rounded my-4">
                <header class="text-2xl font-semibold">Pending Accident Report</header>
                <table class="table pendingReport display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th class="w-px">Report ID</th>
                            <th>Report Description</th>
                            <th>Accident Location</th>
                            <th class="w-5">Status</th>
                            <th style="width:20%;">Actual Photo</th>
                            <th class="w-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="report-table bg-slate-50 shadow-lg p-4 rounded mb-4">
                <header class="text-2xl font-semibold">Incident Report</header>
                <table class="table incidentReports display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th class="w-px">Report ID</th>
                            <th>Report Description</th>
                            <th>Accident Location</th>
                            <th class="w-5">Status</th>
                            <th style="width:20%;">Actual Photo</th>
                            @can('removeReport', \App\Models\User::class)
                                <th class="w-4">Action</th>
                            @endcan
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
                                <form id="reportForm" name="reportForm" enctype="multipart/form-data">
                                    @csrf
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
                                        <button id="reportIncidentBtn"
                                            class="bg-green-600 p-2 rounded shadow-lg hover:bg-green-700 transition duration-200">Report
                                            Incident</button>
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
                <div class="report-form">
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
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    @include('partials.toastr')
    @can('approveOrDecline', \App\Models\User::class)
        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let pendingReport = $('.pendingReport').DataTable({
                    rowReorder: {
                        selector: 'td:nth-child(2)'
                    },
                    responsive: true,
                    processing: false,
                    serverSide: true,
                    ajax: "{{ route('report.pending') }}",
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
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'photo',
                            name: 'photo',
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

                let incidentReports = $('.incidentReports').DataTable({
                    rowReorder: {
                        selector: 'td:nth-child(2)'
                    },
                    responsive: true,
                    processing: false,
                    serverSide: true,
                    ajax: "{{ route('report.accident') }}",
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
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'photo',
                            name: 'photo',
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

                $('body').on('click', '.approveIncidentReport', function() {
                    let reportId = $(this).data('id');

                    confirmModal('Do you want to approve this report incident?').then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('report.approve', ':reportId') }}"
                                    .replace(':reportId', reportId),
                                success: function(response) {
                                    if (response.status == 0) {
                                        messageModal('Warning',
                                            'Failed to approve report incident, Try again.',
                                            'warning', '#FFDF00');
                                    } else {
                                        messageModal('Success',
                                            'Successfully Approved Reported.',
                                            'success', '#3CB043').then(() => {
                                            pendingReport.draw();
                                            incidentReports.draw();
                                        });
                                    }
                                },
                                error: function() {
                                    messageModal('Warning',
                                        'Something went wrong, try again later.',
                                        '#FFDF00');
                                }
                            });
                        }
                    });
                });

                $('body').on('click', '.declineIncidentReport', function() {
                    let reportId = $(this).data('id');

                    confirmModal('Do you want to decline this report incident?').then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('report.decline', ':reportId') }}"
                                    .replace(':reportId', reportId),
                                success: function(response) {
                                    if (response.status == 0) {
                                        messageModal('Warning',
                                            'Failed to decline report incident, Try again.',
                                            'error', '#FFDF00');
                                    } else {
                                        messageModal('Success',
                                            'Successfully Declined Reported.',
                                            'success', '#3CB043').then(() => {
                                            pendingReport.draw();
                                            incidentReports.draw();
                                        });
                                    }
                                },
                                error: function() {
                                    messageModal('Warning',
                                        'Something went wrong, try again later.',
                                        'error', '#FFDF00');
                                }
                            });
                        }
                    });
                });

                $('body').on('click', '.archiveIncidentReport', function() {
                    let reportId = $(this).data('id');

                    confirmModal('Do you want to archive this report incident?').then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "PUT",
                                url: "{{ route('report.archive', ':reportId') }}"
                                    .replace(':reportId', reportId),
                                success: function(response) {
                                    if (response.status == 0) {
                                        messageModal('Warning',
                                            'Failed to archive report incident, Try again.',
                                            'warning', '#FFDF00');
                                    } else {
                                        messageModal('Success',
                                            'Successfully archived Accident Report.',
                                            'success', '#3CB043').then(() => {
                                            incidentReports.draw();
                                        });
                                    }
                                },
                                error: function() {
                                    messageModal('Warning',
                                        'Something went wrong, try again later.',
                                        '#FFDF00');
                                }
                            });
                        }
                    });
                });

                // Echo.channel('report-incident').listen('ReportIncident', (e) => {
                //     table.draw();
                // })
            });
        </script>
    @endcan
    @guest
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
            integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
            crossorigin="anonymous"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let pendingReport = $('.pendingReport').DataTable({
                    rowReorder: {
                        selector: 'td:nth-child(2)'
                    },
                    responsive: true,
                    processing: false,
                    serverSide: true,
                    ajax: "{{ route('resident.report.pending') }}",
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
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'photo',
                            name: 'photo',
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

                let incidentReports = $('.incidentReports').DataTable({
                    rowReorder: {
                        selector: 'td:nth-child(2)'
                    },
                    responsive: true,
                    processing: false,
                    serverSide: true,
                    ajax: "{{ route('resident.report.display') }}",
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
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'photo',
                            name: 'photo',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });

                $('#createReport').click(function() {
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

                let validator = $("#reportForm").validate({
                    rules: {
                        description: {
                            required: true
                        },
                        location: {
                            required: true
                        },
                        photo: {
                            required: true
                        }
                    },
                    messages: {
                        description: {
                            required: 'Please Enter Incident Description.'
                        },
                        location: {
                            required: 'Please Enter Incident Location.'
                        },
                        photo: {
                            required: 'Please Provide Atleast 1 Actual Photo.'
                        }
                    },
                    errorElement: 'span',
                    submitHandler: formSubmitHandler,
                });

                function formSubmitHandler(form, e) {
                    let formData = new FormData(form);
                    e.preventDefault();

                    confirmModal('Do you want to report this incident?').then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('resident.report.accident') }}",
                                data: formData,
                                contentType: false,
                                processData: false,
                                beforeSend: function(response) {
                                    $(document).find('span.error-text').text('');
                                },
                                success: function(response) {
                                    if (response.status == 1) {
                                        $.each(response.error, function(prefix, val) {
                                            $('span.' + prefix + '_error').text(val[
                                                0]);
                                        });
                                        messageModal('Warning',
                                            'Failed to Reported Incident, Thanks for your concern.',
                                            'error', '#FFDF00');
                                    } else if (response.status == 2) {
                                        messageModal("You've been Blocked", response.block_time,
                                            'warning', '#FFDF00').then(() => {
                                            $('#reportForm')[0].reset();
                                            $('#createAccidentReportModal').modal('hide');
                                        });
                                    } else {
                                        messageModal('Success',
                                            'Successfully Reported, Thanks for your concern.',
                                            'success', '#3CB043').then(() => {
                                            $('#reportForm')[0].reset();
                                            $('#createAccidentReportModal').modal('hide');
                                            pendingReport.draw();
                                        });
                                    }
                                },
                                error: function() {
                                    messageModal('Warning',
                                        'Something went wrong, try again later.', 'error',
                                        '#FFDF00');
                                }
                            });
                        }
                    });
                }

                $('body').on('click', '.revertIncidentReport', function() {
                    let reportId = $(this).data('id');

                    confirmModal('Do you want to revert your report?').then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('resident.report.revert', ':reportId') }}"
                                    .replace(':reportId', reportId),
                                success: function(response) {
                                    if (response.status == 0) {
                                        messageModal('Warning',
                                            'Failed to revert your report, Try again.',
                                            'warning', '#FFDF00');
                                    } else {
                                        revertReport(reportId);
                                    }
                                },
                                error: function() {
                                    messageModal('Warning',
                                        'Something went wrong, try again later.',
                                        'warning',
                                        '#FFDF00');
                                }
                            });
                        }
                    });
                });

                function revertReport(reportId) {
                    $.ajax({
                        type: "PUT",
                        url: "{{ route('resident.report.update', ':reportId') }}".replace(':reportId',
                            reportId),
                        success: function(response) {
                            if (response.status == 0) {
                                messageModal('Warning', 'Failed to revert your repdasdasort, Try again.',
                                    'warning', '#FFDF00');
                            } else {
                                messageModal('Success', 'Successfully Reverted Report.', 'success',
                                    '#3CB043').then(() => {
                                    pendingReport.draw();
                                });
                            }
                        },
                        error: function() {
                            messageModal('Warning', 'Something went wrong, try again later.', 'warning',
                                '#FFDF00');
                        }
                    });
                }

                $('#createAccidentReportModal').on('hidden.bs.modal', function() {
                    validator.resetForm();
                });

                // Echo.channel('report-incident').listen('ReportIncident', (e) => {
                //     table.draw();
                // })
            });
        </script>
    @endguest
</body>

</html>
