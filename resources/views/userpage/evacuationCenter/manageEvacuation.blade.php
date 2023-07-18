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
                    <div class="text-2xl text-white">
                        <i class="bi bi-house-gear p-2 bg-slate-600 rounded-md"></i>
                    </div>
                </div>
                <span class="text-xl font-bold">MANAGE EVACUATION CENTER</span>
            </div>
            <hr class="mt-4">
            <div class="flex justify-end my-3">
                <button class="btn-submit p-2" id="addEvacuationCenter">
                    <i class="bi bi-house-down-fill pr-2"></i>
                    Create Evacuation Center
                </button>
            </div>
            <div class="table-container p-3 bg-slate-50 shadow-lg rounded-lg">
                <div class="block w-full overflow-auto">
                    <header class="text-2xl font-semibold mb-3">Evacuation Centers</header>
                    <table class="table evacuationCenterTable table-striped table-light" width="100%">
                        <thead class="thead-light">
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Barangay</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Status</th>
                                <th>Action</th>
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
    <script defer
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.googleMap.key') }}&callback=initMap&v=weekly">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
        integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
        crossorigin="anonymous"></script>
    @include('partials.toastr')
    <script type="text/javascript">
        let map, marker, saveBtnClicked = false;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: 14.2471423,
                    lng: 121.1366715
                },
                zoom: 13,
                clickableIcons: false,
            });

            map.addListener("click", (event) => {
                let location = event.latLng;

                if (marker) {
                    marker.setMap(null);
                }

                marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    icon: {
                        url: "{{ asset('assets/img/evacMarkerDefault.png') }}",
                        scaledSize: new google.maps.Size(35, 35),
                    },
                });

                $('input[name="latitude"]').val(location.lat());
                $('input[name="longitude"]').val(location.lng());
                $('#location-error').hide();
            });
        }

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
                        name: 'latitude',
                        visible: false
                    },
                    {
                        data: 'longitude',
                        name: 'longitude',
                        visible: false
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '4px'
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
                $('#evacuationCenterModal').modal('show');
                $('#saveEvacuationCenterBtn').text('Add');
            });

            function getRowData(element) {
                let currentRow = $(element).closest('tr');

                if (evacuationCenterTable.responsive.hasHidden()) {
                    currentRow = currentRow.prev('tr');
                }

                return evacuationCenterTable.row(currentRow).data();
            }

            let evacuationCenterId, defaultFormData, status;

            $(document).on('click', '.updateEvacuationCenter', function() {
                $('.modal-header').
                removeClass('bg-green-600').
                addClass('bg-yellow-500');
                $('.modal-title').text('Edit Evacuation Center');
                $('#saveEvacuationCenterBtn').
                removeClass('bg-green-600').
                addClass('bg-yellow-500');
                $('#saveEvacuationCenterBtn').text('Save');

                let data = getRowData(this);

                evacuationCenterId = data['id'];
                $('input[name="name"]').val(data['name']);
                $(`input[name="barangayName"], option[value="${data['barangay_name']}"`).
                prop('selected', true);

                marker = new google.maps.Marker({
                    position: {
                        lat: parseFloat(data['latitude']),
                        lng: parseFloat(data['longitude'])
                    },
                    map: map,
                    icon: {
                        url: "{{ asset('assets/img/evacMarkerDefault.png') }}",
                        scaledSize: new google.maps.Size(35, 35),
                    },
                });

                $('input[name="latitude"]').val(data['latitude']);
                $('input[name="longitude"]').val(data['longitude']);
                $('#operation').val('update');
                $('#evacuationCenterModal').modal('show');
                defaultFormData = $('#evacuationCenterForm').serialize();
            });

            $(document).on('click', '.removeEvacuationCenter', function() {
                evacuationCenterId = getRowData(this)['id'];

                confirmModalSubmitHandler('remove');
            })

            $(document).on('change', '.changeEvacuationStatus', function() {
                evacuationCenterId = getRowData(this)['id'];

                status = $(this).val();

                confirmModalSubmitHandler('change status');
            })

            $('#saveEvacuationCenterBtn').click(() => {
                saveBtnClicked = true;
            });

            let validator = $("#evacuationCenterForm").validate({
                rules: {
                    name: {
                        required: true
                    },
                    barangayName: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: 'Please enter evacuation center name.'
                    },
                    barangayName: {
                        required: 'Please select a barangay.'
                    }
                },
                showErrors: function(errorMap, errorList) {
                    this.defaultShowErrors();

                    if (!marker && saveBtnClicked) {
                        $('#location-error').
                        text('Please select a location.').
                        show();
                    }
                },
                errorElement: 'span',
                submitHandler: formSubmitHandler
            });

            function formSubmitHandler(form) {
                if (!marker) {
                    return;
                }

                let operation = $('#operation').val(),
                    url = "",
                    type = "",
                    formData = $(form).serialize(),
                    modal = $('#evacuationCenterModal');

                if (operation == 'Add') {
                    url = "{{ route('evacuation.center.add') }}";
                    type = "POST";
                } else {
                    url = "{{ route('evacuation.center.update', ':evacuationCenterId') }}".
                    replace(':evacuationCenterId', evacuationCenterId),
                        type = "PUT";
                }

                confirmModal(`Do you want to ${operation} this evacuation center?`).then((result) => {
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
                                    messageModal(
                                        'Warning',
                                        'Please fill up the form correctly.',
                                        'warning',
                                        '#FFDF00',
                                    );
                                } else {
                                    evacuationCenterTable.draw();

                                    operation = operation == 'Add' ? 'added' : 'updated';

                                    messageModal(
                                        'Success',
                                        `Successfully ${operation} the evacuation center.`,
                                        'success',
                                        '#3CB043'
                                    );

                                    modal.modal('hide');
                                }
                            },
                            error: function(jqXHR, error, data) {
                                modal.modal('hide');

                                messageModal(
                                    jqXHR.status,
                                    data,
                                    'error',
                                    '#B91C1C',
                                );
                            }
                        });
                    }
                });
            }

            function confirmModalSubmitHandler(operation) {
                confirmModal(`Do you want to ${operation} this evacuation center?`).then((result) => {
                    if (result.isConfirmed) {
                        let url, type;

                        if (operation == 'remove') {
                            url = "{{ route('evacuation.center.remove', ':evacuationCenterId') }}"
                                .replace(':evacuationCenterId', evacuationCenterId);
                            type = "DELETE";
                        } else {
                            url = "{{ route('evacuation.center.change.status', ':evacuationCenterId') }}"
                                .replace(':evacuationCenterId', evacuationCenterId);
                            type = "PATCH";
                        }

                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: type,
                            data: {
                                status: status
                            },
                            url: url,
                            success: function(response) {
                                operation = operation == 'remove' ?
                                    'removed the' :
                                    'changed the status of';

                                messageModal(
                                    'Success',
                                    `Successfully ${operation} evacuation center.`,
                                    'success',
                                    '#3CB043'
                                );

                                evacuationCenterTable.draw();
                            },
                            error: function(jqXHR, error, data) {
                                messageModal(
                                    jqXHR.status,
                                    data,
                                    'error',
                                    '#B91C1C',
                                );
                            }
                        });
                    } else {
                        if (operation == 'change status') {
                            $('.changeEvacuationStatus').val('');
                        }
                    }
                });
            }

            $('#evacuationCenterModal').on('hidden.bs.modal', function() {
                validator.resetForm();
                $('#evacuationCenterForm').trigger('reset');

                if (marker) {
                    marker.setMap(null);
                    marker = undefined;
                }

                map.setCenter({
                    lat: 14.2471423,
                    lng: 121.1366715
                });

                map.setZoom(13);
                saveBtnClicked = false;
            });
        });
    </script>
</body>

</html>
