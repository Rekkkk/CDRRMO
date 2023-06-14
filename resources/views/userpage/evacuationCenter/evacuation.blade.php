<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.content.headPackage')
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <title>{{ config('app.name') }}</title>
</head>

<body>
    <div class="wrapper">
        @include('sweetalert::alert')
        @include('partials.content.header')
        @include('partials.content.sidebar')

        <x-messages />

        <div class="content pt-8 pr-8 pl-28">
            <div class="dashboard-logo pb-4">
                <i class="bi bi-tropical-storm text-2xl p-2 bg-slate-900 text-white rounded"></i>
                <span class="text-2xl font-bold tracking-wider mx-2">EVACUATION CENTER INFORMATION</span>
                <hr class="mt-4">
            </div>

            <div class="evacuation-content flex bg-slate-50 shadow-lg p-4">
                <div class="evacuation-form p-3 mx-2 border-r-2">
                    <header class="text-xl font-semibold">Evacuation Center Information</header>
                    <hr>
                    <form id="addEvacuationCenterForm" name="addEvacuationCenterForm">
                        @csrf
                        <div class="form evacuation my-3">
                            <div class="fields">
                                <div class="flex flex-col">
                                    <label for="name">Evacuation Center Name</label>
                                    <input type="text" name="name"
                                        value="{{ !empty(old('name')) ? old('name') : null }}"
                                        class="border-2 border-slate-400 px-3 mb-2 h-11 text-slate-600 outline-none text-sm font-normal rounded"
                                        autocomplete="off" placeholder="Evacuation Center Name">
                                    <span class="text-danger italic text-xs error-text name_error"></span>
                                </div>
                            </div>

                            <div class="fields">
                                <div class="flex flex-col">
                                    <label for="barangay_name">Barangay Name</label>
                                    <input type="text" name="barangay_name"
                                        value="{{ !empty(old('barangay_name')) ? old('barangay_name') : null }}"
                                        class="border-2 border-slate-400 px-3 mb-2 h-11 text-slate-600 outline-none text-sm font-normal rounded"
                                        autocomplete="off" placeholder="Barangay Name">
                                    <span class="text-danger italic text-xs error-text barangay_name_error"></span>
                                </div>
                            </div>

                            <div class="fields">
                                <div class="flex flex-col">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" name="latitude"
                                        value="{{ !empty(old('latitude')) ? old('latitude') : null }}"
                                        class="border-2 border-slate-400 px-3 mb-2 h-11 text-slate-600 outline-none text-sm font-normal rounded"
                                        autocomplete="off" placeholder="Evacuation Latitude">
                                    <span class="text-danger italic text-xs error-text latitude_error"></span>
                                </div>
                            </div>

                            <div class="fields">
                                <div class="flex flex-col">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" name="longitude"
                                        value="{{ !empty(old('longitude')) ? old('longitude') : null }}"
                                        class="border-2 border-slate-400 px-3 mb-2 h-11 text-slate-600 outline-none text-sm font-normal rounded"
                                        autocomplete="off" placeholder="Evacuation Longitude">
                                    <span class="text-danger italic text-xs error-text longitude_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="evacuation-button">
                            <a href="{{ route('dashboard.cswd') }}">
                                <button type="button"
                                    class="bg-slate-700 text-white p-2 rounded shadow-lg hover:bg-slate-900">Cancel</button>
                            </a>
                            <button id="addEvacuationCenter"
                                class="bg-red-700 text-white p-2 rounded shadow-lg hover:bg-red-900">Submit</button>
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
                ajax: "{{ route('evacuation.center.cswd') }}",
                columns: [{
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

            $('#addEvacuationCenter ').click(function(e) {
                e.preventDefault();

                Swal.fire({
                    icon: 'question',
                    title: 'Would you like to submit this evacuation center?',
                    showDenyButton: true,
                    confirmButtonText: 'Yes, submit it.',
                    confirmButtonColor: '#334155',
                    denyButtonText: `Double Check`,
                    denyButtonColor: '#b91c1c',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            data: $('#addEvacuationCenterForm').serialize(),
                            url: "{{ route('register.evacuation.center.cswd') }}",
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
                                    Swal.fire({
                                        icon: 'error',
                                        title: "{{ config('app.name') }}",
                                        text: 'Failed to submit evacuation center.',
                                        confirmButtonText: 'Understood',
                                        confirmButtonColor: '#334155'
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#334155',
                                        title: "{{ config('app.name') }}",
                                        text: 'Evacuation Center Added Successfully.'
                                    });
                                    $('#addEvacuationCenterForm')[0].reset();
                                    evacuationCenterTable.draw();
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

            $(document).on('click', '.updateEvacuationCenter', function(e) {
                var evacuation_center_id = $(this).data("id");
                e.preventDefault();

                $.ajax({
                    url: "{{ route('evacuation.center.detail.cswd', ':evacuation_center_id') }}"
                        .replace(':evacuation_center_id', evacuation_center_id),
                    dataType: "json",
                    success: function(response) {
                        $('#name').val(response.result.name);
                        $('#barangay_name').val(response.result.barangay_name);
                        $('#latitude').val(response.result.latitude);
                        $('#longitude').val(response.result.longitude);
                        $('#status').val(response.result.status);
                        $('#evacuationCenterId').val(evacuation_center_id);
                        $('#editEvacuationCenter').modal('show');
                    },
                    error: function(response) {
                        var errors = response.responseJSON;
                    }
                })
            });

            $(document).on('click', '#editEvacuationCenterBtn', function(e) {
                var evacuation_center_id = $('#evacuationCenterId').val();
                e.preventDefault();

                $.ajax({
                    url: "{{ route('update.evacuation.center.cswd', ':evacuation_center_id') }}"
                        .replace(':evacuation_center_id', evacuation_center_id),
                    method: 'PUT',
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
                            Swal.fire({
                                icon: 'error',
                                title: "{{ config('app.name') }}",
                                text: 'Failed to Update Barangay.',
                                confirmButtonText: 'Understood',
                                confirmButtonColor: '#334155'
                            });
                        } else {
                            Swal.fire({
                                icon: 'success',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#334155',
                                title: "{{ config('app.name') }}",
                                text: 'Evacuation Center Updated Successfully.'
                            });
                            $('#editEvacuationForm')[0].reset();
                            $('#editEvacuationCenter').modal('hide');
                            evacuationCenterTable.draw();
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
                })
            });

            $('body').on('click', '.removeEvacuationCenter', function() {
                var evacuation_center_id = $(this).data("id");

                Swal.fire({
                    icon: 'question',
                    title: 'Are you sure?',
                    text: "You won't be able to undo this!",
                    showCancelButton: true,
                    confirmButtonColor: '#334155',
                    cancelButtonColor: '#b91c1c',
                    confirmButtonText: 'Yes, delete it.'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('remove.evacuation.center.cswd', ':evacuation_center_id') }}"
                                .replace(':evacuation_center_id', evacuation_center_id),
                            success: function(response) {
                                if (response.status == 0) {
                                    Swal.fire({
                                        icon: 'error',
                                        confirmButtonText: 'Understood',
                                        confirmButtonColor: '#334155',
                                        title: "{{ config('app.name') }}",
                                        text: 'Failed to Remove Evacuation Center.'
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#334155',
                                        title: "{{ config('app.name') }}",
                                        text: 'Evacuation Center has been deleted.'
                                    });
                                    evacuationCenterTable.draw();
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
                });
            });
        });
    </script>

</body>

</html>
