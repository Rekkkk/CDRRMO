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
                <span class="text-xl font-bold ml-2">DASHBOARD</span>
            </div>
            <hr class="mt-4">
            @can('generateData', \App\Models\User::class)
                <div class="flex justify-between my-3">
                    <p class="font-bold tracking-wider"> Current Disaster: 
                    @foreach ($onGoingDisaster as $disasters)
                       {{ $disasters->name }},
                    @endforeach
                    </p>
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
                                <p>Evacuee (On Evacuation)</p>
                                <img src="{{ asset('assets/img/family.png') }}">
                            </div>
                            <p>{{ $inEvacuationCenter }}</p>
                            <span>Total</span>
                        </div>
                    </div>
                </div>
            </div>
            <figure class="chart-container my-4">
                <div id="Typhoon" class="bg-slate-50 rounded shadow-lg mr-3"></div>
                <div id="evacueeGraph" class="bg-slate-200 rounded shadow-lg flex-1"></div>
            </figure>
        </div>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    @include('partials.toastr')
    <script>
        $(document).ready(function() {
            Highcharts.chart('Typhoon', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Paeng'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                series: [{
                    name: 'Evacuee',
                    colorByPoint: true,
                    data: [{
                        name: 'Male',
                        y: {{ Js::from($activeEvacuation) }},
                        color: '#0284c7'
                    }, {
                        name: 'Female',
                        y: {{ Js::from($activeEvacuation) }},
                        color: '#f43f5e'
                    }]
                }],
            });

            Highcharts.chart('evacueeGraph', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Current Disaster Statistics'
                },
                xAxis: {
                    categories: ['SENIOR CITIZEN', 'MINORS', 'INFANTS', 'PWD', 'PREGNANT', 'LACTATING'],
                },
                yAxis: {
                    allowDecimals: false,
                    title: {
                        text: 'Estimated Numbers'
                    },
                },
                legend: {
                    reversed: true
                },
                plotOptions: {
                    series: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: true,
                            formatter: function() {
                                if (this.y != 0) {
                                    return this.y;
                                } else {
                                    return null;
                                }
                            }
                        }
                    }
                },
                series: [{
                    name: 'SENIOR CITIZEN',
                    data: [{{ Js::from($activeEvacuation) }}, '', '', '', '', ''],
                    color: '#e74c3c'
                }, {
                    name: 'MINORS',
                    data: ['', {{ Js::from($activeEvacuation) }}, '', '', '', ''],
                    color: '#3498db'
                }, {
                    name: 'INFANTS',
                    data: ['', '', {{ Js::from($activeEvacuation) }}, '', '', ''],
                    color: '#2ecc71'
                }, {
                    name: 'PWD',
                    data: ['', '', '', {{ Js::from($activeEvacuation) }}, '', ''],
                    color: '#1abc9c'
                }, {
                    name: 'PREGNANT',
                    data: ['', '', '', '', {{ Js::from($activeEvacuation) }}, ''],
                    color: '#e67e22'
                }, {
                    name: 'LACTATING',
                    data: ['', '', '', '', '', {{ Js::from($activeEvacuation) }}],
                    color: '#9b59b6'
                }]
            });
        });
    </script>
</body>

</html>
