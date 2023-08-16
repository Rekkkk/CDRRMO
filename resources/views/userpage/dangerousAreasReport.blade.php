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
            <div class="label-container">
                <div class="icon-container">
                    <div class="icon-content">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                </div>
                <span>DANGEROUS AREAS REPORTS</span>
            </div>
            <hr>
            <div class="table-container">
                <div class="table-content">
                    <header class="table-label">Dangerous Areas Report Table</header>
                    <table class="table dangerousAreasReports" width="100%">
                        <thead>
                            <tr>
                                <th colspan="2">Description</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            @guest
                <div class="modal fade" id="reportDangerousAreaModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-label-container bg-success">
                                <h1 class="modal-label">Report Dangerous Area</h1>
                            </div>
                            <div class="modal-body">
                                <form id="dangerousAreaReportForm">
                                    @csrf
                                    <div class="form-content">
                                        <div class="field-container">
                                            <label>Report Type</label>
                                            <select name="report_type" id="report_type" class="form-select">
                                                <option value="" hidden selected disabled>Select Report Type</option>
                                                <option value="Flooded Area">Flooded Area</option>
                                            </select>
                                        </div>
                                        <div class="field-container">
                                            <label>Report Location</label>
                                            <input type="text" id="location" name="location" class="form-control"
                                                placeholder="Enter Incident Location" autocomplete="off">
                                        </div>
                                        <div class="form-button-container">
                                            <button id="reportDangerousAreaBtn" class="btn-submit">Report</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="report-button">
                    <div class="report-form">
                        <a href="#reportDangerousAreaModal" data-bs-toggle="modal">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </div>
                </div>
            @endguest
            @auth
                @include('userpage.changePasswordModal')
            @endauth
        </div>

        @include('partials.script')
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
            $(document).ready(() => {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                @auth
                let dangerousAreasReports = $('.dangerousAreasReports').DataTable({
                    language: {
                        emptyTable: '<div class="message-text">There are currently no dangerous areas reports.</div>',
                    },
                    ordering: false,
                    responsive: true,
                    processing: false,
                    serverSide: true,
                    ajax: "{{ route('report.dangerous.areas.cswd') }}",
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
                            data: 'action',
                            name: 'action',
                            width: '1rem',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });

                @if (auth()->user()->is_disable == 0)
                    $(document).on('click', '.confirmDangerAreaReport', function() {
                        alterIncidentReport('confirm', getRowData(this, dangerousAreasReports).id);
                    });

                    $(document).on('click', '.rejectDangerAreaReport', function() {
                        alterIncidentReport('reject', getRowData(this, dangerousAreasReports).id);
                    });

                    $(document).on('click', '.removeDangerAreaReport', function() {
                        alterIncidentReport('remove', getRowData(this, dangerousAreasReports).id);
                    });

                    function alterIncidentReport(operation, dangerAreaId) {
                        confirmModal(`Do you want to ${operation} this report?`).then((result) => {
                            if (result.isConfirmed) {
                                let url = operation == 'confirm' ?
                                    "{{ route('report.dangerous.areas.confirm', 'dangerAreaId') }}"
                                    .replace('dangerAreaId', dangerAreaId) : operation == 'reject' ?
                                    "{{ route('report.dangerous.areas.reject', 'dangerAreaId') }}".replace(
                                        'dangerAreaId', dangerAreaId) :
                                    "{{ route('report.dangerous.areas.remove', 'dangerAreaId') }}".replace(
                                        'dangerAreaId', dangerAreaId);
                                let type = operation == 'confirm' ? "POST" : operation == "reject" ? "DELETE" :
                                    "PATCH";

                                $.ajax({
                                    type: type,
                                    url: url,
                                    success() {
                                        showSuccessMessage(
                                            `Danger area successfully ${operation}ed.`);
                                        dangerousAreasReports.draw();
                                    },
                                    error() {
                                        showErrorMessage();
                                    }
                                });
                            }
                        });
                    }
                @endif
            @endauth
            @guest
            const modal = $('#reportDangerousAreaModal');

            let dangerousAreasReports = $('.dangerousAreasReports').DataTable({
                language: {
                    emptyTable: '<div class="message-text">There are currently no dangerous areas reports.</div>',
                },
                ordering: false,
                responsive: true,
                processing: false,
                serverSide: true,
                ajax: "{{ route('resident.report.danger.areas') }}",
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
                        data: 'action',
                        name: 'action',
                        width: '1rem',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            const validator = $("#dangerousAreaReportForm").validate({
                rules: {
                    report_type: 'required',
                    location: 'required'
                },
                messages: {
                    report_type: 'Please Select Report Type.',
                    location: 'Please Enter Report Location.'
                },
                errorElement: 'span',
                submitHandler: formSubmitHandler
            });

            function formSubmitHandler(form, e) {
                e.preventDefault();

                confirmModal('Do you want to report as dangerous this area?').then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('resident.report.dangerous.area') }}",
                            data: $(form).serialize(),
                            success(response) {
                                if (response.status == 'warning') {
                                    showWarningMessage(response.message);
                                } else if (response.status == 'blocked') {
                                    $('#dangerousAreaReportForm')[0].reset();
                                    modal.modal('hide');
                                    showWarningMessage(response.message);
                                } else {
                                    showSuccessMessage('Danger area successfully reported.');
                                    $('#dangerousAreaReportForm')[0].reset();
                                    modal.modal('hide');
                                    dangerousAreasReports.draw();
                                }
                            },
                            error() {
                                showErrorMessage();
                            }
                        });
                    }
                });
            }

            $(document).on('click', '#revertDangerousAreaReport', function() {
                let dangerAreaId = getRowData(this, dangerousAreasReports).id;

                confirmModal('Do you want to revert your report?').then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('resident.report.revert.danger.area.report', ':dangerAreaId') }}"
                                .replace(':dangerAreaId', dangerAreaId),
                            success: function() {
                                revertDangerAreaReport(dangerAreaId);
                            },
                            error: function() {
                                showErrorMessage();
                            }
                        });
                    }
                });
            });

            function revertDangerAreaReport(dangerAreaId) {
                $.ajax({
                    type: "PATCH",
                    url: "{{ route('resident.report.update', 'dangerAreaId') }}".replace(
                        'dangerAreaId', dangerAreaId),
                    success() {
                        showSuccessMessage('Danger area report successfully reverted.');
                        dangerousAreasReports.draw();
                    },
                    error() {
                        showErrorMessage();
                    }
                });
            }

            modal.on('hidden.bs.modal', () => {
                validator.resetForm();
            });
            @endguest

            // Echo.channel('incident-report').listen('IncidentReport', (e) => {
            // pendingReport.draw();
            // incidentReports.draw();
            // })
            });
        </script>
</body>

</html>
