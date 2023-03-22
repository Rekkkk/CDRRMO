<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.content.headPackage')
        <link rel="stylesheet" href="{{ asset('assets/css/statistics.css') }}">
        <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <title>{{ config('app.name') }}</title>
    </head>
    <body class="bg-gray-400">
        <div class="wrapper">
            @include('partials.content.header')
            @include('partials.content.sidebar')

            <x-messages />

            <div class="main-content">
                <div class="content-item">
                    <div class="content-header w-full h-full p-3">
                        <div class="text-center">
                            <img id="header-logo-right" src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                            <span class="item-header relative w-full text-white ">Disaster Data Analytics</span>
                            <img id="header-logo-left" src="{{ asset('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                        </div>
                    </div>
                    <div class="w-full p-2">
                        <div class="content-body">
                            <div class="mb-3">
                                <select id="disaster" class="form-select p-2 text-center" >
                                    <option value="">Choose Disaster Type</option>
                                    <option value="typhoon">Typhoon</option>
                                    <option value="roadaccident">Road Accident</option>
                                    <option value="rarthquake">Earthquake</option>
                                    <option value="flooding">Flooding</option>
                                </select>
                            </div>
                            
                        <div id="highchart">
                            <script>
                                $(function(){
                                    var maleData = {{ json_encode($male) }};
                                    var femaleData = {{ json_encode($female) }};

                                    $('#highchart').highcharts({
                                        chart:{
                                            type:'column'
                                        },
                                        title:{
                                            text:'Typhoon Statistics'
                                        },
                                        xAxis:{
                                            categories:['1-18 Years Old', '19-59 Years Old', '60 Above']
                                        },
                                        yAxis:{
                                            title:{
                                                text:'Data'
                                            }
                                        },
                                        series:[{
                                            name:'Male',
                                            data:maleData
                                        },{
                                            name:'female',
                                            data:femaleData
                                        }]
                                    });
                                });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
        <script src="{{ asset('assets/js/landingPage.js') }}"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>