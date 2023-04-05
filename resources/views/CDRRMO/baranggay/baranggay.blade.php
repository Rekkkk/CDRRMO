<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.content.headPackage')
        <link rel="stylesheet" href="{{ asset('assets/css/baranggay.css') }}">
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
                    <span class="text-2xl font-bold tracking-wider mx-2">BARANGGAY INFORMATION</span>
                    <hr class="mt-4">
                </div>
                <div class="main-content bg-slate-50 p-4">
                    <div class="disaster-form p-5 mx-4 border-r-2">
                        <header class="text-xl font-semibold">Baranggay Information</header>
                        <hr>
                        {!! Form::open(['route' => 'Cregisterbaranggay']) !!}
                            @method('GET')
                            @csrf
                            <div class="form first">
                                <div class="details personal">
                                    <div class="fields flex items-center justify-between flex-wrap">
                                        <div class="flex flex-col my-3">
                                            {!! Form::label('baranggay_label', 'Baranggay Label') !!}
                                            {!! Form::text('baranggay_label', '', ['class' => 'border-2 border-slate-400 px-3 my-2 h-11 text-slate-600 outline-none text-sm font-normal rounded', 'autocomplete' => 'off' ,'placeholder' => 'Enter Baranngay Name']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="disaster-button">
                                <a href="{{ route('Cdashboard') }}">
                                    <button type="button" class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Cancel</button>
                                </a>
                                <button type="submit" class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Save</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="disaster-table w-full relative">
                        <header class="text-2xl font-semibold">Baranggay Table</header>
                        <hr>
                        <table class="table mt-2">
                            <thead>
                                <tr class="table-row">
                                    <th>Baranggay Name</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($baranggay as $baranggayList)
                                <tr>
                                    <td class="py-3">{{ $baranggayList->baranggay_label }}</td>
                                    <td class="text-right">
                                        <a href="#edit{{ $baranggayList->baranggay_id }}" data-bs-toggle="modal">
                                            <button type="button" class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">
                                                <i class="bi bi-pencil mr-2"></i>Edit
                                            </button>
                                        </a>
                                        <a href="{{ route('Cremovebaranggay', $baranggayList->baranggay_id) }}">
                                            <button type="button" class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">
                                                <i class="bi bi-trash mr-2"></i>Delete
                                            </button>
                                        </a>
                                        @include('CDRRMO.baranggay.updateBaranggay')
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="absolute bottom-0 left-0">
                            {{ $baranggay->links() }}
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