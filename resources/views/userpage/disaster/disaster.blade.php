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
        <div class="content-container pt-8 pr-8 pl-28">
            <div class="dashboard-logo pb-4">
                <i class="bi bi-tropical-storm text-2xl p-2 bg-slate-900 text-white rounded"></i>
                <span class="text-2xl font-bold tracking-wider mx-2">DISASTER INFORMATION</span>
                <hr class="mt-4">
            </div>

            <div class="disaster-content flex bg-slate-50 shadow-lg p-4">
                {{-- <div class="disaster-form p-5 mx-4 border-r-2">
                    <header class="text-xl font-semibold">Disaster Information</header>
                    <hr>
                    <form action="{{ route('register.disaster.cswd') }}" method="POST">
                        @csrf
                        <div class="form disaster">
                            <div class="fields flex items-center justify-between flex-wrap">
                                <div class="flex flex-col my-3">
                                    <label for="disaster_type">Disaster Type</label>
                                    <input type="text" name="disaster_type"
                                        value="{{ !empty(old('disaster_type')) ? old('disaster_type') : null }}"
                                        class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded"
                                        autocomplete="off" placeholder="Enter Disaster Type">
                                    @error('disaster_type')
                                        <span
                                            class="text-red-500 text-xs italic">{{ $errors->first('disaster_type') }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="disaster-button">
                            <a href="{{ route('Cdashboard') }}">
                                <button type="button"
                                    class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Cancel</button>
                            </a>
                            <button type="submit" id="createDisaster"
                                class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Save</button>
                        </div>
                    </form>
                </div> --}}
                <div class="disaster-table w-full relative">
                    <header class="text-2xl font-semibold pb-3">Disaster Table</header>
                    <table class="table data-table display nowrap" style="width:100%">
                        <thead>
                            <tr class="table-row">
                                <th>Disaster Type</th>
                                <th class="w-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    @include('userpage.disaster.updateDisaster')
                </div>
            </div>
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
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var disasterTable = $('.data-table').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                processing: false,
                serverSide: true,
                ajax: "{{ route('disaster.cswd') }}",
                columns: [{
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $(document).on('click', '.updateDisaster', function(e) {
                var disaster_id = $(this).data("id");
                e.preventDefault();

                $.ajax({
                    url: "{{ route('disaster.details.cswd', ':disaster_id') }}"
                        .replace(':disaster_id', disaster_id),
                    dataType: "json",
                    success: function(response) {
                        $(document).find('span.error-text').text('');
                        $('#type').val(response.result.type);
                        $('#disasterId').val(disaster_id);
                        $('#editDisaster').modal('show');

                    },
                    error: function(response) {
                        Swal.fire(
                            "{{ config('app.name') }}",
                            'Something went Wrong.',
                            'error'
                        );
                    }
                })
            });

            $(document).on('click', '#updateDisasterBtn', function(e) {
                var disaster_id = $('#disasterId').val();
                e.preventDefault();

                $.ajax({
                    url: "{{ route('update.disaster.cswd', ':disaster_id') }}"
                        .replace(':disaster_id', disaster_id),
                    method: 'put',
                    data: $('#editDisasterForm').serialize(),
                    dataType: 'json',
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
                                confirmButtonText: 'Understood',
                                confirmButtonColor: '#334155',
                                title: "{{ config('app.name') }}",
                                text: 'Failed to Update Disaster.'
                            });
                        } else {
                            Swal.fire({
                                icon: 'success',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#334155',
                                title: "{{ config('app.name') }}",
                                text: 'Disaster Updated Successfully.'
                            });
                            $('#editDisasterForm')[0].reset();
                            $('#editDisaster').modal('hide');
                            disasterTable.draw();
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

            $('body').on('click', '.removeDisaster', function() {
                var disaster_id = $(this).data("id");
                Swal.fire({
                    icon: 'question',
                    title: 'Are you sure?',
                    text: "You won't be able to undo this!",
                    showCancelButton: true,
                    confirmButtonColor: '#334155',
                    cancelButtonColor: '#b91c1c',
                    confirmButtonText: 'Yes, remove it.'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('remove.disaster.cswd', ':disaster_id') }}"
                                .replace(':disaster_id', disaster_id),
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: "{{ config('app.name') }}",
                                    text: 'Disaster has been removed.',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#334155',
                                });
                                disasterTable.draw();
                            },
                            error: function(response) {
                                Swal.fire({
                                    icon: 'error',
                                    confirmButtonText: 'Understood',
                                    confirmButtonColor: '#334155',
                                    title: "{{ config('app.name') }}",
                                    text: 'Failed to remove disaster.'
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
