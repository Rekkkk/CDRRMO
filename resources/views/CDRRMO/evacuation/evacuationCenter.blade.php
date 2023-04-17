<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.content.headPackage')
        <link rel="stylesheet" href="{{ asset('assets/css/evacuation-css/evacuationCenter.css') }}">
        <title>{{ config('app.name') }}</title>
    </head>
    <body class="bg-gray-400">
        <div class="wrapper">
            
            @include('partials.content.header')
            @include('partials.content.sidebar')
            
            <div class="main-content">

                <div class="dashboard-logo pb-4">
                    <i class="bi bi-house text-2xl px-2 bg-slate-900 text-white rounded py-2"></i>
                    <span class="text-2xl font-bold tracking-wider mx-2">EVACUATION CENTER</span>
                    <hr class="mt-4">
                </div>

                <div class="content-item">
                    <div class="content-header text-center text-white">
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
                    <button type="button" class="bg-slate-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Locate Nearest Evacuation</button>
                    <button type="button" class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Locate Current Location</button>
                </div>
                <div class="evacuation-table mt-5">
                    <table class="table bg-slate-50">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Evacuation Center Name</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($evacuation as $evacuationList)
                            <tr>
                                <th>{{ $evacuationList->evacuation_id }}</th>
                                <td>{{ $evacuationList->evacuation_name }}</td>
                                <td>{{ $evacuationList->evacuation_contact }}</td>
                                <td>{{ $evacuationList->evacuation_location }}</td>
                                <td>
                                    <a href="#" class="bg-red-700 text-white p-2 py-2 rounded shadow-lg hover:shadow-xl transition duration-200">Locate</a>
                                </td>
                            </tr>
                            @endforeach
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
                    center: { lat: 14.242311, lng: 121.12772},
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
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    
    </body>
</html>
