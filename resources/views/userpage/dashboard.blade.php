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
            <div class="label-container">
                <div class="icon-container">
                    <div class="icon-content">
                        <i class="bi bi-speedometer2"></i>
                    </div>
                </div>
                <span>DASHBOARD</span>
            </div>
            <hr>
            <div class="report-container">
                <p>Current Disaster:
                    <span>{{ $onGoingDisasters->isEmpty() ? 'No Disaster' : implode(' | ', $onGoingDisasters->pluck('name')->toArray()) }}</span>
                </p>
                @if (auth()->user()->position == 'President' || auth()->user()->position == 'Focal')
                    <div class="generate-button-container">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#generateReportModal"
                            class="btn-submit generateBtn">
                            <i class="bi bi-printer"></i>
                            Generate Report Data
                        </button>
                        <div class="modal fade" id="generateReportModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-label-container bg-success">
                                        <h1 class="modal-label">Generate Excel Report</h1>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('generate.evacuee.data') }}" method="POST"
                                            id="generateReportForm">
                                            @csrf
                                            <div class="form-content">
                                                <div class="field-container">
                                                    <label>Disaster Status</label>
                                                    <select name="select_status" id="select_status" class="form-select">
                                                        <option value="" hidden disabled selected>Select Status
                                                        </option>
                                                        <option value="Inactive">Inactive</option>
                                                        <option value="On Going">On Going</option>
                                                    </select>
                                                </div>
                                                <div class="field-container" id="inactive_disaster" hidden>
                                                    <label>Inactive Disaster</label>
                                                    <select name="disaster_id" class="form-select">
                                                        <option value="" hidden disabled selected>Select Disaster
                                                        </option>
                                                        @foreach ($inactiveDisasters as $disaster)
                                                            <option value="{{ Crypt::encryptString($disaster->id) }}">
                                                                {{ $disaster->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="field-container" id="on_going_disaster" hidden>
                                                    <label>On Going Disaster</label>
                                                    <select name="disaster_id" class="form-select">
                                                        <option value="" hidden disabled selected>Select Disaster
                                                        </option>
                                                        @foreach ($onGoingDisasters as $disaster)
                                                            <option value="{{ Crypt::encryptString($disaster->id) }}">
                                                                {{ $disaster->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-button-container">
                                                <button class="btn-submit">Generate</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="widget-container">
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
            @foreach ($onGoingDisasters as $count => $disaster)
                <figure class="chart-container">
                    <div id="evacueePie{{ $count + 1 }}" class="pie-chart"></div>
                    <div id="evacueeGraph{{ $count + 1 }}" class="bar-graph"></div>
                </figure>
            @endforeach
        </div>
        @include('userpage.changePasswordModal')
    </div>

    @include('partials.script')
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
            let onGoingDisaster = $('#on_going_disaster'),
                inactiveDisaster = $('#inactive_disaster');

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
                    plotOptions: {
                        pie: {
                            dataLabels: {
                                enabled: true,
                                style: {
                                    textOutline: 'none'
                                }
                            }
                        }
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
                    exporting: false,
                    credits: {
                        enabled: false
                    },
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
                        bar: {
                            dataLabels: {
                                enabled: true,
                                style: {
                                    textOutline: 'none'
                                }
                            }
                        },
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
                    exporting: false,
                    credits: {
                        enabled: false
                    },
                });
            @endforeach

            let validator = $("#generateReportForm").validate({
                rules: {
                    select_status: 'required',
                    disaster_id: 'required'
                },
                messages: {
                    select_status: 'Please select status.',
                    disaster_id: 'Please select disaster.'
                },
                errorElement: 'span'
            });

            $(document).on('change', '#select_status', function() {
                let isActive = $(this).val() !== "Inactive";
                onGoingDisaster.prop('hidden', !isActive);
                inactiveDisaster.prop('hidden', isActive);
            });

            $('#generateReportModal').on('hidden.bs.modal', function() {
                onGoingDisaster.add(inactiveDisaster).prop('hidden', true);
                $('#generateReportForm').trigger("reset");
            });

            // Echo.channel('active-evacuees').listen('ActiveEvacuees', (e) => {
            //     $("#totalEvacuee").text(e.activeEvacuees);
            // })
        });
    </script>
</body>

</html>
