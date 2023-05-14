<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.content.headPackage')
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    <title>{{ config('app.name') }}</title>
</head>

<body class="bg-gray-400">
    <div class="wrapper">
        @include('sweetalert::alert')
        @include('partials.content.header')
        @include('partials.content.sidebar')

        <x-messages />

        <div class="record-content pt-8 pr-8 pl-28 mb-4">
            <div class="dashboard-logo pb-4">
                <i class="bi bi-person-plus text-2xl px-2 bg-slate-900 text-white rounded py-2"></i>
                <span class="text-2xl font-bold tracking-wider mx-2">RECORD EVACUEE</span>
                <hr class="mt-4">
            </div>

            <div class="content-item mt-8 bg-slate-50 drop-shadow-2xl">
                <div class="content-header bg-red-900 w-full h-full p-3">
                    <div class="text-center">
                        <img class="float-right w-8" id="header-logo-right" src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                        <span class="item-header relative w-full text-white text-xl">Record Evacuee Form</span>
                        <img class="float-left w-8" id="header-logo-left" src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                    </div>
                </div>
                <div class="w-full p-2">
                    <div class="content-body">

                        <div class="mb-3">
                            <select id="disaster" class="form-select form-disaster-select p-2 text-center">
                                <option value="">Choose Disaster Type</option>
                                <option value="Typhoon">Typhoon</option>
                                <option value="Road Accident">Road Accident</option>
                                <option value="Earthquake">Earthquake</option>
                                <option value="Flooding">Flooding</option>
                            </select>
                        </div>

                        <form id="Typhoon">
                            <div class="bg-slate-50 p-4 pb-2 rounded">
                                <div class="flex-auto px-1 lg:px-5 pb-0 pt-0">
                                    <header class="text-xl font-semibold ">Evacuee Information</header>
                                    <hr class="mb-3">
                                    @csrf
                                    <div class="flex flex-wrap">
                                        <div class="w-full lg:w-6/12 px-4">
                                            <div class="relative w-full mb-3">
                                                <label for="first_name">First Name</label>
                                                <input type="text" name="first_name"
                                                    class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 text-sm font-normal rounded w-full ease-linear transition-all duration-150"
                                                    autocomplete="off" placeholder="Enter First Name"
                                                    value="{{ !empty(old('first_name')) ? old('first_name') : null }}">
                                                <span
                                                    class="text-red-500 text-xs italic error-text first_name_error"></span>
                                            </div>
                                        </div>
                                        <div class="w-full lg:w-5/12 px-4">
                                            <div class="relative w-full mb-3">
                                                <label for="middle_name">Middle Name</label>
                                                <input type="text" name="middle_name"
                                                    class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 text-sm font-normal rounded w-full ease-linear transition-all duration-150"
                                                    autocomplete="off" placeholder="Enter Middle Name"
                                                    value="{{ !empty(old('middle_name')) ? old('middle_name') : null }}">
                                                <span
                                                    class="text-red-500 text-xs italic error-text middle_name_error"></span>
                                            </div>
                                        </div>
                                        <div class="w-full lg:w-1/12 px-4">
                                            <div class="relative w-full mb-3">
                                                <label for="suffix">Suffix</label>
                                                <input type="text" name="suffix"
                                                    class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 text-sm font-normal rounded w-full ease-linear transition-all duration-150"
                                                    autocomplete="off" placeholder="Suffix"
                                                    value="{{ !empty(old('evacuee_suffix')) ? old('evacuee_suffix') : null }}">
                                                <span
                                                    class="text-red-500 text-xs italic error-text suffix_error"></span>
                                            </div>
                                        </div>
                                        <div class="w-full lg:w-6/12 px-4">
                                            <div class="relative w-full mb-3">
                                                <label for="last_name">Last Name</label>
                                                <input type="text" name="last_name"
                                                    class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 text-sm font-normal rounded w-full ease-linear transition-all duration-150"
                                                    autocomplete="off" placeholder="Enter Last Name"
                                                    value="{{ !empty(old('last_name')) ? old('last_name') : null }}">
                                                <span
                                                    class="text-red-500 text-xs italic error-text last_name_error"></span>
                                            </div>
                                        </div>
                                        <div class="w-full lg:w-6/12 px-4">
                                            <div class="relative w-full mb-3">
                                                <label for="contact_number">Contact Number</label>
                                                <input type="text" name="contact_number"
                                                    class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 text-sm font-normal rounded w-full ease-linear transition-all duration-150"
                                                    autocomplete="off" placeholder="Enter Contact Number"
                                                    value="{{ !empty(old('contact_number')) ? old('contact_number') : null }}">
                                                <span
                                                    class="text-red-500 text-xs italic error-text contact_number_error"></span>
                                            </div>
                                        </div>
                                        <div class="w-full lg:w-6/12 px-4">
                                            <div class="relative w-full mb-3">
                                                <label for="age">Age</label>
                                                <input type="text" name="age"
                                                    class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 text-sm font-normal rounded w-full ease-linear transition-all duration-150"
                                                    autocomplete="off" placeholder="Enter Age"
                                                    value="{{ !empty(old('age')) ? old('age') : null }}">
                                                <span class="text-red-500 text-xs italic error-text age_error"></span>
                                            </div>
                                        </div>
                                        <div class="w-full lg:w-6/12 px-4">
                                            <div class="relative w-full mb-3">
                                                <label for="gender">Gender</label>
                                                <select name="gender"
                                                    class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 text-sm font-normal rounded w-full ease-linear transition-all duration-150">
                                                    <option value="">Select Gender</option>
                                                    <option value="Male"
                                                        @if (old('gender') == 'Male') selected @endif>Male
                                                    </option>
                                                    <option value="Female"
                                                        @if (old('gender') == 'Female') selected @endif>Female
                                                    </option>
                                                </select>
                                                <span
                                                    class="text-red-500 text-xs italic error-text gender_error"></span>
                                            </div>
                                        </div>
                                        <div class="w-full px-4">
                                            <div class="relative w-full mb-3">
                                                <label for="address">Address</label>
                                                <input type="text" name="address"
                                                    class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 text-sm font-normal rounded w-full ease-linear transition-all duration-150"
                                                    autocomplete="off" placeholder="Enter Address"
                                                    value="{{ !empty(old('address')) ? old('address') : null }}">
                                                <span
                                                    class="text-red-500 text-xs italic error-text address_error"></span>
                                            </div>
                                        </div>
                                        <div class="w-full px-4">
                                            <div class="relative w-full mb-3">
                                                <label for="barangay">Barangay</label>
                                                <select name="barangay"
                                                    class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 text-sm font-normal rounded w-full ease-linear transition-all duration-150">
                                                    <option value="">Select Barangay</option>
                                                    @foreach ($barangays as $barangay)
                                                        <option value="{{ $barangay->barangay_id }}"
                                                            @if (old('barangay') == $barangay->barangay_id) selected @endif>
                                                            {{ $barangay->barangay_name }}</option>
                                                    @endforeach
                                                </select>
                                                <span
                                                    class="text-red-500 text-xs italic error-text barangay_error"></span>
                                            </div>
                                        </div>
                                        <div class="w-full px-4">
                                            <div class="relative w-full mb-3">
                                                <label for="evacuation_center">Evacuation Assigned</label>
                                                <select name="evacuation_center"
                                                    class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 text-sm font-normal rounded w-full ease-linear transition-all duration-150">
                                                    <option value="">Select Evacuation Assigned</option>
                                                    @foreach ($evacuationCenters as $evacuationCenter)
                                                        <option value="{{ $evacuationCenter->evacuation_center_id }}"
                                                            @if (old('evacuation_center') == $evacuationCenter->evacuation_center_id) selected @endif>
                                                            {{ $evacuationCenter->evacuation_center_name }}</option>
                                                    @endforeach
                                                </select>
                                                <span
                                                    class="text-red-500 text-xs italic error-text evacuation_center_error"></span>
                                            </div>
                                        </div>
                                        <div class="w-full px-4">
                                            <div class="relative w-full mb-3">
                                                <label for="disaster">Disaster</label>
                                                <select name="disaster"
                                                    class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 text-sm font-normal rounded w-full ease-linear transition-all duration-150">
                                                    <option value="">Select Disaster</option>
                                                    @foreach ($disasters as $disaster)
                                                        <option value="{{ $disaster->disaster_id }}"
                                                            @if (old('disaster') == $disaster->disaster_id) selected @endif>
                                                            {{ $disaster->disaster_type }}</option>
                                                    @endforeach
                                                </select>
                                                <span
                                                    class="text-red-500 text-xs italic error-text disaster_error"></span>
                                            </div>
                                        </div>
                                        <div class="w-full px-4 ">
                                            <div class="relative w-full ">
                                                <button id="saveEvacuee"
                                                    class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:bg-red-800 transition duration-200 float-right mb-3">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/js/script.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"
            integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
        </script>
        <script>
            const charts = ["Typhoon", "Road Accident", "Earthquake", "Flooding"];

            document.getElementById('disaster').addEventListener('change', (event) => {

                const selectForm = event.target.value;

                charts.forEach((formId) => {

                    const form = document.getElementById(formId);

                    if (selectForm == formId) {
                        form.style.opacity = 1;
                        form.style.display = "contents";
                    } else {
                        form.style.opacity = 0;
                        form.style.display = "none";
                    }

                });
            });

            $('#saveEvacuee').click(function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Do you want to add this evacuee?',
                    icon: "info",
                    showDenyButton: true,
                    confirmButtonText: 'Submit',
                    confirmButtonColor: '#0E1624',
                    denyButtonText: `Double Check`,
                    denyButtonColor: '#850000',
                    showLoaderOnConfirm: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            data: $('#Typhoon').serialize(),
                            url: "{{ route('record.evacuee.cswd') }}",
                            type: "POST",
                            dataType: 'json',
                            beforeSend: function(data) {
                                $(document).find('span.error-text').text('');
                            },
                            success: function(data) {
                                if (data.condition == 0) {
                                    $.each(data.error, function(prefix, val) {
                                        $('span.' + prefix + '_error').text(val[
                                            0]);
                                    });
                                    Swal.fire(
                                        "{{ config('app.name') }}",
                                        'Failed to Register Evacuee, Thank You!',
                                        'error'
                                    );
                                } else {
                                    Swal.fire(
                                        "{{ config('app.name') }}",
                                        'Successfully Register Evacuee, Thank You!',
                                        'success'
                                    );
                                    $('#Typhoon')[0].reset();
                                }
                            },

                            error: function(data) {
                                Swal.fire(
                                    "{{ config('app.name') }}",
                                    'Failed to Register Evacuee, Tdasdashank You!',
                                    'error'
                                );
                            }
                        });
                    }
                })
            });
        </script>

</body>

</html>
