<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <link rel="shortcut icon" href="{{ url('assets/img/CDRRMO-LOGO.png') }}" type="image/png">
        <link rel="stylesheet" href="{{ url('assets/css/theme.css') }}">
        <title>{{ config('app.name') }}</title>
        <script src="//unpkg.com/alpinejs" defer></script>
    </head>
    <body class="bg-gray-400">
        <div class="wrapper">
            <header class="header-section w-full bg-slate-50">
                <div class="container-fluid relative w-full h-full">
                    <div class="w-full h-full relative">
                        <img class="w-24 float-right h-full" src="{{ url('assets/img/CDRRMO-LOGO.png') }}" alt="logo">
                        <span class="float-right h-full text-lg font-semibold">Cabuyao City Disaster Risk<br>Reduction and Management Office</span>
                    </div>
                </div>
            </header>
            <div class="page-wrap">
                <div class="sidebar drop-shadow-2xl fixed left-0 top-0 h-full w-20">
                    <div class="sidebar-heading flex justify-center items-center cursor-pointer text-white ">
                        <span class="links_name">E-LIGTAS</span>
                        <i class="bi bi-list absolute text-white text-center cursor-pointer text-3xl" id="btn-sidebar"></i>
                    </div>
                    <div class="h-full items-center text-center">
                        <x-nav-item />
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="content-item rounded-t-lg">
                    <div class="content-header text-center text-white rounded-t-lg">
                        <div class="text-2xl p-2 w-full h-full">
                            <span>{{ config('app.name') }}</span><br>
                            <span>"E-LIGTAS"</span>
                        </div>
                    </div>
                    <div class="map-section">
                        <div class="w-full" id="map" style="height:600px;"></div>
                    </div>
                </div>
                <div class="map-btn">
                    <button type="button" class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Locate Nearest Evacuation</button>
                    <button type="button" class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Locate Current Location</button>
                </div>
                <div class="evacuation-table mt-5">
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Evacuation Center Name</th>
                                <th scope="col">Location</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Evacuation Center Example 1</td>
                                <td>Pulo</td>
                                <td>
                                    <a href="#" class="btn btn-info">Locate</a>
                                    <a href="#" class="btn btn-warning">Edit</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Evacuation Center Example 2</td>
                                <td>Mamatid</td>
                                <td>
                                    <a href="#" class="btn btn-info">Locate</a>
                                    <a href="#" class="btn btn-warning">Edit</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Evacuation Center Example 3</td>
                                <td>Cabuyao</td>
                                <td>
                                    <a href="#" class="btn btn-info">Locate</a>
                                    <a href="#" class="btn btn-warning">Edit</a>
                                </td>
                            </tr>
                        </tbody>
                      </table>
                </div>
            </div>
        </div>

        <script async src="https://maps.googleapis.com/maps/api/js?key=...&callback=initMap"></script>
        <script>
            let map, activeInfoWindow, markers = [];

            function initMap() {
                map = new google.maps.Map(document.getElementById("map"), {
                    center: { lat: 14.2843, lng: 121.0889},
                    zoom: 15
                });

                map.addListener("click", function(event) {
                    mapClicked(event);
                });

                initMarkers();
            }

            function initMarkers() {
                const initialMarkers = <?php echo json_encode($initialMarkers); ?>;

                for (let index = 0; index < initialMarkers.length; index++) {

                    const markerData = initialMarkers[index];
                    const marker = new google.maps.Marker({
                        position: markerData.position,
                        label: markerData.label,
                        draggable: markerData.draggable,
                        map
                    });
                    markers.push(marker);

                    const infowindow = new google.maps.InfoWindow({
                        content: `<b>${markerData.position.lat}, ${markerData.position.lng}</b>`,
                    });
                    marker.addListener("click", (event) => {
                        if(activeInfoWindow) {
                            activeInfoWindow.close();
                        }
                        infowindow.open({
                            anchor: marker,
                            shouldFocus: false,
                            map
                        });
                        activeInfoWindow = infowindow;
                        markerClicked(marker, index);
                    });

                    marker.addListener("dragend", (event) => {
                        markerDragEnd(event, index);
                    });
                }
            }

            function mapClicked(event) {
                console.log(map);
                console.log(event.latLng.lat(), event.latLng.lng());
            }

            function markerClicked(marker, index) {
                console.log(map);
                console.log(marker.position.lat());
                console.log(marker.position.lng());
            }

            function markerDragEnd(event, index) {
                console.log(map);
                console.log(event.latLng.lat());
                console.log(event.latLng.lng());
            }
        </script>
        <script src="{{ url('assets/js/landingPage.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    </body>
</html>
