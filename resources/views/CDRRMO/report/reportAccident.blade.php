<!DOCTYPE html>
<html lang="en">
    <head>
        @include('partials.content.headPackage')
        <link rel="stylesheet" href="{{ asset('assets/css/report-css/report.css') }}">
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

            <div class="main-content">
                <div class="dashboard-logo pb-4">
                    <i class="bi bi-megaphone text-2xl px-2 bg-slate-900 text-white rounded py-2"></i>
                    <span class="text-2xl font-bold tracking-wider mx-2">REPORT ACCIDENT</span>
                    <hr class="mt-4">
                </div>

                <div class="report-table bg-slate-100 p-4 rounded">
                    <header class="text-2xl font-semibold">Report Table</header>
                    <table class="table  data-table display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Report ID</th>
                                <th>Report Description</th>
                                <th>Location</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                
                <div class="modal fade" id="ajaxModel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-red-900 text-white">
                                <h4 class="modal-title" id="modalHeading"></h4>
                            </div>
                            <div class="modal-body">
                                <form id="reportForm" name="reportForm" class="form-horizontal">
                                    <input type="hidden" name="report_id" id="report_id">
                                    <div class="mb-3">
                                        <label for="report_description" class="flex items-center justify-center">Report Description</label>
                                        <input type="text" id="report_description" name="report_description" class="form-control" placeholder="Enter Incedent Description" autocomplete="off">
                                    </div>
                                    <div class="mb-3">
                                        <label for="report_location" class="flex items-center justify-center">Report Location</label>
                                        <input type="text" id="report_location" name="report_location" class="form-control" placeholder="Enter Incident Location" autocomplete="off">
                                    </div>
                                    <div class="mb-3">
                                        <label for="Contact" class="flex items-center justify-center">Concern Resident Contact</label>
                                        <input type="text" id="contact" name="contact" class="form-control" placeholder="Enter Concern Resident Contact" autocomplete="off">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="flex items-center justify-center">Concern Resident Email</label>
                                        <input type="text" id="email" name="email" class="form-control" placeholder="Enter Concern Resident Email" autocomplete="off">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" id="saveBtn" value="create" class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Report Accident</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="report-button">
                <div class="report-form absolute bottom-7 right-5">
                    <a class="bg-slate-700 hover:bg-slate-900 p-3 fs-4 rounded-full" href="javascript:void(0)" id="createReport">
                        <i class="bi bi-megaphone text-white"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <script src="{{ asset('assets/js/landingPage.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        
        @auth
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
                    ajax: "{{ route('CdisplayReport') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'report_description', name: 'report_description'},
                        {data: 'report_location', name: 'report_location'},
                        {data: 'contact', name: 'contact'},
                        {data: 'email', name: 'email'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });

                $('#createReport').click(function () {
                    $('#saveBtn').val("create-report");
                    $('#report_id').val('');
                    $('#reportForm').trigger("reset");
                    $('#modalHeading').html("{{ config('app.name') }}");
                    $('#ajaxModel').modal('show');
                });

                // $('body').on('click', '.updateReport', function () {
                //     var report_id = $(this).data('id');
                //     $.get("{{ route('CdisplayReport') }}" +'/' + report_id +'/edit', function (data) {
                //         $('#modalHeading').html("{{ config('app.name') }}");
                //         $('#saveBtn').val("edit-report");
                //         $('#ajaxModel').modal('show');
                //         $('#report_id').val(data.report_id);
                //         $('#report_description').val(data.report_description);
                //         $('#report_location').val(data.report_location);
                //         $('#contact').val(data.contact);
                //         $('#email').val(data.email);
                //     })
                //  });

                $('#saveBtn').click(function (e) {
                    e.preventDefault();
                    $(this).html('Save');

                    Swal.fire({
                        title: 'Do you want to report this accident?',
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Report',
                        denyButtonText: `Don't Report`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(
                                "{{ config('app.name') }}", 
                                'Successfully Reported, Thanks for your concern!', 
                                'success',
                            );
                            $.ajax({
                                data: $('#reportForm').serialize(),
                                url: "{{ route('CaddReport') }}",
                                type: "POST",
                                dataType: 'json',

                                success: function (data) {
                                    $('#reportForm').trigger("reset");
                                    $('#ajaxModel').modal('hide');
                                    table.draw();
                                },

                                error: function (data) {
                                    console.log('Error:', data);
                                    $('#saveBtn').html('Save Changes');
                                }
                            });
                        } else if (result.isDenied) {
                            Swal.fire(
                                "{{ config('app.name') }}", 
                                'Report Accident is not already reported!', 
                                'info')
                        }
                    })
                });

                $('body').on('click', '.removeReport', function () {
                    var report_id = $(this).data("id");
                    
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to undo this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete report!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(
                                'Deleted!',
                                'Report has been deleted.',
                                'success'
                            )
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('CremoveReport', ':report_id') }}".replace(':report_id', report_id),
                                success: function (data) {
                                    table.draw();
                                },
                                error: function (data) {
                                    console.log('Error:', data);
                                }
                            });
                        }
                    });
                });
            });
        </script>
        @endauth

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
                    ajax: "{{ route('GdisplayReport') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'report_description', name: 'report_description'},
                        {data: 'report_location', name: 'report_location'},
                        {data: 'contact', name: 'contact'},
                        {data: 'email', name: 'email'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });

                $('#createReport').click(function () {
                    $('#saveBtn').val("create-report");
                    $('#report_id').val('');
                    $('#reportForm').trigger("reset");
                    $('#modalHeading').html("{{ config('app.name') }}");
                    $('#ajaxModel').modal('show');
                });
               
                $('#saveBtn').click(function (e) {
                    e.preventDefault();
                    $(this).html('Save');

                    Swal.fire({
                        title: 'Do you want to report this accident?',
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Report',
                        denyButtonText: `Don't Report`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(
                                "{{ config('app.name') }}", 
                                'Successfully Reported, Thanks for your concern!', 
                                'success',
                            );
                            $.ajax({
                                data: $('#reportForm').serialize(),
                                url: "{{ route('CaddReport') }}",
                                type: "POST",
                                dataType: 'json',

                                success: function (data) {
                                    $('#reportForm').trigger("reset");
                                    $('#ajaxModel').modal('hide');
                                    table.draw();
                                },

                                error: function (data) {
                                    console.log('Error:', data);
                                    $('#saveBtn').html('Save Changes');
                                }
                            });
                        } else if (result.isDenied) {
                            Swal.fire(
                                "{{ config('app.name') }}", 
                                'Report Accident is not already reported!', 
                                'info')
                        }
                    })
                });
            });
        </script>
        @endguest
    </body>
</html>