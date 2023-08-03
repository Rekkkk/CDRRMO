<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.headPackage')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    {{-- @vite(['resources/js/app.js']) --}}
</head>

<body>
    <div class="wrapper">
        @include('partials.header')
        @include('partials.sidebar')
        <div class="main-content">
            <div class="homepage-header">
                <div class="header-icon">
                    <div class="icon-content">
                        <i class="bi bi-megaphone"></i>
                    </div>
                </div>
                <span>INCIDENT REPORT</span>
            </div>
            <hr>
            <div class="report-table shadow-lg p-4 rounded my-3">
                <div class="block w-full overflow-auto pb-2">
                    <header class="text-2xl font-semibold">Pending Incident Report Table</header>
                    <table class="table pendingReport" style="width:100%">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="2">Description</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Photo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            @guest
                <div class="shadow-lg p-4 rounded my-3">
                    <div class="incidentReportTable grid gap-6">
                        @foreach ($incidentReport as $report)
                            <div class="bg-slate-50 rounded shadow-md">
                                <div class="flex p-4 rounded">
                                    <div class="report-photo-container shadow-md">
                                        <img class="report-photo" src="{{ asset('reports_image/' . $report->photo) }}"
                                            alt="logo">
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="pt-2">
                                            <p class="font-bold">Report Description</p>
                                            <p class="text-sm text-gray-600">{{ $report->description }}</p>
                                        </div>
                                        <div class="py-2">
                                            <p class="font-bold">Report Location</p>
                                            <p class="text-sm text-gray-600">{{ $report->location }}</p>
                                        </div>
                                        <div class="py-2">
                                            <p class="font-bold">Report Status : <span
                                                    class="bg-green-600 status-container">{{ $report->status }}</span>
                                            </p>
                                        </div>
                                        <p class="pb-2 font-bold">Date Reported: <span class="text-red-600">July 22,
                                                2002</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endguest
            @auth
                <div class="report-table shadow-lg p-4 rounded">
                    <div class="block w-full overflow-auto pb-2">
                        <header class="text-2xl font-semibold">Incident Report Table</header>
                        <table class="table incidentReports" style="width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th colspan="2">Description</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Photo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endauth
        </div>
        @guest
            <div class="modal fade" id="createAccidentReportModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-green-600 text-white justify-center">
                            <h1 class="modal-title fs-5 font-bold">Incident Report Form</h1>
                        </div>
                        <div class="modal-body">
                            <form id="reportForm" name="reportForm" enctype="multipart/form-data">
                                @csrf
                                <div class="bg-slate-50 pt-3 pb-2 rounded">
                                    <div class="flex-auto">
                                        <div class="flex flex-wrap">
                                            <input type="text" id="operation" hidden>
                                            <div class="field-container">
                                                <label>Report Description</label>
                                                <textarea type="text" id="description" name="description" class="form-control" rows="5"
                                                    placeholder="Enter Incident Description" autocomplete="off"></textarea>
                                            </div>
                                            <div class="field-container">
                                                <label>Report Location</label>
                                                <input type="text" id="location" name="location" class="form-control"
                                                    placeholder="Enter Incident Location" autocomplete="off">
                                            </div>
                                            <div class="field-container">
                                                <label>Report Photo</label>
                                                <input type="file" id="photo" name="photo"
                                                    class="form-control form-control-lg"
                                                    placeholder="Enter Incident Location" autocomplete="off">
                                            </div>
                                            <div class="w-full px-4 pt-2 pb-3">
                                                <button id="reportIncidentBtn"
                                                    class="btn-submit p-2 float-right">Report</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="report-button">
                <div class="report-form">
                    <a class="bg-slate-700 hover:bg-slate-800 p-3 fs-4 rounded-full" href="#createAccidentReportModal"
                        data-bs-toggle="modal">
                        <i class="bi bi-megaphone text-white"></i>
                    </a>
                </div>
            </div>
        @endguest
        @auth
            @include('userpage.changePasswordModal')
        @endauth
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            @auth
            let pendingReport = $('.pendingReport').DataTable({
                language: {
                    emptyTable: '<div class="no-data">There are currently no pending reports.</div>',
                },
                ordering: false,
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
                        width: '10%',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'photo',
                        name: 'photo',
                        width: '10%',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        width: '1rem',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            let incidentReports = $('.incidentReports').DataTable({
                language: {
                    emptyTable: '<div class="no-data">There are currently no reports.</div>',
                },
                ordering: false,
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
                        width: '1rem',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            @if (auth()->user()->is_disable == 0)
                $(document).on('click', '.approveIncidentReport', function() {
                    alterIncidentReport('approve', getRowData(this, pendingReport).id);
                });

                $(document).on('click', '.declineIncidentReport', function() {
                    alterIncidentReport('decline', getRowData(this, pendingReport).id);
                });

                $(document).on('click', '.removeIncidentReport', function() {
                    alterIncidentReport('remove', getRowData(this, incidentReports).id);
                });

                function alterIncidentReport(operation, reportId) {
                    confirmModal(`Do you want to ${operation} this report?`).then((result) => {
                        if (result.isConfirmed) {
                            let url = operation == 'approve' ? "{{ route('report.approve', ':reportId') }}"
                                .replace(':reportId',
                                    reportId) : operation == 'decline' ?
                                "{{ route('report.decline', ':reportId') }}".replace(':reportId',
                                    reportId) : "{{ route('report.remove', ':reportId') }}".replace(
                                    ':reportId', reportId);

                            let type = operation == 'approve' ? "POST" : operation == 'decline' ? "DELETE" :
                                "PATCH";

                            $.ajax({
                                type: type,
                                url: url,
                                success: function() {
                                    showSuccessMessage(
                                        `Incident report successfully ${operation}d.`);
                                    pendingReport.draw();
                                    incidentReports.draw();
                                },
                                error: function() {
                                    showErrorMessage();
                                }
                            });
                        }
                    });
                }
            @endif
        @endauth
        @guest
        let pendingReport = $('.pendingReport').DataTable({
            language: {
                emptyTable: '<div class="no-data">You have no pending reports.</div>',
            },
            ordering: false,
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
                    width: '10%',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'photo',
                    name: 'photo',
                    width: '10%',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    width: '1rem',
                    orderable: false,
                    searchable: false
                },
            ]
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
                description: 'required',
                location: 'required'
            },
            messages: {
                description: 'Please Enter Incident Description.',
                location: 'Please Enter Incident Location.'
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
                        success: function(response) {
                            if (response.status == 'success') {
                                showSuccessMessage(
                                    'Successfully reported, Thank for your concern.');
                                $('#reportForm')[0].reset();
                                $('#createAccidentReportModal').modal('hide');
                                pendingReport.draw();
                            } else if (response.status == 'warning') {
                                showWarningMessage(response.message);
                            } else if (response.status == 'blocked') {
                                $('#reportForm')[0].reset();
                                $('#createAccidentReportModal').modal('hide');
                                showWarningMessage(response.message);
                            }
                        },
                        error: function() {
                            showErrorMessage();
                        }
                    });
                }
            });
        }

        $(document).on('click', '.revertIncidentReport', function() {
            let reportId = getRowData(this, pendingReport).id;

            confirmModal('Do you want to revert your report?').then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('resident.report.revert', ':reportId') }}"
                            .replace(':reportId', reportId),
                        success: function() {
                            revertReport(reportId);
                        },
                        error: function() {
                            showErrorMessage();
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
                success: function() {
                    showSuccessMessage('Incident report successfully reverted.');
                    pendingReport.draw();
                },
                error: function() {
                    showErrorMessage();
                }
            });
        }

        $('#createAccidentReportModal').on('hidden.bs.modal', function() {
            validator.resetForm();
        });
        @endguest

        // Echo.channel('incident-report').listen('IncidentReport', (e) => {
        //     pendingReport.draw();
        //     incidentReports.draw();
        // })
        });
    </script>
</body>

</html>
