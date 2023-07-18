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
                <div class="grid col-end-1 mr-4">
                    <div class="text-white text-2xl">
                        <i class="bi bi-tropical-storm p-2 bg-slate-600 rounded"></i>
                    </div>
                </div>
                <span class="text-xl font-bold ml-2">MANAGE DISASTER INFORMATION</span>
            </div>
            <hr class="mt-4">
            <div class="flex justify-end my-3">
                <button class="btn-submit p-2" id="createDisasterData">
                    <i class="bi bi-cloud-plus pr-2"></i>
                    Create Disaster Data
                </button>
            </div>
            <div class="table-container p-3 bg-slate-50 shadow-lg rounded-lg">
                <header class="text-2xl font-semibold mb-3">Disaster Information Table</header>
                <div class="block w-full overflow-auto">
                    <table class="table disasterTable table-striped table-light" width="100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Disaster Name</th>
                                <th>location</th>
                                <th>Status</th>
                                <th width="20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            @include('userpage.disaster.disasterModal')
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
    <script>
        let disasterId, defaultFormData, status;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let disasterTable = $('.disasterTable').DataTable({
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            processing: false,
            serverSide: true,
            ajax: "{{ route('disaster.display') }}",
            columns: [{
                    data: 'id',
                    name: 'id',
                    visible: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'location',
                    name: 'location'
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
                },
            ]
        });

        $('#createDisasterData').click(function() {
            $('#disasterForm')[0].reset();
            $('#operation').val('create');
            $('.modal-header').removeClass('bg-yellow-500').addClass('bg-green-600');
            $('.modal-title').text('Create Disaster Form');
            $('#submitDisasterBtn').removeClass('btn-edit').addClass('btn-submit').text('Create');
            $('#disasterModal').modal('show');
        });

        $(document).on('click', '.updateDisaster', function() {
            let data = getRowData(this);
            disasterId = data['id'];
            $('.modal-header').removeClass('bg-green-600').addClass('bg-yellow-500');
            $('.modal-title').text('Edit Disaster Form');
            $('#submitDisasterBtn').removeClass('btn-submit').addClass('btn-edit').text('Update');
            $('#disasterName').val(data['name']);
            $('#location').val(data['location']);
            $('#operation').val('update');
            $('#disasterModal').modal('show');
            defaultFormData = $('#disasterForm').serialize();
        });

        $(document).on('click', '.removeDisaster', function() {
            let data = getRowData(this);
            disasterId = data['id'];
            alterDisasterData('remove');
        });

        $(document).on('change', '.changeDisasterStatus', function() {
            disasterId = getRowData(this)['id'];
            status = $(this).val();
            alterDisasterData('change status');
        });

        function alterDisasterData(operation) {
            confirmModal(`Do you want to ${operation} this disaster?`).then((result) => {
                if (result.isConfirmed) {
                    let url, type;

                    if (operation == 'remove') {
                        url = "{{ route('disaster.remove', ':disasterId') }}"
                            .replace(':disasterId', disasterId);
                        type = "PATCH";
                    } else {
                        url = "{{ route('disaster.change.status', ':disasterId') }}"
                            .replace(':disasterId', disasterId);
                        type = "PATCH";
                    }

                    $.ajax({
                        type: type,
                        data: {
                            status: status
                        },
                        url: url,
                        success: function(response) {
                            if (response.status == 'success') {
                                toastr.success(response.message, 'Success');
                                disasterTable.draw();
                            } else if (response.status == 'error') {
                                toastr.warning(response.message, 'Error');
                            }
                        },
                        error: function() {
                            toastr.error(
                                'Something went wrong, Please try again later.',
                                'Error');
                        }
                    });
                } else {
                    $('.changeDisasterStatus').val('');
                }
            });
        }

        let validator = $("#disasterForm").validate({
            rules: {
                name: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: 'Please Enter Disaster Name.'
                }
            },
            errorElement: 'span',
            submitHandler: disasterFormHandler
        });

        function disasterFormHandler(form) {
            let operation = $('#operation').val(),
                url = "",
                type = "",
                formData = $(form).serialize();

            url = operation == 'create' ? "{{ route('disaster.create') }}" :
                "{{ route('disaster.update', 'disasterId') }}".replace('disasterId',
                    disasterId);

            type = operation == 'create' ? "POST" : "PUT";

            confirmModal(`Do you want to ${operation} this disaster?`).then((result) => {
                if (result.isConfirmed) {
                    if (operation == 'update' && defaultFormData == formData) {
                        $('#disasterModal').modal('hide');
                        messageModal('Info', 'No changes were made.', 'info', '#B91C1C');
                        return;
                    }
                    $.ajax({
                        data: formData,
                        url: url,
                        type: type,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 'success') {
                                toastr.success(response.message, 'Success');
                                $('#disasterForm')[0].reset();
                                $('#disasterModal').modal('hide');
                                disasterTable.draw();
                            } else if (response.status == 'error') {
                                toastr.warning(response.message, 'Error');
                            } else if (response.status == 'warning') {
                                toastr.warning(response.message, 'Error');
                            }
                        },
                        error: function() {
                            toastr.error(
                                'Something went wrong, Please try again later.',
                                'Error');
                        }
                    });
                }
            });
        }

        function getRowData(element) {
            let currentRow = $(element).closest('tr');

            if (disasterTable.responsive.hasHidden()) {
                currentRow = currentRow.prev('tr');
            }

            return disasterTable.row(currentRow).data();
        }
    </script>
</body>

</html>
