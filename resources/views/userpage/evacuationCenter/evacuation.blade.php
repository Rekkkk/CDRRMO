<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.content.headPackage')
    <link rel="stylesheet" href="{{ asset('assets/css/evacuation-css/evacuation.css') }}">
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

        <div class="content">
            <div class="dashboard-logo pb-4">
                <i class="bi bi-tropical-storm text-2xl px-2 bg-slate-900 text-white rounded py-2"></i>
                <span class="text-2xl font-bold tracking-wider mx-2">EVACUATION CENTER INFORMATION</span>
                <hr class="mt-4">
            </div>

            <div class="main-content bg-slate-50 p-4">
                <div class="evacuation-form p-3 mx-2 border-r-2">
                    <header class="text-xl font-semibold">Evacuation Center Information</header>
                    <hr>
                    <form id="addEvacuationCenterForm" name="addEvacuationCenterForm">
                        @csrf
                        <div class="form evacuation my-3">
                            <div class="fields">
                                <div class="flex flex-col">
                                    <label for="evacuation_center_name">Evacuation Center Name</label>
                                    <input type="text" name="evacuation_center_name"
                                        value="{{ !empty(old('evacuation_center_name')) ? old('evacuation_center_name') : null }}"
                                        class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded"
                                        autocomplete="off" placeholder="Evacuation Center Name">
                                    <span
                                        class="text-danger italic text-xs error-text evacuation_center_name_error"></span>
                                </div>
                            </div>

                            <div class="fields">
                                <div class="flex flex-col">
                                    <label for="evacuation_center_contact">Evacuation Center Contact</label>
                                    <input type="text" name="evacuation_center_contact"
                                        value="{{ !empty(old('evacuation_center_contact')) ? old('evacuation_center_contact') : null }}"
                                        class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded"
                                        autocomplete="off" placeholder="Evacuation Center Contact">
                                    <span
                                        class="text-danger italic text-xs error-text evacuation_center_contact_error"></span>
                                </div>
                            </div>

                            <div class="fields">
                                <div class="flex flex-col">
                                    <label for="evacuation_center_address">Evacuation Center Address</label>
                                    <input type="text" name="evacuation_center_address"
                                        value="{{ !empty(old('evacuation_center_address')) ? old('evacuation_center_address') : null }}"
                                        class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded"
                                        autocomplete="off" placeholder="Evacuation Center Address">
                                    <span
                                        class="text-danger italic text-xs error-text evacuation_center_address_error"></span>
                                </div>
                            </div>

                            <div class="fields">
                                <div class="flex flex-col">
                                    <label for="barangay_id">Barangay Id</label>
                                    <input type="text" name="barangay_id"
                                        value="{{ !empty(old('barangay_id')) ? old('barangay_id') : null }}"
                                        class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded"
                                        autocomplete="off" placeholder="Evacuation Center Address">
                                    <span
                                        class="text-danger italic text-xs error-text barangay_id_error"></span>
                                </div>
                            </div>

                            <div class="fields">
                                <div class="flex flex-col">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" name="latitude"
                                        value="{{ !empty(old('latitude')) ? old('latitude') : null }}"
                                        class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded"
                                        autocomplete="off" placeholder="Evacuation Center Address">
                                    <span
                                        class="text-danger italic text-xs error-text latitude_error"></span>
                                </div>
                            </div>

                            <div class="fields">
                                <div class="flex flex-col">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" name="longitude"
                                        value="{{ !empty(old('longitude')) ? old('longitude') : null }}"
                                        class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded"
                                        autocomplete="off" placeholder="Evacuation Center Address">
                                    <span
                                        class="text-danger italic text-xs error-text longitude_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="evacuation-button">
                            <a href="{{ route('dashboard.cdrrmo') }}">
                                <button type="button"
                                    class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Cancel</button>
                            </a>
                            <button id="addEvacuationCenter"
                                class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="evacuation-table w-full relative">
                    <header class="text-2xl font-semibold">Evacuation Center Table</header>
                    <hr>
                    <table class="table data-table display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Evacuation Center Name</th>
                                <th>Evacuation Center Contact</th>
                                <th>Evacuation Center Address</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th class="w-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

            @include('userpage.evacuationCenter.updateEvacuationCenter')
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
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var evacuationCenterTable = $('.data-table').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                processing: false,
                serverSide: true,
                ajax: "{{ route('evacuation.center.cdrrmo') }}",
                columns: [{
                        data: 'evacuation_center_name',
                        name: 'evacuation_center_name'
                    },
                    {
                        data: 'evacuation_center_contact',
                        name: 'evacuation_center_contact'
                    },
                    {
                        data: 'evacuation_center_address',
                        name: 'evacuation_center_address'
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
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#addEvacuationCenter ').click(function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Do you really want to submit this?',
                    showDenyButton: true,
                    showLoaderOnConfirm: true,
                    icon: 'info',
                    confirmButtonText: 'Yes, submit it.',
                    confirmButtonColor: '#334155',
                    denyButtonText: `Double Check`,
                    denyButtonColor: '#b91c1c',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            data: $('#addEvacuationCenterForm').serialize(),
                            url: "{{ route('register.evacuation.center.cdrrmo') }}",
                            type: "POST",
                            dataType: 'json',
                            beforeSend: function(response) {
                                $(document).find('span.error-text').text('');
                            },
                            success: function(response) {
                                if (response.status == 0) {
                                    $.each(response.error, function(prefix, val) {
                                        $('span.' + prefix + '_error').text(val[
                                            0]);
                                    });
                                    Swal.fire(
                                        "{{ config('app.name') }}",
                                        'Some Fields Are Required, Fill It Up!',
                                        'error',
                                    );
                                } else {
                                    Swal.fire(
                                        "{{ config('app.name') }}",
                                        'Evacuation Center Added Successfully!',
                                        'success',
                                    );
                                    $('#addEvacuationCenterForm')[0].reset();
                                    evacuationCenterTable.draw();
                                }
                            },

                            error: function(response) {
                                console.log('Error:', response);
                                Swal.fire(
                                    "{{ config('app.name') }}",
                                    'Ooppss.. Something went wrong.',
                                    'error',
                                );
                            }
                        });
                    }
                })
            });

            $(document).on('click', '.updateEvacuationCenter', function(e) {
                e.preventDefault();
                var evacuation_center_id = $(this).data("id");

                $.ajax({
                    url: "{{ route('evacuation.center.detail.cdrrmo', ':evacuation_center_id') }}"
                        .replace(':evacuation_center_id', evacuation_center_id),
                    dataType: "json",
                    success: function(response) {
                        $('#evacuation_name').val(response.result.evacuation_center_name);
                        $('#evacuation_contact').val(response.result.evacuation_center_contact);
                        $('#evacuation_address').val(response.result.evacuation_center_address);
                        $('#barangay_evacuation_id').val(response.result.barangay_id);
                        $('#evacuation_latitude').val(response.result.latitude);
                        $('#evacuation_longitude').val(response.result.longitude);
                        $('#evacuationCenterId').val(evacuation_center_id);
                        $('#editEvacuationCenter').modal('show');
                    },
                    error: function(response) {
                        var errors = response.responseJSON;
                    }
                })
            });

            $(document).on('click', '#editEvacuationCenterBtn', function(e) {
                e.preventDefault();
                var evacuation_center_id = $('#evacuationCenterId').val();

                $.ajax({
                    url: "{{ route('update.evacuation.center.cdrrmo', ':evacuation_center_id') }}"
                        .replace(':evacuation_center_id', evacuation_center_id),
                    method: 'put',
                    data: $('#editEvacuationForm').serialize(),
                    dataType: "json",
                    beforeSend: function(response) {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(response) {
                        if (response.status == 0) {
                            $.each(response.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                            Swal.fire(
                                "{{ config('app.name') }}",
                                'Failed to Update Barangay!',
                                'error',
                            );
                        } else {
                            Swal.fire(
                                "{{ config('app.name') }}",
                                'Evacuation Center Updated Successfully!',
                                'success',
                            );
                            $('#editEvacuationForm')[0].reset();
                            $('#editEvacuationCenter').modal('hide');
                            evacuationCenterTable.draw();
                        }
                    },
                    error: function(response) {
                        Swal.fire(
                            "{{ config('app.name') }}",
                            'Failed to Update Barangay!',
                            'error',
                        );
                    }
                })
            });

            $('body').on('click', '.removeEvacuationCenter', function() {
                var evacuation_center_id = $(this).data("id");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to undo this!",
                    icon: 'info',
                    showLoaderOnConfirm: true,
                    showCancelButton: true,
                    confirmButtonColor: '#334155',
                    cancelButtonColor: '#b91c1c',
                    confirmButtonText: 'Yes, delete it.'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('remove.evacuation.center.cdrrmo', ':evacuation_center_id') }}"
                                .replace(':evacuation_center_id', evacuation_center_id),
                            success: function(response) {
                                Swal.fire(
                                    "{{ config('app.name') }}!",
                                    'Evacuation Center has been deleted.',
                                    'success'
                                )
                                evacuationCenterTable.draw();
                            },

                            error: function(response) {
                                console.log('Error:', response);
                            }
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>
