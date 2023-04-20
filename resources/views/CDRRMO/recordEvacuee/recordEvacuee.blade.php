<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.content.headPackage')
    <link rel="stylesheet" href="{{ asset('assets/css/recordEvacuee/recordEvacuee.css') }}">
    <title>{{ config('app.name') }}</title>
</head>

<body class="bg-gray-400">
    <div class="wrapper">
        @include('sweetalert::alert')
        @include('partials.content.header')
        @include('partials.content.sidebar')

        <x-messages />

        <div class="main-content mb-4">
            <div class="dashboard-logo pb-4">
                <i class="bi bi-person-plus text-2xl px-2 bg-slate-900 text-white rounded py-2"></i>
                <span class="text-2xl font-bold tracking-wider mx-2">RECORD EVACUEE</span>
                <hr class="mt-4">
            </div>

            <div class="bg-slate-50 p-4 pb-2 rounded">
                <header class="text-xl font-semibold ">Evacuee Information</header>
                <hr class="mb-3">
                <div class="flex-auto px-1 lg:px-5 pb-0 pt-0">
                    <form action="{{ route('Crecordevacueeinfo') }}" method="POST">
                        @csrf
                        <div class="flex flex-wrap">
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label for="first_name">First Name</label>
                                    <input type="text" name="first_name"
                                        class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded w-full ease-linear transition-all duration-150"
                                        autocomplete="off" placeholder="Enter First Name"
                                        value="{{ !empty(old('first_name')) ? old('first_name') : null }}">
                                    @if ($errors->has('first_name'))
                                        <span
                                            class="text-red-500 text-xs italic">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label for="middle_name">Middle Name</label>
                                    <input type="text" name="middle_name"
                                        class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded w-full ease-linear transition-all duration-150"
                                        autocomplete="off" placeholder="Enter Middle Name"
                                        value="{{ !empty(old('middle_name')) ? old('middle_name') : null }}">
                                    @if ($errors->has('middle_name'))
                                        <span
                                            class="text-red-500 text-xs italic">{{ $errors->first('middle_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name"
                                        class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded w-full ease-linear transition-all duration-150"
                                        autocomplete="off" placeholder="Enter Last Name"
                                        value="{{ !empty(old('last_name')) ? old('last_name') : null }}">
                                    @if ($errors->has('last_name'))
                                        <span
                                            class="text-red-500 text-xs italic">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label for="contact_number">Contact Number</label>
                                    <input type="text" name="contact_number"
                                        class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded w-full ease-linear transition-all duration-150"
                                        autocomplete="off" placeholder="Enter Contact Number"
                                        value="{{ !empty(old('contact_number')) ? old('contact_number') : null }}">
                                    @if ($errors->has('contact_number'))
                                        <span
                                            class="text-red-500 text-xs italic">{{ $errors->first('contact_number') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label for="age">Age</label>
                                    <input type="text" name="age"
                                        class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded w-full ease-linear transition-all duration-150"
                                        autocomplete="off" placeholder="Enter Age"
                                        value="{{ !empty(old('age')) ? old('age') : null }}">
                                    @if ($errors->has('age'))
                                        <span class="text-red-500 text-xs italic">{{ $errors->first('age') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full lg:w-6/12 px-4">
                                <div class="relative w-full mb-3">
                                    <label for="gender">Gender</label>
                                    <select name="gender"
                                        class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded w-full ease-linear transition-all duration-150">
                                        <option value="">Select Gender</option>
                                        <option value="Male" @if (old('gender') == 'Male') selected @endif>Male
                                        </option>
                                        <option value="Female" @if (old('gender') == 'Female') selected @endif>Female
                                        </option>
                                    </select>
                                    @if ($errors->has('gender'))
                                        <span class="text-red-500 text-xs italic">{{ $errors->first('gender') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full px-4">
                                <div class="relative w-full mb-3">
                                    <label for="address">Address</label>
                                    <input type="text" name="address"
                                        class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded w-full ease-linear transition-all duration-150"
                                        autocomplete="off" placeholder="Enter Address"
                                        value="{{ !empty(old('address')) ? old('address') : null }}">
                                    @if ($errors->has('address'))
                                        <span
                                            class="text-red-500 text-xs italic">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full px-4">
                                <div class="relative w-full mb-3">
                                    <label for="barangay">Barangay</label>
                                    <select name="barangay"
                                        class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded w-full ease-linear transition-all duration-150">
                                        <option value="">Select Barangay</option>
                                        @foreach ($barangays as $barangay)
                                            <option value="{{ $barangay->barangay_id }}"
                                                @if (old('barangay') == $barangay->barangay_id) selected @endif>
                                                {{ $barangay->barangay_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('barangay'))
                                        <span
                                            class="text-red-500 text-xs italic">{{ $errors->first('barangay') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full px-4">
                                <div class="relative w-full mb-3">
                                    <label for="evacuation_center">Evacuation Assigned</label>
                                    <select name="evacuation_center"
                                        class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded w-full ease-linear transition-all duration-150">
                                        <option value="">Select Evacuation Assigned</option>
                                        @foreach ($evacuationCenters as $evacuationCenter)
                                            <option value="{{ $evacuationCenter->evacuation_id }}"
                                                @if (old('evacuation_center') == $evacuationCenter->evacuation_id) selected @endif>
                                                {{ $evacuationCenter->evacuation_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('evacuation_center'))
                                        <span
                                            class="text-red-500 text-xs italic">{{ $errors->first('evacuation_center') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full px-4">
                                <div class="relative w-full mb-3">
                                    <label for="disaster">Disaster</label>
                                    <select name="disaster"
                                        class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded w-full ease-linear transition-all duration-150">
                                        <option value="">Select Disaster</option>
                                        @foreach ($disasters as $disaster)
                                            <option value="{{ $disaster->disaster_id }}"
                                                @if (old('disaster') == $disaster->disaster_id) selected @endif>
                                                {{ $disaster->disaster_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('disaster'))
                                        <span
                                            class="text-red-500 text-xs italic">{{ $errors->first('disaster') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full px-4 ">
                                <div class="relative w-full ">
                                    <button type="submit"
                                        class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200 float-right mb-3">Save</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <script src="{{ asset('assets/js/landingPage.js') }}"></script>
            <script src="https://code.jquery.com/jquery-3.6.4.min.js"
                integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
            </script>

</body>

</html>
