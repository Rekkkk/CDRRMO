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
        @include('partials.header')
        @include('partials.sidebar')
        <div class="main-content">
            <div class="grid grid-cols-1">
                <div class="grid col-end-1">
                    <div class="text-2xl text-white">
                        <i class="bi bi-house-gear p-2 bg-slate-600"></i>
                    </div>
                </div>
                <span class="text-xl font-bold">MANAGE EVACUATION CENTER</span>
            </div>
            <hr class="mt-4 mb-3">
            @if (auth()->user()->is_disable == 0)
                <div class="create-section">
                    <button class="btn-submit p-2 createEvacuationCenter">
                        <i class="bi bi-house-down-fill pr-2"></i>
                        Create Evacuation Center
                    </button>
                </div>
            @endif
            <div class="table-container p-3 shadow-lg rounded-lg">
                <div class="block w-full overflow-auto pb-2">
                    <header class="text-2xl font-semibold mb-3">Evacuation Center Table</header>
                    <table class="table evacuationCenterTable" width="100%">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="2">Name</th>
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
            @if (auth()->user()->is_disable == 0)
                @include('userpage.evacuationCenter.evacuationCenterModal')
            @endif
            @auth
                @include('userpage.changePasswordModal')
            @endauth
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
        let evacuationCenterTable = $('.evacuationCenterTable').DataTable({
            language: {
                emptyTable: '<div class="no-data">No evacuation center added yet.</div>',
            },
            ordering: false,
            responsive: true,
            processing: false,
            serverSide: true,
            ajax: "{{ route('evacuation.center.get', 'manage') }}",
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
                    name: 'status',
                    width: '10%'
                },
                {
                    data: 'action',
                    name: 'action',
                    width: '10%',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        @if (auth()->user()->is_disable == 0)
            let evacuationCenterId, defaultFormData, status, map, marker, saveBtnClicked = false;

            function initMap() {
                var mapTypeStyleArray = [{
                        featureType: 'water',
                        elementType: 'labels.text',
                        stylers: [{
                            color: '#000000'
                        }]
                    },
                    {
                        featureType: 'road.local',
                        elementType: 'geometry.fill',
                        stylers: [{
                            color: '#b8b8b8'
                        }]
                    },
                    {
                        featureType: 'road.highway',
                        elementType: 'geometry.fill',
                        stylers: [{
                            color: '#383838'
                        }]
                    },
                ];

                map = new google.maps.Map(document.getElementById("map"), {
                    center: {
                        lat: 14.2471423,
                        lng: 121.1366715
                    },
                    zoom: 13,
                    clickableIcons: false,
                    mapTypeId: 'terrain',
                    styles: mapTypeStyleArray
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
                        animation: google.maps.Animation.DROP
                    });

                    $('#latitude').val(location.lat());
                    $('#longitude').val(location.lng());
                    $('#location-error').hide();
                });
            }

            $(document).ready(function() {
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

                $(document).on('click', '.createEvacuationCenter', function() {
                    $('.modal-header').removeClass('bg-yellow-500').addClass('bg-green-600');
                    $('.modal-title').text('Create Evacuation Center');
                    $('#saveEvacuationCenterBtn').removeClass('btn-update').addClass('btn-submit').text(
                        'Create');
                    $('#operation').val('create');
                    $('#evacuationCenterModal').modal('show');
                });

                $(document).on('click', '.updateEvacuationCenter', function() {
                    let data = getRowData(this);
                    evacuationCenterId = data['id'];

                    $('.modal-header').removeClass('bg-green-600').addClass('bg-yellow-500');
                    $('.modal-title').text('Update Evacuation Center');
                    $('#saveEvacuationCenterBtn').removeClass('btn-submit').addClass('btn-update').text(
                        'Update');
                    $('#operation').val('update');
                    $('#name').val(data['name']);
                    $('#latitude').val(data['latitude']);
                    $('#longitude').val(data['longitude']);
                    $('#capacity').val(data['capacity']);
                    $(`#barangayName, option[value="${data['barangay_name']}"`).prop('selected', true);

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

                    $('#evacuationCenterModal').modal('show');
                    defaultFormData = $('#evacuationCenterForm').serialize();
                });

                $(document).on('click', '.removeEvacuationCenter', function() {
                    evacuationCenterId = getRowData(this)['id'];
                    let url = "{{ route('evacuation.center.remove', ':evacuationCenterId') }}".replace(
                        ':evacuationCenterId', evacuationCenterId);
                    alterEvacuationCenter(url, "PATCH", "remove");
                })

                $(document).on('change', '.changeEvacuationStatus', function() {
                    evacuationCenterId = getRowData(this)['id'];
                    status = $(this).val();
                    let url = "{{ route('evacuation.center.change.status', ':evacuationCenterId') }}"
                        .replace(
                            ':evacuationCenterId', evacuationCenterId);
                    alterEvacuationCenter(url, "PATCH", "change");
                })

                $('#evacuationCenterModal').on('hidden.bs.modal', function() {
                    validator.resetForm();
                    $('#evacuationCenterForm')[0].reset();

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

                $('#saveEvacuationCenterBtn').click(() => {
                    saveBtnClicked = true;
                });

                function getRowData(element) {
                    let currentRow = $(element).closest('tr');

                    if (evacuationCenterTable.responsive.hasHidden()) {
                        currentRow = currentRow.prev('tr');
                    }

                    return evacuationCenterTable.row(currentRow).data();
                }

                function formSubmitHandler(form) {
                    if (!marker) {
                        return;
                    }

                    let operation = $('#operation').val(),
                        url, type, formData = $(form).serialize(),
                        modal = $('#evacuationCenterModal');

                    url = operation == 'create' ? "{{ route('evacuation.center.create') }}" :
                        "{{ route('evacuation.center.update', ':evacuationCenterId') }}".
                    replace(':evacuationCenterId', evacuationCenterId);

                    type = óperation == 'create' ? 'POST' : 'PUT';

                    confirmModal(`Do you want to ${operation} this evacuation center?`).then((result) => {
                        if (result.isConfirmed) {
                            if (operation == 'update' && defaultFormData == formData) {
                                showWarningMessage('No changes were made.');
                                return;
                            }
                            $.ajax({
                                data: formData,
                                url: url,
                                type: type,
                                success: function(response) {
                                    if (response.status == "warning") {
                                        showWarningMessage(response.message);
                                    } else {
                                        showSuccessMessage(
                                            `Successfully ${operation}d evacuation center.`);
                                        evacuationCenterTable.draw();
                                        modal.modal('hide');
                                    }
                                },
                                error: function() {
                                    modal.modal('hide');
                                    showErrorMessage();
                                }
                            });
                        }
                    });
                }

                function alterEvacuationCenter(url, type, operation) {
                    confirmModal(
                        `Do you want to ${operation == "remove" ? "remove" : "change the status of"} this evacuation center?`
                    ).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                type: type,
                                data: {
                                    status: status
                                },
                                url: url,
                                success: function() {
                                    showSuccessMessage(
                                        `Successfully ${operation == "remove" ? "removed" : "changed the status of"} evacuation center.`
                                    );
                                    evacuationCenterTable.draw();
                                },
                                error: function() {
                                    showErrorMessage();
                                }
                            });
                        } else {
                            $('.changeEvacuationStatus').val('');
                        }
                    });
                }
            });
        @endif
    </script>
</body>

</html>
