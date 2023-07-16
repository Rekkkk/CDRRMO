<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.headPackage')
    {{-- @vite(['resources/js/app.js']) --}}
</head>

<body>
    <div class="wrapper">
        @include('partials.header')
        @include('partials.sidebar')
        <div class="main-content">
            <div class="grid grid-cols-1">
                <div class="grid col-end-1 mr-4">
                    <div class="text-white text-2xl">
                        <i class="bi bi-speedometer2 p-2 bg-slate-600 rounded"></i>
                    </div>
                </div>
                <span class="text-xl font-bold tracking-wider">DASHBOARD</span>
            </div>
            <hr class="mt-3">
            @can('generateData', \App\Models\User::class)
                <div class="flex justify-end my-2">
                    <form action="{{ route('generate.evacuee.data') }}" method="POST" target="__blank">
                        @csrf
                        <button typ="submit" class="btn-submit float-right p-2 font-medium">
                            <i class="bi bi-printer pr-2"></i>
                            Generate Report Data
                        </button>
                    </form>
                </div>
            @endcan
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                <div class="widget">
                    <div class="widget-content">
                        <div class="content-description">
                            <div class="wigdet-header">
                                <p>Evacuation Center (Active)</p>
                                <img src="{{ asset('assets/img/evacuation.png') }}">
                            </div>
                            <p>{{ $activeEvacuation }}</p>
                            <span>Total</span>
                        </div>
                    </div>
                </div>
                <div class="widget">
                    <div class="widget-content">
                        <div class="content-description">
                            <div class="wigdet-header">
                                <p>Evacuation Center (In-active)</p>
                                <img src="{{ asset('assets/img/evacuation.png') }}">
                            </div>
                            <p>{{ $inActiveEvacuation }}</p>
                            <span>Total</span>
                        </div>
                    </div>
                </div>
                <div class="widget">
                    <div class="widget-content">
                        <div class="content-description">
                            <div class="wigdet-header">
                                <p>Evacuee (On Evacuation)</p>
                                <img src="{{ asset('assets/img/family.png') }}">
                            </div>
                            <p>{{ $inEvacuationCenter }}</p>
                            <span>Total</span>
                        </div>
                    </div>
                </div>
                <div class="widget">
                    <div class="widget-content">
                        <div class="content-description">
                            <div class="wigdet-header">
                                <p>Evacuee(Returned)</p>
                                <img src="{{ asset('assets/img/family.png') }}">
                            </div>
                            <p>{{ $isReturned }}</p>
                            <span>Total</span>
                        </div>
                    </div>
                </div>
                <div class="widget">
                    <div class="widget-content">
                        <div class="content-description">
                            <div class="wigdet-header">
                                <p>Infants</p>
                                <img src="{{ asset('assets/img/infants.png') }}">
                            </div>
                            <p>{{ $inEvacuationCenter }}</p>
                            <span>Total</span>
                        </div>
                    </div>
                </div>
                <div class="widget">
                    <div class="widget-content">
                        <div class="content-description">
                            <div class="wigdet-header">
                                <p>Minors</p>
                                <img src="{{ asset('assets/img/male&female.png') }}">
                            </div>
                            <p>{{ $inEvacuationCenter }}</p>
                            <span>Total</span>
                        </div>
                    </div>
                </div>
                <div class="widget">
                    <div class="widget-content">
                        <div class="content-description">
                            <div class="wigdet-header">
                                <p>Senior Citizen</p>
                                <img src="{{ asset('assets/img/senior_citizen.png') }}">
                            </div>
                            <p>{{ $inEvacuationCenter }}</p>
                            <span>Total</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    @include('partials.toastr')
</body>

</html>
