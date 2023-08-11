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
            <div class="label-container">
                <div class="icon-container">
                    <div class="icon-content"><i class="bi bi-tropical-storm"></i></div>
                </div>
                <span>MANAGE DISASTER INFORMATION</span>
            </div>
            <hr>
            @if (auth()->user()->is_disable == 0)
                <div class="page-button-container">
                    <button class="btn-submit" id="createDisasterData">
                        <i class="bi bi-cloud-plus"></i>Add Disaster
                    </button>
                </div>
            @endif
            <div class="table-container">
                <div class="table-content">
                    <header class="table-label">Disaster Information Table</header>
                    <table class="table disasterTable" width="100%">
                        <thead class="thead-light">
                            <tr>
                                <th colspan="2">Disaster Name</th>
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
                @include('userpage.disaster.disasterModal')
            @endif
            @include('userpage.changePasswordModal')
        </div>
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
        let disasterTable = $('.disasterTable').DataTable({
            language: {
                emptyTable: '<div class="message-text">There are no disaster data available.</div>',
            },
            ordering: false,
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
                    data: 'status',
                    name: 'status',
                    width: '10%'
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
            let disasterId, defaultFormData, status;

            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let validator = $("#disasterForm").validate({
                    rules: {
                        name: 'required'
                    },
                    messages: {
                        name: 'Please Enter Disaster Name.'
                    },
                    errorElement: 'span',
                    submitHandler: disasterFormHandler
                });

                $(document).on('click', '#createDisasterData', () => {
                    $('.modal-label-container').removeClass('bg-warning').addClass('bg-success');
                    $('.modal-label').text('Create Disaster');
                    $('#submitDisasterBtn').removeClass('btn-update').addClass('btn-submit').text('Add');
                    $('#operation').val('create');
                    $('#disasterModal').modal('show');
                });

                $(document).on('click', '#updateDisaster', function() {
                    let {
                        id,
                        name
                    } = getRowData(this, disasterTable);
                    disasterId = id;
                    $('#disasterName').val(name);
                    $('.modal-label-container').removeClass('bg-success').addClass('bg-warning');
                    $('.modal-label').text('Update Disaster');
                    $('#submitDisasterBtn').removeClass('btn-submit').addClass('btn-update').text('Update');
                    $('#operation').val('update');
                    $('#disasterModal').modal('show');
                    defaultFormData = $('#disasterForm').serialize();
                });

                $(document).on('click', '#removeDisaster', function() {
                    let url = "{{ route('disaster.remove', ':disasterId') }}".replace(':disasterId',
                        getRowData(this, disasterTable).id);
                    alterDisasterData('remove', url);
                });

                $(document).on('change', '#changeDisasterStatus', function() {
                    status = $(this).val();
                    let url = "{{ route('disaster.change.status', ':disasterId') }}".replace(':disasterId',
                        getRowData(this, disasterTable).id);
                    alterDisasterData('change', url);
                });

                $('#disasterModal').on('hidden.bs.modal', () => {
                    validator.resetForm();
                    $('#disasterForm')[0].reset();
                    $('#disasterForm').trigger('reset');
                });

                function alterDisasterData(operation, url) {
                    confirmModal(`Do you want to ${operation} this disaster?`).then((result) => {
                        return result.isConfirmed == false ? $('#changeDisasterStatus').val('') :
                            $.ajax({
                                type: 'PATCH',
                                data: {
                                    status
                                },
                                url,
                                success() {
                                    showSuccessMessage(`Disaster successfully ${operation}d.`);
                                    disasterTable.draw();
                                },
                                error() {
                                    showErrorMessage();
                                }
                            });
                    });
                }

                function disasterFormHandler(form) {
                    let operation = $('#operation').val(),
                        formData = $(form).serialize();
                    let url = operation == 'create' ? "{{ route('disaster.create') }}" :
                        "{{ route('disaster.update', 'disasterId') }}".replace('disasterId',
                            disasterId);
                    let type = operation == 'create' ? "POST" : "PATCH";

                    confirmModal(`Do you want to ${operation} this disaster?`).then((result) => {
                        if (result.isConfirmed)
                            return operation == 'update' && defaultFormData == formData ?
                                showWarningMessage(
                                    'No changes were made.') :
                                $.ajax({
                                    data: formData,
                                    url,
                                    type,
                                    success(response) {
                                        response.status == 'warning' ? showWarningMessage(response
                                            .message) : (
                                            showSuccessMessage(
                                                `Disaster successfully ${operation}d.`), $(
                                                '#disasterModal').modal('hide'), disasterTable
                                            .draw());
                                    },
                                    error() {
                                        showErrorMessage();
                                    }
                                });
                    });
                }
            });
        @endif
    </script>
</body>

</html>
