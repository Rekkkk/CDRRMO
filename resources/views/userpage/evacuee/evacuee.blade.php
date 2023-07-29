<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.headPackage')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
                        <i class="bi bi-people p-2 bg-slate-600"></i>
                    </div>
                </div>
                <span class="text-xl font-bold">MANAGE EVACUEE INFORMATION</span>
            </div>
            <hr class="mt-4">
            <div class="flex flex-wrap justify-end text-white gap-3 my-3">
                <button id="recordEvacueeBtn" data-toggle="modal" data-target="#evacueeInfoFormModal"
                    class="btn-submit p-2">
                    <i class="bi bi-person-down pr-2"></i>
                    Record Evacuee Info
                </button>
            </div>
            <div class="table-container p-3 shadow-lg rounded-lg">
                <div class="block w-full overflow-auto pb-2">
                    <header class="text-2xl font-semibold mb-3">Evacuee Informations Table</header>
                    <table class="table evacueeTable" width="100%">
                        <thead class="thead-light">
                            <tr class="table-row">
                                <th colspan="2">Barangay</th>
                                <th>Date Entry</th>
                                <th>Evacuation Assigned</th>
                                <th>Families</th>
                                <th>No. of Individuals</th>
                                <th>Male</th>
                                <th>Female</th>
                                <th>Senior Citizen</th>
                                <th>Minors</th>
                                <th>Infants</th>
                                <th>PWD</th>
                                <th>Pregnant</th>
                                <th>Lactating</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('userpage.evacuee.evacueeInfoFormModal')
        @include('userpage.changePasswordModal')
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
        $(document).ready(function() {
            let evacueeId, defaultFormData;

            let evacueeTable = $('.evacueeTable').DataTable({
                language: {
                    emptyTable: '<div class="no-data">No evacuees data added yet.</div>',
                },
                ordering: false,
                responsive: true,
                processing: false,
                serverSide: true,
                ajax: "{{ route('evacuee.info.get') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        visible: false
                    },
                    {
                        data: 'barangay',
                        name: 'barangay'
                    },
                    {
                        data: 'date_entry',
                        name: 'date_entry'
                    },
                    {
                        data: 'evacuation_assigned',
                        name: 'evacuation_assigned'
                    },
                    {
                        data: 'families',
                        name: 'families',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'individuals',
                        name: 'individuals',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'male',
                        name: 'male',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'female',
                        name: 'female',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'senior_citizen',
                        name: 'senior_citizen',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'minors',
                        name: 'minors',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'infants',
                        name: 'infants',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'pwd',
                        name: 'pwd',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'pregnant',
                        name: 'pregnant',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'lactating',
                        name: 'lactating',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '8%'
                    }
                ],
            });

            let dateEntryInput = datePicker("#date_entry");

            let validator = $("#evacueeInfoForm").validate({
                rules: {
                    disaster_id: {
                        required: true
                    },
                    date_entry: {
                        required: true
                    },
                    barangay: {
                        required: true
                    },
                    evacuation_assigned: {
                        required: true
                    },
                    infants: {
                        required: true
                    },
                    minors: {
                        required: true
                    },
                    senior_citizen: {
                        required: true
                    },
                    pwd: {
                        required: true
                    },
                    pregnant: {
                        required: true
                    },
                    lactating: {
                        required: true
                    },
                    families: {
                        required: true
                    },
                    individual: {
                        required: true
                    },
                    male: {
                        required: true
                    },
                    female: {
                        required: true
                    }
                },
                messages: {
                    disaster_id: {
                        required: 'Please select disaste.'
                    },
                    date_entry: {
                        required: 'Please enter date entry.',
                    },
                    barangay: {
                        required: 'Please enter barangay.',
                    },
                    evacuation_assigned: {
                        required: 'Please enter evacuation center assigned.'
                    },
                    infants: {
                        required: 'Please enter number of infants.'
                    },
                    minors: {
                        required: 'Please enter number of minors.'
                    },
                    senior_citizen: {
                        required: 'Please enter number of senior citizen.'
                    },
                    pwd: {
                        required: 'Please enter number of pwd.'
                    },
                    pregnant: {
                        required: 'Please enter number of pregnant.'
                    },
                    lactating: {
                        required: 'Please enter number of lactating.'
                    },
                    families: {
                        required: 'Please enter number of families.'
                    },
                    individual: {
                        required: 'Please enter number of individuals.'
                    },
                    male: {
                        required: 'Please enter number of male.'
                    },
                    female: {
                        required: 'Please enter number of female.'
                    }
                },
                errorElement: 'span',
                submitHandler: formSubmitHandler
            });

            $('#recordEvacueeBtn').click(function() {
                $('.modal-header').removeClass('bg-yellow-500').addClass('bg-green-600');
                $('.modal-title').text('Record Evacuee Information');
                $('#recordEvacueeInfoBtn').removeClass('btn-update').addClass('btn-submit').text('Record');
                $('#operation').val('record');
                $('#evacueeInfoFormModal').modal('show');
            });

            $(document).on('click', '.updateEvacueeBtn', function() {
                $('.modal-header').removeClass('bg-green-600').addClass('bg-yellow-500');
                $('.modal-title').text('Update Evacuee Information');
                $('#recordEvacueeInfoBtn').removeClass('btn-submit').addClass('btn-update').text('Update');

                let currentRow = $(this).closest('tr');

                if (evacueeTable.responsive.hasHidden()) {
                    currentRow = currentRow.prev('tr');
                }

                let data = evacueeTable.row(currentRow).data();

                evacueeId = data['id'];
                $('input[name="houseHoldNumber"]').val(data['house_hold_number']);
                $('input[name="fullName"]').val(data['full_name']);
                $(`input[name="sex"], option[value="${data['sex']}"]`).prop('selected', true);
                $('input[name="age"]').val(data['age']);
                dateEntryInput.setDate(data['date_entry']);

                $(`option[value="${data['barangay']}"]`).prop('selected', true);
                $(`option[value="${data['disaster_name']}"]`).prop('selected', true);

                if ($(`option[value="${data['evacuation_assigned']}"]`).length) {
                    $('#evacuationSelectContainer').removeClass('hidden');
                    $(`option[value="${data['evacuation_assigned']}"]`).prop('selected', true);
                } else {
                    $('#evacuationSelectContainer').addClass('hidden');
                    $('input[name="defaultEvacuationAssigned"]').val(data['evacuation_assigned']);
                }

                $('#infants').val(data['infants']);
                $('#minors').val(data['minors']);
                $('#senior_citizen').val(data['senior_citizen']);
                $('#pwd').val(data['pwd']);
                $('#pregnant').val(data['pregnant']);
                $('#lactating').val(data['lactating']);
                $('#families').val(data['families']);
                $('#individual').val(data['individual']);
                $('#male').val(data['male']);
                $('#female').val(data['female']);
                $('#remarks').val(data['remarks']);
                $('#operation').val('update');
                $('#evacueeInfoFormModal').modal('show');
                defaultFormData = $('#evacueeInfoForm').serialize();
            });

            $('#evacueeInfoFormModal').on('hidden.bs.modal', function() {
                validator.resetForm();
                $('#evacueeInfoForm').trigger("reset");
            });

            function formSubmitHandler(form) {
                let operation = $('#operation').val(),
                    url = "",
                    type = "",
                    formData = $(form).serialize(),
                    modal = $('#evacueeInfoFormModal');

                url = operation == 'record' ?
                    "{{ route('evacuee.info.record') }}" :
                    "{{ route('evacuee.info.update', 'evacueeId') }}".replace('evacueeId', evacueeId);

                type = operation == 'record' ? "POST" : "PUT";

                confirmModal(`Do you want to ${operation} this evacuee info?`).then((result) => {
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
                                    $('#evacueeInfoFormModal').modal('hide');
                                    evacueeTable.draw();
                                    showSuccessMessage(`Successfully ${operation}${operation == 'record' ? 'ed new' : 'ed the'} evacuee info.`);
                                }
                            },
                            error: function() {
                                showErrorMessage();
                            }
                        });
                    }
                });
            }
        });
    </script>
</body>

</html>
