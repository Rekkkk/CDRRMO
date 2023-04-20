<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.content.headPackage')
        <link rel="stylesheet" href="{{ asset('assets/css/evacuation-css/evacuation.css') }}">
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
                        <form action="{{ route('Cregisterevacuation') }}" method="POST">
                            @csrf
                            <div class="form evacuation my-3">
                                <div class="fields">
                                    <div class="flex flex-col">
                                        <label for="evacuation_center_name">Evacuation Center Name</label>
                                        <input type="text" name="evacuation_center_name" class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded" autocomplete="off" placeholder="Evacuation Center Name">
                                    </div>
                                </div>
                               
                                <div class="fields">
                                    <div class="flex flex-col">
                                        <label for="evacuation_center_contact">Evacuation Center Contact</label>
                                        <input type="text" name="evacuation_center_contact" class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded" autocomplete="off" placeholder="Evacuation Center Contact">
                                    </div>
                                </div>
                                
                                <div class="fields">
                                    <div class="flex flex-col">
                                        <label for="evacuation_center_location">Evacuation Center Location</label>
                                        <input type="text" name="evacuation_center_location" class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded" autocomplete="off" placeholder="Evacuation Center Location">
                                    </div>
                                </div>
                            </div>
                            <div class="evacuation-button">
                                <a href="{{ route('Cdashboard') }}">
                                    <button type="button" class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Cancel</button>
                                </a>
                                <button type="submit" class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="evacuation-table w-full relative">
                        <header class="text-2xl font-semibold">Evacuation Center Table</header>
                        <hr>
                        <table class="table mt-2">
                            <thead>
                                <tr class="table-row">
                                    <th>Evacuation Center Name</th>
                                    <th>Evacuation Center Contact</th>
                                    <th>Evacuation Center Location</th>
                                    <th class="text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($evacuationCenter as $evacuationCenterList)
                                <tr>
                                    <td class="w-2/5">{{ $evacuationCenterList->evacuation_center_name }}</td>
                                    <td>{{ $evacuationCenterList->evacuation_center_contact }}</td>
                                    <td>{{ $evacuationCenterList->evacuation_center_location }}</td>
                                    <td class="flex flex-row gap-2">
                                        <a href="#edit{{ $evacuationCenterList->evacuation_center_id }}" data-bs-toggle="modal">
                                            <button type="submit" class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">
                                                <i class="bi bi-pencil mr-2"></i>Edit
                                            </button>
                                        </a>
                                        @include('CDRRMO.evacuationCenter.updateEvacuationCenter')
                                    
                                        <form action="{{ route('Cremoveevacuation', $evacuationCenterList->evacuation_center_id) }}" method="POST">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">
                                                <i class="bi bi-trash mr-2"></i>Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-center" colspan="4">
                                        No Evacuation Center Record Found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="absolute bottom-0 left-0">
                            {{ $evacuationCenter->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/js/landingPage.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    </body>
</html>