<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.content.headPackage')
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <title>{{ config('app.name') }}</title>
</head>

<body>
    <div class="wrapper">

        @include('partials.content.header')
        @include('partials.content.sidebar')

        <x-messages />

        <div class="statistics-content pt-8 pr-8 pl-28">

            <div class="dashboard-logo pb-4">
                <i class="bi bi-graph-up text-2xl p-2 bg-slate-900 text-white rounded"></i>
                <span class="text-2xl font-bold tracking-wider mx-2">DISASTER STATICSTICS</span>
                <hr class="mt-4">
            </div>

            <div class="statistics-board my-8 bg-slate-50 drop-shadow-2xl">
                <div class="content-header p-3 bg-red-900">
                    <div class="text-center">
                        <img class="float-right w-8" id="header-logo-right" src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                        <span class="item-header relative w-full text-white text-xl">Disaster Data Statistics</span>
                        <img class="float-left w-8" id="header-logo-left" src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                    </div>
                </div>
                <div class="w-full p-2">
                    <div class="content-body">
                        <div class="mb-3">
                            <select id="disaster" class="form-select p-2 text-center">
                                <option value="">Choose Disaster Type</option>
                                <option value="Typhoon">Typhoon</option>
                                <option value="Road Accident">Road Accident</option>
                                <option value="Earthquake">Earthquake</option>
                                <option value="Flooding">Flooding</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="graph-section flex">
                <figure class="pie-chart-container">
                    <div id="Typhoon" class="chart mb-5"></div>
                    <div id="Earthquake" class="chart mb-3"></div>
                    <div id="RoadAccident" class="chart mb-3"></div>
                    <div id="Flooding" class="chart mb-3"></div>
                </figure>
            </div>
            
        </div>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            const charts = ["Typhoon", "Road Accident", "Earthquake", "Flooding"];

            document.getElementById('disaster').addEventListener('change', (event) => {

                const selectForm = event.target.value;

                charts.forEach((formId) => {

                    const form = document.getElementById(formId);

                    if (selectForm == formId) {
                        form.style.opacity = 1;
                        form.style.display = "contents";
                    } else {
                        form.style.opacity = 0;
                        form.style.display = "none";
                    }

                });
            });

            var typhoonMaleData = {{ Js::from($typhoonMaleData) }};
            var typhoonFemaleData = {{ Js::from($typhoonFemaleData) }};
            var earthquakeMaleData = {{ Js::from($earthquakeMaleData) }};
            var earthquakeFemaleData = {{ Js::from($earthquakeFemaleData) }};
            var roadAccidentMaleData = {{ Js::from($roadAccidentMaleData) }};
            var roadAccidentFemaleData = {{ Js::from($roadAccidentFemaleData) }};
            var floodingMaleData = {{ Js::from($floodingMaleData) }};
            var floodingFemaleData = {{ Js::from($floodingFemaleData) }};

            Highcharts.chart('Typhoon', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie',
                    backgroundColor: null,
                },
                title: {
                    text: 'Typhoon',
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    name: 'Evacuee',
                    colorByPoint: true,
                    data: [{
                        name: 'Male',
                        y: typhoonMaleData.length,
                        color: '#850000'
                    }, {
                        name: 'Female',
                        y: typhoonFemaleData.length,
                        color: '#0E1624'
                    }]
                }],
            });

            Highcharts.chart('Earthquake', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie',
                    backgroundColor: null,
                },
                title: {
                    text: 'Earthquake',
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    name: 'Evacuee',
                    colorByPoint: true,
                    data: [{
                        name: 'Male',
                        y: earthquakeMaleData.length,
                        color: '#850000'
                    }, {
                        name: 'Female',
                        y: earthquakeFemaleData.length,
                        color: '#0E1624'
                    }]
                }]
            });

            Highcharts.chart('Road Accident', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie',
                    backgroundColor: null,
                },
                title: {
                    text: 'Road Accident',
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    name: 'Evacuee',
                    colorByPoint: true,
                    data: [{
                        name: 'Male',
                        y: roadAccidentMaleData.length,
                        color: '#850000'
                    }, {
                        name: 'Female',
                        y: roadAccidentFemaleData.length,
                        color: '#0E1624'
                    }]
                }]
            });

            Highcharts.chart('Flooding', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie',
                    backgroundColor: null,
                },
                title: {
                    text: 'Flooding',
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    name: 'Evacuee',
                    colorByPoint: true,
                    data: [{
                        name: 'Male',
                        y: floodingMaleData.length,
                        color: '#850000'
                    }, {
                        name: 'Female',
                        y: floodingFemaleData.length,
                        color: '#0E1624'
                    }]
                }]
            });
        })
    </script>
</body>

</html>
