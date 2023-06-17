<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.headPackage')
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    <title>{{ config('app.name') }}</title>
</head>

<body>
    <div class="wrapper">
        @include('sweetalert::alert')
        @include('partials.header')
        @include('partials.sidebar')

        <x-messages />

        <div class="record-content pt-8 pr-8 pl-28 mb-4">
            <div class="dashboard-logo pb-4">
                <i class="bi bi-person-plus text-2xl p-2 bg-slate-700 text-white rounded"></i>
                <span class="text-2xl font-bold tracking-wider mx-2">RECORD EVACUEE</span>
                <hr class="mt-4">
            </div>

            <div class="content-item mt-8 bg-slate-50 drop-shadow-2xl">
                <div class="content-header bg-red-700 w-full h-full p-3">
                    <div class="text-center">
                        <span class="item-header relative w-full text-white text-xl">Record Evacuee Form</span>
                    </div>
                </div>
                <div class="w-full p-2">
                    <div class="content-body">

                        <form id="TyphoonForm">
                            <div class="bg-slate-50 p-4 pb-2 rounded">
                            <div class="flex-auto px-1 lg:px-5">
                                <header class="text-xl font-semibold ">Evacuee Information</header>
                                <hr class="mb-3">
                                @csrf
                                <div class="flex flex-wrap">
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label for="barangay">Barangay</label>
                                            <select name="barangay"
                                                class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 text-sm font-normal rounded w-full ease-linear transition-all duration-150">
                                                <option value="">Select Barangay</option>
                                                <option value="Baclaran">Baclaran</option>
                                                <option value="Banay-Banay">Banay-Banay</option>
                                                <option value="Banlic">Banlic</option>
                                                <option value="Bigaa">Bigaa</option>
                                                <option value="Butong">Butong</option>
                                                <option value="Casile">Casile</option>
                                                <option value="Diezmo">Diezmo</option>
                                                <option value="Gulod">Gulod</option>
                                                <option value="Mamatid">Mamatid</option>
                                                <option value="Marinig">Marinig</option>
                                                <option value="Niugan">Niugan</option>
                                                <option value="Pittland">Pittland</option>
                                                <option value="Pulo">Pulo</option>
                                                <option value="Sala">Sala</option>
                                                <option value="San Isidro">San Isidro</option>
                                                <option value="Barangay I Poblacion">Barangay I Poblacion</option>
                                                <option value="Barangay II Poblacion">Barangay II Poblacion</option>
                                                <option value="Barangay III Poblacion">Barangay III Poblacion</option>
                                            </select>
                                            <span class="text-red-500 text-xs italic error-text barangay_error"></span>
                                        </div>
                                    </div>
                                    {{-- <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label for="house_hold_number">Camp. Manager</label>
                                            <input type="text" name="house_hold_number"
                                                class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 text-sm font-normal rounded w-full ease-linear transition-all duration-150"
                                                autocomplete="off" placeholder="Enter Camp. Manager"
                                                value="{{ !empty(old('house_hold_number')) ? old('house_hold_number') : null }}">
                                            <span class="text-red-500 text-xs italic error-text name_error"></span>
                                        </div>
                                    </div> --}}
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label for="disaster">Disaster</label>
                                            <select name="disaster"
                                                class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 text-sm font-normal rounded w-full ease-linear transition-all duration-150">
                                                <option value="">Select Disaster</option>
                                                @foreach ($disasters as $disaster)
                                                    <option value="{{ $disaster->id }}"
                                                        @if (old('disaster') == $disaster->id) selected @endif>
                                                        {{ $disaster->type }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-red-500 text-xs italic error-text disaster_error"></span>
                                        </div>
                                    </div>
                                    {{-- <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label for="house_hold_number">Asst. Camp. Manager</label>
                                            <input type="text" name="house_hold_number"
                                                class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 text-sm font-normal rounded w-full ease-linear transition-all duration-150"
                                                autocomplete="off" placeholder="Enter Asst. Camp. Manager"
                                                value="{{ !empty(old('house_hold_number')) ? old('house_hold_number') : null }}">
                                            <span class="text-red-500 text-xs italic error-text name_error"></span>
                                        </div>
                                    </div> --}}
                                    <div class="w-full lg:w-1/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label for="house_hold_number">HH#</label>
                                            <input type="number" name="house_hold_number"
                                                class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 text-sm font-normal rounded w-full ease-linear transition-all duration-150"
                                                autocomplete="off" placeholder="HH#"
                                                value="{{ !empty(old('house_hold_number')) ? old('house_hold_number') : null }}">
                                            <span class="text-red-500 text-xs italic error-text house_hold_number_error"></span>
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-11/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" name="name"
                                                class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 text-sm font-normal rounded w-full ease-linear transition-all duration-150"
                                                autocomplete="off" placeholder="Enter Full Name"
                                                value="{{ !empty(old('name')) ? old('name') : null }}">
                                            <span class="text-red-500 text-xs italic error-text name_error"></span>
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label for="sex">Sex</label>
                                            <select name="sex"
                                                class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 text-sm font-normal rounded w-full ease-linear transition-all duration-150">
                                                <option value="">Select Sex</option>
                                                <option value="Male"
                                                    @if (old('sex') == 'Male') selected @endif>Male
                                                </option>
                                                <option value="Female"
                                                    @if (old('sex') == 'Female') selected @endif>Female
                                                </option>
                                            </select>
                                            <span class="text-red-500 text-xs italic error-text sex_error"></span>
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-6/12 px-4">
                                        <div class="relative w-full mb-3">
                                            <label for="age">Age</label>
                                            <input type="number" name="age"
                                                class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 text-sm font-normal rounded w-full ease-linear transition-all duration-150"
                                                autocomplete="off" placeholder="Enter Age"
                                                value="{{ !empty(old('age')) ? old('age') : null }}">
                                            <span class="text-red-500 text-xs italic error-text age_error"></span>
                                        </div>
                                    </div>
                                    <div class="w-full px-4">
                                        <div class="relative flex justify-between items-center mb-3">
                                            <div class="flex items-center gap-2">
                                                <input type="checkbox" id="fourps" name="fourps"
                                                    class="w-5 h-5">
                                                <label for="">4ps</label>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <input type="checkbox" id="pwd" name="pwd"
                                                    class="w-5 h-5">
                                                <label for="">PWD</label>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <input type="checkbox" id="pregnant" name="pregnant"
                                                    class="w-5 h-5">
                                                <label for="">Pregnant</label>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <input type="checkbox" id="lactating" name="lactating"
                                                    class="w-5 h-5">
                                                <label for="">Lactating</label>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <input type="checkbox" id="student" name="student"
                                                    class="w-5 h-5">
                                                <label for="">Student</label>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <input type="checkbox" id="working" name="working"
                                                    class="w-5 h-5">
                                                <label for="">Working</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-full px-4">
                                        <div class="relative w-full mb-3">
                                            <label for="evacuation_assigned">Evacuation Assigned</label>
                                            <select name="evacuation_assigned"
                                                class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 text-sm font-normal rounded w-full ease-linear transition-all duration-150">
                                                <option value="">Select Evacuation Assigned</option>
                                                @foreach ($evacuationCenters as $evacuationCenter)
                                                    <option value="{{ $evacuationCenter->id }}"
                                                        @if (old('evacuation_assigned') == $evacuationCenter->id) selected @endif>
                                                        {{ $evacuationCenter->name }}</option>
                                                @endforeach
                                            </select>
                                            <span
                                                class="text-red-500 text-xs italic error-text evacuation_assigned_error"></span>
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
                            data: $('#TyphoonForm').serialize(),
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
                                    'Failed to Register Evacuee, Thank You!',
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
