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
            @if (auth()->user()->position == 'President')
                <div class="flex justify-end my-2">
                    <form action="{{ route('generate.evacuee.data') }}" method="POST" target="__blank">
                        @csrf
                        <button typ="submit" class="btn-submit float-right p-2 font-medium">
                            <i class="bi bi-printer pr-2"></i>
                            Generate Report Data
                        </button>
                    </form>
                </div>
            @endif
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                <div class="widget bg-green-400">
                    <div class="widget-logo">
                        <img src="{{ asset('assets/img/cdrrmo-logo.png') }}">
                    </div>
                    <div class="widget-content">
                        <div class="content-description">
                            <h5>Evacuation Center (Active)</h5>
                            <span>{{ $activeEvacuation }}</span>
                        </div>
                        <div class="widget-image">
                            <img src="{{ asset('assets/img/evacuation.png') }}">
                        </div>
                    </div>
                </div>
                <div class="widget bg-red-400">
                    <div class="widget-logo">
                        <img src="{{ asset('assets/img/cdrrmo-logo.png') }}">
                    </div>
                    <div class="widget-content">
                        <div class="content-description">
                            <h5>Evacuation Center (Inactive)</h5>
                            <span>{{ $inActiveEvacuation }} </span>
                        </div>
                        <div class="widget-image">
                            <img src="{{ asset('assets/img/evacuation.png') }}">
                        </div>
                    </div>
                </div>
                <div class="widget bg-yellow-300">
                    <div class="widget-logo">
                        <img src="{{ asset('assets/img/cdrrmo-logo.png') }}">
                    </div>
                    <div class="widget-content">
                        <div class="content-description">
                            <h5>Evacuee (On Evacuation Center)</h5>
                            <span id="onEvacuationCenter">{{ $inEvacuationCenter }}</span>
                        </div>
                        <div class="widget-image">
                            <img src="{{ asset('assets/img/family.png') }}">
                        </div>
                    </div>
                </div>
                <div class="widget bg-blue-300">
                    <div class="widget-logo">
                        <img src="{{ asset('assets/img/cdrrmo-logo.png') }}">
                    </div>
                    <div class="widget-content">
                        <div class="content-description">
                            <h5>Evacuee(Returned)</h5>
                            <span>{{ $isReturned }}</span>
                        </div>
                        <div class="widget-image">
                            <img src="{{ asset('assets/img/family.png') }}">
                        </div>
                    </div>
                </div>
            </div>
            <figure class="pie-chart-container">
                <div id="Typhoon" class="bg-slate-50 rounded shadow-lg mr-3"></div>
                <div id="TyphoonBarGraph" class="bg-slate-200 rounded shadow-lg flex-1"></div>
            </figure>
            <figure class="pie-chart-container">
                <div id="Flashflood" class="bg-slate-50 rounded shadow-lg mr-3"></div>
                <div id="FlashfloodBarGraph" class="bg-slate-200 rounded shadow-lg flex-1"></div>
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
                    text: 'Typhoon'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                series: [{
                    name: 'Evacuee',
                    colorByPoint: true,
                    data: [{
                        name: 'Male',
                        y: {{ Js::from($typhoonMaleData) }},
                        color: '#dc2626'
                    }, {
                        name: 'Female',
                        y: {{ Js::from($typhoonFemaleData) }},
                        color: '#2c3e50'
                    }]
                }],
            });

            Highcharts.chart('TyphoonBarGraph', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Typhoon Evacuee Statistics'
                },
                xAxis: {
                    categories: ['4Ps', 'PWD', 'Pregnant', 'Lactating', 'Student', 'Working'],
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
                    name: '4Ps',
                    data: [{{ Js::from($typhoon4Ps) }}, '', '', '', '', ''],
                    color: '#e74c3c'
                }, {
                    name: 'PWD',
                    data: ['', {{ Js::from($typhoonPWD) }}, '', '', '', ''],
                    color: '#3498db'
                }, {
                    name: 'Pregnant',
                    data: ['', '', {{ Js::from($typhoonPregnant) }}, '', '', ''],
                    color: '#2ecc71'
                }, {
                    name: 'Lactating',
                    data: ['', '', '', {{ Js::from($typhoonLactating) }}, '', ''],
                    color: '#1abc9c'
                }, {
                    name: 'Student',
                    data: ['', '', '', '', {{ Js::from($typhoonStudent) }}, ''],
                    color: '#e67e22'
                }, {
                    name: 'Working',
                    data: ['', '', '', '', '', {{ Js::from($typhoonWorking) }}],
                    color: '#9b59b6'
                }]
            });

            Highcharts.chart('Flashflood', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Flashflood'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                series: [{
                    name: 'Evacuee',
                    colorByPoint: true,
                    data: [{
                        name: 'Male',
                        y: {{ Js::from($floodingMaleData) }},
                        color: '#dc2626'
                    }, {
                        name: 'Female',
                        y: {{ Js::from($floodingFemaleData) }},
                        color: '#2c3e50'
                    }]
                }]
            });

            Highcharts.chart('FlashfloodBarGraph', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Flashflood Evacuee Statistics'
                },
                xAxis: {
                    categories: ['4Ps', 'PWD', 'Pregnant', 'Lactating', 'Student', 'Working']
                },
                yAxis: {
                    allowDecimals: false,
                    title: {
                        text: 'Estimated Numbers'
                    }
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
                    name: '4Ps',
                    data: [{{ Js::from($flooding4Ps) }}, '', '', '', '', ''],
                    color: '#e74c3c'
                }, {
                    name: 'PWD',
                    data: ['', {{ Js::from($floodingPWD) }}, '', '', '', ''],
                    color: '#3498db'
                }, {
                    name: 'Pregnant',
                    data: ['', '', {{ Js::from($floodingPregnant) }}, '', '', ''],
                    color: '#2ecc71'
                }, {
                    name: 'Lactating',
                    data: ['', '', '', {{ Js::from($floodingLactating) }}, '', ''],
                    color: '#1abc9c'
                }, {
                    name: 'Student',
                    data: ['', '', '', '', {{ Js::from($floodingStudent) }}, ''],
                    color: '#e67e22'
                }, {
                    name: 'Working',
                    data: ['', '', '', '', '', {{ Js::from($floodingWorking) }}],
                    color: '#9b59b6'
                }]
            });

            // Echo.channel('active-evacuees').listen('ActiveEvacuees', (e) => {
            //     document.getElementById('onEvacuationCenter').innerHTML = e.activeEvacuees;
            // })
        });
    </script>
</body>

</html>
