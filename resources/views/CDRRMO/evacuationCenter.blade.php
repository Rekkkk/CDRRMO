<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.content.headPackage')
        <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
        <title>{{ config('app.name') }}</title>
    </head>
    <body class="bg-gray-400">
        <div class="wrapper">
            @include('partials.content.header')
            @include('partials.content.sidebar')
            
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

        @auth
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
        @endauth
        <script src="{{ asset('assets/js/landingPage.js') }}"></script>
        @include('partials.content.footerPackage')
    </body>
</html>
