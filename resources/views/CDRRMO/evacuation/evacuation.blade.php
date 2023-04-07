<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.content.headPackage')
        <link rel="stylesheet" href="{{ asset('assets/css/evacuation.css') }}">
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
                        <header class="text-xl font-semibold">Evacuation Information</header>
                        <hr>
                        <form action="{{ route('Cregisterevacuation') }}" method="GET">
                            @csrf
                            <div class="form evacuation my-3">
                                <div class="details personal">
                                    <div class="fields">
                                        <div class="flex flex-col">
                                            <label for="evacuation_name">Evacuation Name</label>
                                            <input type="text" name="evacuation_name" class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded" autocomplete="off" placeholder="Evacuation Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="details personal">
                                    <div class="fields">
                                        <div class="flex flex-col">
                                            <label for="evacuation_contact">Evacuation Contact</label>
                                            <input type="text" name="evacuation_contact" class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded" autocomplete="off" placeholder="Evacuation Contact">
                                        </div>
                                    </div>
                                </div>
                                <div class="details personal">
                                    <div class="fields">
                                        <div class="flex flex-col">
                                            <label for="evacuation_location">Evacuation Location</label>
                                            <input type="text" name="evacuation_location" class="border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded" autocomplete="off" placeholder="Evacuation Location">
                                        </div>
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
                    <div class="disaster-table w-full relative">
                        <header class="text-2xl font-semibold">Evacuation Table</header>
                        <hr>
                        <table class="table mt-2">
                            <thead>
                                <tr class="table-row">
                                    <th>Evacuation Name</th>
                                    <th>Evacuation Contact</th>
                                    <th>Evacuation Location</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($evacuation as $evacuationList)
                                <tr>
                                    <td class="py-3">{{ $evacuationList->evacuation_name }}</td>
                                    <td class="py-3">{{ $evacuationList->evacuation_contact }}</td>
                                    <td class="py-3">{{ $evacuationList->evacuation_location }}</td>
                                    <td class="text-right">
                                        <a href="#edit{{ $evacuationList->evacuation_id }}" data-bs-toggle="modal">
                                            <button type="button" class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">
                                                <i class="bi bi-pencil mr-2"></i>Edit
                                            </button>
                                        </a>
                                        <a href="{{ route('Cremoveevacuation', $evacuationList->evacuation_id) }}">
                                            <button type="button" class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">
                                                <i class="bi bi-trash mr-2"></i>Delete
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                                @include('CDRRMO.evacuation.updateEvacuation')
                                @endforeach
                            </tbody>
                        </table>
                        <div class="absolute bottom-0 left-0">
                            {{ $evacuation->links() }}
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