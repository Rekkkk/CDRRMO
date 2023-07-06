<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.headPackage')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
</head>

<body>
    <div class="wrapper">
        @include('sweetalert::alert')
        @include('partials.header')
        @include('partials.sidebar')
        <div class="main-content">
            <div class="grid grid-cols-1">
                <div class="grid col-end-1 mr-4">
                    <div class="m-auto">
                        <i class="bi bi-house-gear text-2xl p-2 bg-slate-600 text-white rounded"></i>
                    </div>
                </div>
                <span class="text-xl font-bold tracking-wider">MANAGE EVACUATION CENTER</span>
            </div>
            <hr class="mt-4">
            <div class=" flex justify-end my-3">
                <button class="btn-submit p-2" id="addEvacuationCenter">
                    <i class="bi bi-house-down-fill pr-2"></i>
                    Add Evacuation Center
                </button>
            </div>
            <div class="table-container mt-3 mb-2 p-3 bg-slate-50 shadow-lg flex rounded-lg">
                <div class="block w-full overflow-auto">
                    <header class="text-2xl font-semibold mb-3">Evacuation Centers</header>
                    <table class="table evacuationCenterTable table-striped table-light align-middle"
                        style="width:100%">
                        <thead class="thead-light text-justify">
                            <tr>
                                <th></th>
                                <th>Name</th>
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
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
        integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
        crossorigin="anonymous"></script>
    @include('partials.toastr')
    <script type="text/javascript">
        $(document).ready(function() {
            let evacuationCenterTable = $('.evacuationCenterTable').DataTable({
                order: [
                    [1, 'asc']
                ],
                language: {
                    emptyTable: 'No evacuation center added yet',
                },
                responsive: true,
                processing: false,
                serverSide: true,
                ajax: "{{ route('evacuation.center.get') }}",
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
                $('.modal-header').
                removeClass('bg-yellow-500').
                addClass('bg-green-600');
                $('.modal-title').text('Add Evacuation Center');
                $('#saveEvacuationCenterBtn').
                removeClass('bg-yellow-500').
                addClass('bg-green-600');
                $('#operation').val('Add');
                $('#status-container').hide();
                $('#evacuationCenterModal').modal('show');
                $('#saveEvacuationCenterBtn').text('Add');
            });

            let evacuationCenterId, defaultFormData;

            $(document).on('click', '.updateEvacuationCenter', function(e) {
                $('.modal-header').removeClass('bg-green-600').addClass('bg-yellow-500');
                $('.modal-title').text('Edit Evacuation Center');
                $('#saveEvacuationCenterBtn').removeClass('bg-green-600').addClass('bg-yellow-500');
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
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            type: "DELETE",
                            url: "{{ route('evacuation.center.remove', ':evacuationCenterId') }}"
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

                if (operation == 'Add') {
                    url = "{{ route('evacuation.center.add') }}";
                    type = "POST";
                } else {
                    url = "{{ route('evacuation.center.update', ':evacuationCenterId') }}"
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
                                    if (operation == 'Add') {
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
