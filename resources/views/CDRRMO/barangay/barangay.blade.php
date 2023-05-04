<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.content.headPackage')
    <link rel="stylesheet" href="{{ asset('assets/css/barangay-css/barangay.css') }}">
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
                <i class="bi bi-hospital text-2xl px-2 bg-slate-900 text-white rounded py-2"></i>
                <span class="text-2xl font-bold tracking-wider mx-2">BARANGAY INFORMATION</span>
                <hr class="mt-4">
            </div>
            <div class="main-content bg-slate-50 p-4">
                <div class="barangay-form p-3 mx-2 border-r-2">
                    <header class="text-xl font-semibold">Barangay Information</header>
                    <hr>
                    <form action="{{ route('Cregisterbarangay') }}" method="POST">
                        @csrf
                        <div class="form barangay my-3">
                            <div class="fields">
                                <div class="flex flex-col">
                                    <label for="barangay_name">Barangay Name</label>
                                    <input type="text" name="barangay_name"
                                        value="{{ !empty(old('barangay_name')) ? old('barangay_name') : null }}"
                                        class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded"
                                        autocomplete="off" placeholder="Barangay Name">
                                    @error('barangay_name')
                                        <span
                                            class="text-red-500 text-xs italic">{{ $errors->first('barangay_name') }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="fields">
                                <div class="flex flex-col">
                                    <label for="barangay_location">Barangay Location</label>
                                    <input type="text" name="barangay_location"
                                        value="{{ !empty(old('barangay_location')) ? old('barangay_location') : null }}"
                                        class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded"
                                        autocomplete="off" placeholder="Barangay Location">
                                    @error('barangay_location')
                                        <span
                                            class="text-red-500 text-xs italic">{{ $errors->first('barangay_location') }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="fields">
                                <div class="flex flex-col">
                                    <label for="barangay_contact">Barangay Contact Number</label>
                                    <input type="text" name="barangay_contact"
                                        value="{{ !empty(old('barangay_contact')) ? old('barangay_contact') : null }}"
                                        class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded"
                                        autocomplete="off" placeholder="Barangay Contact Number">
                                    @error('barangay_contact')
                                        <span
                                            class="text-red-500 text-xs italic">{{ $errors->first('barangay_contact') }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="fields">
                                <div class="flex flex-col">
                                    <label for="barangay_email">Barangay Email Address</label>
                                    <input type="text" name="barangay_email"
                                        value="{{ !empty(old('barangay_email')) ? old('barangay_email') : null }}"
                                        class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded"
                                        autocomplete="off" placeholder="Barangay Email Address">
                                    @error('barangay_email')
                                        <span
                                            class="text-red-500 text-xs italic">{{ $errors->first('barangay_email') }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="barangay-button">
                            <a href="{{ route('Cdashboard') }}">
                                <button type="button"
                                    class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Cancel</button>
                            </a>
                            <button type="submit"
                                class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Save</button>
                        </div>
                    </form>
                </div>
                <div class="barangay-table w-full relative">
                    <header class="text-2xl font-semibold">Barangay Table</header>
                    <hr>
                    <table class="table mt-2">
                        <thead>
                            <tr class="table-row">
                                <th>Barangay Name</th>
                                <th>Location</th>
                                <th>Contact Number</th>
                                <th>Email Address</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barangay as $barangayList)
                                <tr>
                                    <td class="">{{ $barangayList->barangay_name }}</td>
                                    <td class="w-2/5">{{ $barangayList->barangay_location }}</td>
                                    <td class="">{{ $barangayList->barangay_contact_number }}</td>
                                    <td class="">{{ $barangayList->barangay_email_address }}</td>
                                    <td class="flex gap-2 justify-end">
                                        <a href="#edit{{ $barangayList->barangay_id }}" data-bs-toggle="modal">
                                            <button type="submit"
                                                class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">
                                                <i class="bi bi-pencil mr-2"></i>Edit
                                            </button>
                                        </a>
                                        @include('CDRRMO.barangay.updateBarangay')

                                        <form action="{{ route('Cremovebarangay', $barangayList->barangay_id) }}"
                                            method="POST">
                                            @method('delete')
                                            @csrf
                                            <button type="submit"
                                                class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">
                                                <i class="bi bi-trash mr-2"></i>Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-center" colspan="5">
                                        No Barangay Record Found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="absolute bottom-0 left-0">
                        {{ $barangay->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>

</body>

</html>
