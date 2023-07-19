<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.headPackage')
</head>

<body>
    <div class="wrapper">
        @include('sweetalert::alert')
        @include('partials.header')
        @include('partials.sidebar')
        <div class="main-content">
            <div class="grid grid-cols-1">
                <div class="grid col-end-1">
                    <div class="text-2xl text-white">
                        <i class="bi bi-house p-2 bg-slate-600 rounded"></i>
                    </div>
                </div>
                <span class="text-xl font-bold">EVACUATION CENTER LOCATOR</span>
            </div>
            <hr class="mt-4">
            <div class="locator-content my-3">
                <div class="locator-header text-center text-white h-22 bg-red-600 rounded-t">
                    <div class="text-2xl py-3">
                        <span>Cabuyao City Map</span>
                    </div>
                </div>
                <div class="map-section border-2 border-red-600 rounded-b-md">
                    <div class="w-full rounded-b-md" id="map" style="height:600px;"></div>
                </div>
            </div>
            <div class="map-btn text-white my-3">
                @guest
                    <button type="button" class="btn-submit bg-green-600 p-2 mr-3">Locate
                        Nearest Evacuation</button>
                    <button type="button" class="btn-cancel bg-red-600 p-2 rounded">Locate
                        Current Location</button>
                @endguest
            </div>
            <div class="evacuation-table">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Evacuation Center Name</th>
                            <th scope="col">Barangay Name</th>
                            <th scope="col">Latitude</th>
                            <th scope="col">Longitude</th>
                            <th scope="col" colspan="2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($evacuationCenter as $evacuationCenterList)
                            <tr>
                                <td>{{ $evacuationCenterList->name }}</td>
                                <td>{{ $evacuationCenterList->barangay_name }}</td>
                                <td>{{ $evacuationCenterList->latitude }}</td>
                                <td>{{ $evacuationCenterList->longitude }}</td>
                                <td>{{ $evacuationCenterList->status }}</td>
                                @guest
                                    <td>
                                        <a href="#" class="btn-table-remove p-2">Locate</a>
                                    </td>
                                @endguest
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-center" colspan="4">
                                    No Evacuation Center Record Found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @auth
            @include('userpage.changePasswordModal')
        @endauth
    </div>

    <script src="{{ asset('assets/js/sidebar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.googleMap.key') }}&callback=initMap&v=weekly"
        defer></script>
    @can('view', \App\Models\User::class)
        <script src="{{ asset('assets/js/script.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
            integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
            crossorigin="anonymous"></script>
        @include('partials.toastr')
    @endcan
    <script>
        let map, activeInfoWindow, markers = [];

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: 14.242311,
                    lng: 121.12772
                },
                zoom: 14
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
                    if (activeInfoWindow) {
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
</body>

</html>
