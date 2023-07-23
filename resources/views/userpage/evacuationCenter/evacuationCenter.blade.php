<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.headPackage')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
</head>

<body>
    <div class="wrapper">
        @include('partials.header')
        @include('partials.sidebar')
        <div class="main-content">
            <div class="grid grid-cols-1">
                <div class="grid col-end-1">
                    <div class="text-2xl text-white">
                        <i class="bi bi-house p-2 bg-slate-600"></i>
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
            <div class="flex justify-end my-3">
                <button type="button" class="btn-submit bg-green-600 p-2 mr-3" id="locateNearestBtn">
                    <i class="bi bi-search pr-2"></i>
                    Locate Nearest Evacuation</button>
                <button type="button" class="btn-cancel bg-red-600 p-2 rounded" id="locateCurrentLocationBtn">
                    <i class="bi bi-pin-map-fill pr-2"></i>
                    Locate Current Location</button>
            </div>
            <div class="table-container p-3 bg-slate-50 shadow-lg rounded-lg">
                <div class="block w-full overflow-auto">
                    <header class="text-2xl font-semibold mb-3">Evacuation Centers</header>
                    <table class="table evacuationCenterTable" width="100%">
                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Barangay</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Status</th>
                                <th class="w-4">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @auth
        @include('userpage.changePasswordModal')
    @endauth
    @include('partials.toastr')
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.googleMap.key') }}&callback=initMap&v=weekly"
        defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script>
        let map, activeInfoWindow;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: 14.242311,
                    lng: 121.12772
                },
                zoom: 13,
                clickableIcons: false,
                mapTypeId: 'terrain',
                styles: mapTypeStyleArray
            });

            const evacuationCenters = @json($evacuationCenters);

            for (let evacuationCenter of evacuationCenters) {

                let picture = evacuationCenter.status == 'Active' ? "evacMarkerActive" : "evacMarkerInactive"
                picture = evacuationCenter.status == 'Full' ? "evacMarkerFull" : picture

                let marker = new google.maps.Marker({
                    position: {
                        lat: parseFloat(evacuationCenter.latitude),
                        lng: parseFloat(evacuationCenter.longitude)
                    },
                    map,
                    icon: {
                        url: "{{ asset('assets/img/picture.png') }}".replace('picture', picture),
                        scaledSize: new google.maps.Size(35, 35),
                    }
                });

                let infowindow = new google.maps.InfoWindow({
                    content: `<b>Name:</b> ${evacuationCenter.name} <br>
                              <b>Barangay:</b> ${evacuationCenter.barangay_name} <br>
                              <b>Satus:</b> ${evacuationCenter.status}`
                });

                marker.addListener("click", () => {
                    if (activeInfoWindow) {
                        activeInfoWindow.close();
                    }

                    infowindow.open({
                        anchor: marker,
                        shouldFocus: false,
                        map
                    });
                    activeInfoWindow = infowindow;
                    map.setCenter(marker.getPosition());
                });
            }
        }

        $(document).ready(function() {
            let url;

            '{{ $prefix }}' == 'resident' ?
            url = "{{ route('resident.evacuation.center.get', 'locator') }}":
                url = "{{ route('evacuation.center.get', 'locator') }}";

            let evacuationCenterTable = $('.evacuationCenterTable').DataTable({
                order: [
                    [1, 'asc']
                ],
                language: {
                    emptyTable: 'No available evacuation center yet',
                },
                responsive: true,
                processing: false,
                serverSide: true,
                ajax: url,
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'barangay_name',
                        name: 'barangay_name'
                    },
                    {
                        data: 'latitude',
                        name: 'latitude',
                        visible: false
                    },
                    {
                        data: 'longitude',
                        name: 'longitude',
                        visible: false
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#locateCurrentLocationBtn').click(function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        let pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        console.log(pos)

                        let userMarker = new google.maps.Marker({
                            position: pos,
                            map,
                            icon: {
                                url: "{{ asset('assets/img/userMarker.png') }}",
                                scaledSize: new google.maps.Size(35, 35),
                            }
                        });

                        map.setCenter(pos);
                    }, function() {
                        toastr.error('Error: The Geolocation service failed.');
                    });
                } else {
                    toastr.error('Your browser does not support geolocation');
                }
            });
        });
    </script>

</body>

</html>
