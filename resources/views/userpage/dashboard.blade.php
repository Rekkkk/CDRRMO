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
                <div class="grid col-end-1">
                    <div class="text-white text-2xl">
                        <i class="bi bi-speedometer2 p-2 bg-slate-600"></i>
                    </div>
                </div>
                <span class="text-xl font-bold">DASHBOARD</span>
            </div>
            <hr class="mt-4">
            @if (auth()->user()->position == 'President' || auth()->user()->position == 'Focal')
                <div class="report-container">
                    <p class="font-semibold tracking-wider"> Current Disaster:
                        @foreach ($onGoingDisaster as $disasters)
                            <span class="text-red-600 font-black">{{ $disasters->name }},</span>
                        @endforeach
                    </p>
                    <div class=" flex justify-end">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#generateReportModal"
                            class="btn-submit mt-1 bg-green-600">
                            <i class="bi bi-printer pr-2"></i>
                            Generate Report Data
                        </button>
                    </div>
                </div>
            @endif
            <div class="grid grid-cols-1 mt-3 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
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
                            <p id="totalEvacuee">{{ $totalEvacuee }}</p>
                            <span>Total</span>
                        </div>
                    </div>
                </div>
            </div>
            @foreach ($onGoingDisaster as $count => $disaster)
                <figure class="chart-container my-4">
                    <div id="evacueePie{{ $count + 1 }}" class="pie-chart bg-slate-50 rounded shadow-lg mr-5"></div>
                    <div id="evacueeGraph{{ $count + 1 }}" class="bar-graph bg-slate-200 rounded shadow-lg flex-1">
                    </div>
                </figure>
            @endforeach
        </div>
        @include('userpage.changePasswordModal')
        <div class="modal fade" id="generateReportModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header justify-center bg-green-600">
                        <h1 class="modal-title fs-5 text-white font-extrabold">Generate Excel Report</h1>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('generate.evacuee.data') }}" method="POST" id="generateReportForm">
                            @csrf
                            <div class="bg-slate-50 pt-3 pb-2 rounded">
                                <div class="flex-auto">
                                    <div class="flex flex-wrap">
                                        <div class="field-container mb-3">
                                            <label>On Going Disaster</label>
                                            <select name="disaster_id" id="disaster_id" class="form-select">
                                                <option value="" hidden disabled selected>Select Disaster
                                                </option>
                                                @foreach ($onGoingDisaster as $disaster)
                                                    <option value="{{ $disaster->id }}">
                                                        {{ $disaster->name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="w-full px-4 py-2">
                                            <button type="submit"
                                                class="btn-submit bg-green-600 p-2 float-right">Generate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
        integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
        crossorigin="anonymous"></script>
    @include('partials.toastr')
    <script>
        $(document).ready(function() {
            @foreach ($disasterData as $count => $disaster)
                Highcharts.chart('evacueePie{{ $count + 1 }}', {
                    chart: {
                        type: 'pie'
                    },
                    title: {
                        text: '{{ $disaster['disasterName'] }}'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.y}</b>'
                    },
                    series: [{
                        name: 'Evacuee',
                        colorByPoint: true,
                        data: [{
                            name: 'Male',
                            y: {{ intval($disaster['totalMale']) }},
                            color: '#0284c7'
                        }, {
                            name: 'Female',
                            y: {{ intval($disaster['totalFemale']) }},
                            color: '#f43f5e'
                        }]
                    }],
                    exporting: false
                });

                Highcharts.chart('evacueeGraph{{ $count + 1 }}', {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: '{{ $disaster['disasterName'] }} Statistics'
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
                        data: [{{ intval($disaster['totalSeniorCitizen']) }}, '', '', '', '', ''],
                        color: '#e74c3c'
                    }, {
                        name: 'MINORS',
                        data: ['', {{ intval($disaster['totalMinors']) }}, '', '', '', ''],
                        color: '#3498db'
                    }, {
                        name: 'INFANTS',
                        data: ['', '', {{ intval($disaster['totalInfants']) }}, '', '', ''],
                        color: '#2ecc71'
                    }, {
                        name: 'PWD',
                        data: ['', '', '', {{ intval($disaster['totalPwd']) }}, '', ''],
                        color: '#1abc9c'
                    }, {
                        name: 'PREGNANT',
                        data: ['', '', '', '', {{ intval($disaster['totalPregnant']) }}, ''],
                        color: '#e67e22'
                    }, {
                        name: 'LACTATING',
                        data: ['', '', '', '', '', {{ intval($disaster['totalLactating']) }}],
                        color: '#9b59b6'
                    }],
                    exporting: false
                });
            @endforeach

            let validator = $("#generateReportForm").validate({
                rules: {
                    disaster_id: {
                        required: true
                    }
                },
                messages: {
                    disaster_id: {
                        required: 'Please select disaster.'
                    }
                },
                errorElement: 'span'
            });

            $('#generateReportModal').on('hidden.bs.modal', function() {
                validator.resetForm();
                $('#generateReportForm')[0].reset();
            });

        });
    </script>
    {{-- <script>
        window.addEventListener('DOMContentLoaded', function(e) {
            Echo.channel('active-evacuees').listen('ActiveEvacuees', (e) => {
                $("#totalEvacuee").text(e.activeEvacuees);
            })
        });
    </script> --}}
</body>

</html>
