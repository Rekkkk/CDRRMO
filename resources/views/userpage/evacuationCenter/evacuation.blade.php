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
        <x-messages />
        <div class="main-content">
            <div class="grid grid-cols-1">
                <div class="grid col-end-1 mr-4">
                    <div class="m-auto">
                        <i class="bi bi-house-gear text-2xl p-2 bg-slate-600 text-white rounded"></i>
                    </div>
                </div>
                <div>
                    <span class="text-xl font-bold tracking-wider">EVACUATION CENTER</span>
                </div>
            </div>
            <hr class="mt-4">
            <div class="flex justify-end my-3">
                <button class="btn-submit p-2" id="addEvacuationCenter">
                    <i class="bi bi-house-down-fill pr-2"></i>
                    Add Evacuation Center
                </button>
            </div>
            <div class="evacuation-content flex bg-slate-50 shadow-lg p-3">
                <div class="evacuation-table w-full relative">
                    <header class="text-2xl font-semibold">Evacuation Center Table</header>
                    <table class="table evacuationCenterTable display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Evacuation Center Name</th>
                                <th>Barangay</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Status</th>
                                <th class="w-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            @include('userpage.evacuationCenter.evacuationCenterModal')
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
        integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
        crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            let evacuationCenterId, defaultFormData;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let evacuationCenterTable = $('.evacuationCenterTable').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                processing: false,
                serverSide: true,
                ajax: "{{ route('evacuation.center.cswd') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        visible: false
                    }, {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'barangay_name',
                        name: 'barangay_name'
                    },
                    {
                        data: 'latitude',
                        name: 'latitude'
                    },
                    {
                        data: 'longitude',
                        name: 'longitude'
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
                    }
                ]
            });

            $('#addEvacuationCenter').click(function() {
                $('.modal-header').removeClass('bg-yellow-500').addClass('bg-green-600');
                $('.modal-title').text('Create Evacuation Center Form');
                $('#saveEvacuationCenterBtn').removeClass('btn-edit').addClass('btn-submit');
                $('#operation').val('create');
                $('#status-container').hide();
                $('#evacuationCenterModal').modal('show');
                $('#saveEvacuationCenterBtn').text('Create');
            });

            $(document).on('click', '.updateEvacuationCenter', function(e) {
                $('.modal-header').removeClass('bg-green-600').addClass('bg-yellow-500');
                $('.modal-title').text('Edit Evacuation Center Form');
                $('#saveEvacuationCenterBtn').removeClass('btn-submit').addClass('btn-edit');
                $('#saveEvacuationCenterBtn').text('Update');

                let currentRow = $(this).closest('tr');

                if (evacuationCenterTable.responsive.hasHidden())
                    currentRow = currentRow.prev('tr');

                let data = evacuationCenterTable.row(currentRow).data();
                evacuationCenterId = data['id'];
                $('#name').val(data['name']);
                $('#barangay_name').val(data['barangay_name']);
                $('#latitude').val(data['latitude']);
                $('#longitude').val(data['longitude']);
                $('#status').val(data['status']);
                $('#operation').val('update');
                $('#evacuationCenterModal').modal('show');
                defaultFormData = $('#evacuationCenterForm').serialize();
            });

            $(document).on('click', '.removeEvacuationCenter', function() {
                evacuationCenterId = $(this).data('id');

                confirmModal('Do you want to remove this evacuation center?').then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('remove.evacuation.center.cswd', ':evacuationCenterId') }}"
                                .replace(':evacuationCenterId', evacuationCenterId),
                            success: function(response) {
                                if (response.status == 0) {
                                    messageModal(
                                        'Warning',
                                        'Failed to remove evacuation center.',
                                        'warning',
                                        '#FFDF00'
                                    );
                                } else {
                                    Swal.fire(
                                        'Success',
                                        'Successfully removed evacuation center.',
                                        'success'
                                    );

                                    evacuationCenterTable.draw();
                                }
                            },
                            error: function() {
                                messageModal(
                                    'Warning',
                                    'Something went wrong, Try again later.',
                                    'warning',
                                    '#FFDF00'
                                );
                            }
                        });
                    }
                });
            });

            let validator = $("#evacuationCenterForm").validate({
                rules: {
                    name: {
                        required: true
                    },
                    barangay_name: {
                        required: true
                    },
                    latitude: {
                        required: true
                    },
                    longitude: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: 'Please Enter Evacuation Center Name.'
                    },
                    barangay_name: {
                        required: 'Please Enter Barangay Name.'
                    },
                    latitude: {
                        required: 'Please Enter Latitude.'
                    },
                    longitude: {
                        required: 'Please Enter Longitude.'
                    }
                },
                errorElement: 'span',
                submitHandler: formSubmitHandler,
            });

            function formSubmitHandler(form) {
                let operation = $('#operation').val(),
                    url = "",
                    type = "",
                    formData = $(form).serialize(),
                    modal = $('#evacuationCenterModal');

                if (operation == 'create') {
                    url = "{{ route('register.evacuation.center.cswd') }}";
                    type = "POST";
                } else {
                    url = "{{ route('update.evacuation.center.cswd', ':evacuationCenterId') }}"
                        .replace(':evacuationCenterId', evacuationCenterId),
                        type = "PUT";
                }

                confirmModal(`Do you want to ${operation} this user details?`).then((result) => {
                    if (result.isConfirmed) {
                        if (operation == 'update' && defaultFormData == formData) {
                            modal.modal('hide');
                            messageModal(
                                'Info',
                                'No changes were made.',
                                'info',
                                '#B91C1C'
                            );
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
                                    messageModal(
                                        'Warning',
                                        `Failed to ${operation} user details.`,
                                        'warning',
                                        '#FFDF00'
                                    );
                                } else {
                                    if (operation == 'create') {
                                        Swal.fire(
                                            'Success',
                                            `Successfully ${operation}d new evacuation center.`,
                                            'success'
                                        )
                                    } else {
                                        messageModal(
                                            'Success',
                                            `Successfully ${operation}d the evacuation center information.`,
                                            'success',
                                            '#3CB043'
                                        );
                                    }

                                    modal.modal('hide');
                                    evacuationCenterTable.draw();
                                }
                            },
                            error: function() {
                                modal.modal('hide');
                                messageModal(
                                    'Warning',
                                    'Something went wrong, Try again later.',
                                    'warning',
                                    '#FFDF00'
                                );
                            }
                        });
                    }
                });
            }

            $('#evacuationCenterModal').on('hidden.bs.modal', function() {
                validator.resetForm();
                $('#status-container').show();
                $('#evacuationCenterForm')[0].reset();
            });
        });
    </script>
</body>

</html>
