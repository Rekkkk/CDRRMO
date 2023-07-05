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
                    <div class="m-auto">
                        <i class="bi bi-speedometer2 text-2xl p-2 bg-slate-600 text-white rounded"></i>
                    </div>
                </div>
                <div>
                    <span class="text-xl font-bold tracking-wider">DASHBOARD</span>
                </div>
            </div>
            <hr class="mt-4">
            <div class="flex justify-end my-3">
                @if (auth()->user()->position == 'President')
                    <form action="{{ route('generate.evacuee.data') }}" method="POST" target="__blank">
                @endif
                @csrf
                <button typ="submit" class="btn-submit float-right p-2 font-medium">
                    <i class="bi bi-printer pr-2"></i>
                    Generate Report Data
                </button>
                </form>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                <div class="widget bg-green-400 drop-shadow-lg rounded max-w-full">
                    <div class="widget-logo flex justify-center items-center">
                        <img class="pt-52" src="{{ asset('assets/img/cdrrmo-logo.png') }}">
                    </div>
                    <div class="content-logo flex justify-between my-3 p-1">
                        <div class="content-description px-2">
                            <h5 class="font-semibold tracking-wide">Evacuation Center (Active)</h5>
                            <span class="text-4xl font-bold">{{ $activeEvacuation }}</span>
                        </div>
                        <div class="content-header rounded">
                            <img src="{{ asset('assets/img/evacuation.png') }}" style="width:3rem;">
                        </div>
                    </div>
                </div>
                <div class="widget bg-red-400 drop-shadow-lg rounded max-w-full">
                    <div class="widget-logo flex justify-center items-center">
                        <img class="pt-52" src="{{ asset('assets/img/cdrrmo-logo.png') }}">
                    </div>
                    <div class="content-logo flex justify-between my-3 p-1">
                        <div class="content-description px-2">
                            <h5 class="font-semibold tracking-wide">Evacuation Center (Inactive)</h5>
                            <span class="text-4xl font-bold">{{ $inActiveEvacuation }} </span>
                        </div>
                        <div class="content-header rounded">
                            <img src="{{ asset('assets/img/evacuation.png') }}" style="width:3rem;">
                        </div>
                    </div>
                </div>
                <div class="widget bg-yellow-300 drop-shadow-lg rounded max-w-full">
                    <div class="widget-logo flex justify-center items-center">
                        <img class="pt-52" src="{{ asset('assets/img/cdrrmo-logo.png') }}">
                    </div>
                    <div class="content-logo flex justify-between my-3 p-1">
                        <div class="content-description px-2">
                            <h5 class="font-semibold tracking-wide">Evacuee (On Evacuation Center)</h5>
                            <span class="text-4xl font-bold" id="onEvacuationCenter">{{ $inEvacuationCenter }}</span>
                        </div>
                        <div class="content-header rounded">
                            <img src="{{ asset('assets/img/family.png') }}" style="width:3rem;">
                        </div>
                    </div>
                </div>
                <div class="widget bg-blue-300 drop-shadow-lg rounded max-w-full">
                    <div class="widget-logo flex justify-center items-center">
                        <img class="pt-52" src="{{ asset('assets/img/cdrrmo-logo.png') }}">
                    </div>
                    <div class="content-logo flex justify-between my-3 p-1">
                        <div class="content-description px-2">
                            <h5 class="font-semibold tracking-wide">Evacuee(Returned)</h5>
                            <span class="text-4xl font-bold">{{ $isReturned }}</span>
                        </div>
                        <div class="content-header rounded">
                            <img src="{{ asset('assets/img/family.png') }}" style="width:3rem;">
                        </div>
                    </div>
                </div>
            </div>
            <figure class="pie-chart-container mb-3 mt-5">
                <div id="Typhoon" class="bg-slate-50 rounded shadow-lg mr-3"></div>
                <div id="TyphoonBarGraph" class="bg-slate-200 rounded shadow-lg flex-1"></div>
            </figure>
            <figure class="pie-chart-container mb-3">
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
