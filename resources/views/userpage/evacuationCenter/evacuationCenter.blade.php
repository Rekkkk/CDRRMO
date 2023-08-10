<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.headPackage')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
</head>

<body>
    <div class="wrapper">
        @include('partials.header')
        @include('partials.sidebar')
        <div class="main-content">
            <div class="label-container">
                <div class="icon-container">
                    <div class="icon-content">
                        <i class="bi bi-house"></i>
                    </div>
                </div>
                <span>EVACUATION CENTER LOCATOR</span>
            </div>
            <hr>
            <div class="locator-content">
                <div class="locator-header">
                    <div class="header-title">
                        <span>Cabuyao City Map</span>
                    </div>
                </div>
                <div class="map-section">
                    <div class="locator-map" id="map"></div>
                </div>
            </div>
            <div class="page-button-container">
                <button type="button" class="mr-3" id="locateNearestBtn" disabled>
                    <i class="bi bi-search"></i>
                    Locate Nearest Active Evacuation</button>
                <button type="button" id="locateCurrentLocationBtn">
                    <i class="bi bi-geo-fill"></i>
                    Locate Current Location</button>
            </div>
            <div class="table-container">
                <div class="table-content">
                    <header class="table-label">Evacuation Centers</header>
                    <table class="table evacuationCenterTable" width="100%">
                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Barangay</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Capacity</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @auth
        @include('userpage.changePasswordModal')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
            integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
            crossorigin="anonymous"></script>
    @endauth
    @include('partials.script')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.googleMap.key') }}&callback=initMap&v=weekly"
        defer></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    @include('partials.toastr')
    <script>
        let map, activeInfoWindow, userMarker, userBounds, evacuationCentersData,
            evacuationCenterTable, directionDisplay, directionService,
            evacuationCenterJson = [],
            intervalId = null,
            locating = false;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: 14.242311,
                    lng: 121.12772
                },
                zoom: 13,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                }
            });

            directionService = new google.maps.DirectionsService();
            directionDisplay = new google.maps.DirectionsRenderer({
                map: map,
                suppressMarkers: true,
                markerOptions: {
                    icon: {
                        url: "{{ asset('assets/img/userMarker.png') }}",
                        scaledSize: new google.maps.Size(35, 35),
                    },
                },
            });

            const buttonContainer = document.createElement('div');
            buttonContainer.className = 'stop-btn-container';
            buttonContainer.innerHTML = `<button id="stopLocatingBtn" class="btn-remove">Stop Locating</button>`;

            map.controls[google.maps.ControlPosition.TOP_RIGHT].push(buttonContainer);
        }

        function initMarkers(evacuationCenters) {
            evacuationCenters.forEach(evacuationCenter => {
                let picture = evacuationCenter.status == 'Active' ?
                    "evacMarkerActive" : evacuationCenter.status == 'Full' ?
                    "evacMarkerFull" : "evacMarkerInactive";

                generateInfoWindow(
                    generateMarker({
                        lat: parseFloat(evacuationCenter.latitude),
                        lng: parseFloat(evacuationCenter.longitude)
                    }, "{{ asset('assets/img/picture.png') }}".replace('picture', picture)),
                    `<div class="info-window-container">
                        <div class="info-description">
                            <span>Name:</span> ${evacuationCenter.name}
                        </div>
                        <div class="info-description">
                            <span>Barangay:</span> ${evacuationCenter.barangay_name}
                        </div>
                        <div class="info-description">
                            <span>Capacity:</span> ${evacuationCenter.capacity}
                        </div>
                        <div class="info-description">
                            <span>Status:</span>
                            <span class="status-content bg-${getStatusColor(evacuationCenter.status)}">
                                ${evacuationCenter.status}
                            </span>
                        </div>
                    </div>`
                );
            });
        }

        function generateMarker(position, icon) {
            return new google.maps.Marker({
                position,
                map: map,
                icon: {
                    url: icon,
                    scaledSize: new google.maps.Size(35, 35)
                },
            });
        }

        function generateInfoWindow(marker, content) {
            const infoWindow = new google.maps.InfoWindow({
                content: content
            });

            marker.addListener('click', () => {
                if (activeInfoWindow)
                    activeInfoWindow.close();

                infoWindow.open({
                    anchor: marker,
                    shouldFocus: false,
                    map: map
                });

                activeInfoWindow = infoWindow;
                map.panTo(marker.getPosition());
            });
        }

        function generateCircle(center) {
            return new google.maps.Circle({
                map: map,
                center: center,
                radius: 14 * Math.pow(2, 0),
                fillColor: "#557ed8",
                fillOpacity: 0.3,
                strokeColor: "#557ed8",
                strokeOpacity: 0.8,
                strokeWeight: 2,
            });
        }

        function getStatusColor(status) {
            return status == 'Active' ? 'success' : status == 'Inactive' ? 'danger' : 'warning';
        }

        function newLatLng(lat, lng) {
            return new google.maps.LatLng(lat, lng);
        }

        function getKilometers(response) {
            return (response.routes[0].legs[0].distance.value / 1000).toFixed(2);
        }

        function getUserLocation() {
            return new Promise((resolve, reject) => {
                navigator.geolocation ?
                    navigator.geolocation.getCurrentPosition(
                        (position) => resolve(position),
                        () => getUserLocation(), {
                            enableHighAccuracy: true
                        }
                    ) : (showInfoMessage('Geolocation is not supported by this browser.'),
                        $('#locateNearestBtn').removeAttr('disabled'));

            });
        }

        function setMarker(userlocation) {
            userMarker ?
                (userMarker.setMap(map), userBounds.setMap(map),
                    userMarker.setPosition(userlocation),
                    userBounds.setCenter(userMarker.getPosition())) :
                (userMarker = generateMarker(userlocation,
                        "{{ asset('assets/img/userMarker.png') }}"),
                    userBounds = generateCircle(userMarker.getPosition()));
        }

        function getEvacuationCentersDistance() {
            getUserLocation()
                .then((position) => {
                    let promises = [];

                    evacuationCentersData.forEach(data => {
                        if (data.status == 'Active' &&
                            !evacuationCenterJson.some(item =>
                                item.latitude === data.latitude &&
                                item.longitude === data.longitude)) {
                            const direction = new google.maps.DirectionsService();

                            promises.push(new Promise((resolve, reject) => {
                                direction.route({
                                origin: newLatLng(
                                    position.coords.latitude,
                                    position.coords.longitude),
                                destination: newLatLng(
                                    data.latitude,
                                    data.longitude),
                                travelMode: google.maps.TravelMode.WALKING,
                            }, function(response, status) {
                                    if (status == 'OK') {
                                        evacuationCenterJson.push({
                                            latitude: data.latitude,
                                            longitude: data.longitude,
                                            distance: getKilometers(response)
                                        });
                                        resolve();
                                    }
                                });
                            }));
                        }
                    });

                    Promise.all(promises)
                        .then(() => {
                            evacuationCenterJson.sort((a, b) => a.distance - b.distance);
                            $('#locateNearestBtn').removeAttr('disabled');
                        }).catch((error) => {
                            getEvacuationCentersDistance();
                        });
                });
        }

        function locateEvacuationCenter(findNearestActive, row = null) {
            getUserLocation()
                .then((position) => {
                    const {
                        latitude,
                        longitude
                    } = findNearestActive ?
                        evacuationCenterJson[0] : getRowData(row, evacuationCenterTable);

                    directionService.route({
                        origin: newLatLng(position.coords.latitude, position.coords.longitude),
                        destination: newLatLng(latitude, longitude),
                        travelMode: google.maps.TravelMode.WALKING,
                    }, function(response, status) {
                        if (status == 'OK' && locating) {
                            directionDisplay.setMap(map);
                            directionDisplay.setDirections(response);

                            setMarker(response.routes[0].legs[0].start_location);

                            generateInfoWindow(userMarker,
                                `<div class="info-window-container">
                                    <center>You are here.</center>
                                    <div class="info-description">
                                        <span>Pathway distance to evacuation: </span>${getKilometers(response)} km
                                    </div>
                                </div>`
                            );

                            if ($('.stop-btn-container').is(':hidden')) {
                                $('.stop-btn-container').show();
                            }
                        }
                    });
                });
        }

        function scrollToMap() {
            $("html, body").animate({
                scrollTop: $(".locator-content").offset().top - 16
            }, 500);
        }

        $(document).ready(() => {
            evacuationCenterTable = $('.evacuationCenterTable').DataTable({
                language: {
                    emptyTable: '<div class="message-text">There are currently no evacuation centers available.</div>',
                },
                ordering: false,
                responsive: true,
                processing: false,
                serverSide: true,
                ajax: '{{ $prefix }}' == 'resident' ?
                    "{{ route('resident.evacuation.center.get', 'locator') }}" :
                    "{{ route('evacuation.center.get', 'locator') }}",
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
                        data: 'capacity',
                        name: 'capacity',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        width: '15%'
                    },
                    {
                        data: 'action',
                        width: '1rem',
                        orderable: false,
                        searchable: false
                    }
                ],
                columnDefs: [{
                    targets: 5,
                    render: function(data) {
                        return `<div class="status-container">
                                    <div class="status-content bg-${getStatusColor(data)}">
                                        ${data}
                                    </div>
                                </div>`;
                    }
                }],
                drawCallback: function() {
                    evacuationCentersData = this.api().ajax.json().data;
                    initMarkers(evacuationCentersData);
                    getEvacuationCentersDistance();
                },
            });

            $(document).on("click", "#locateCurrentLocationBtn", function() {
                if (!locating)
                    getUserLocation()
                    .then((position) => {
                        if (directionDisplay) directionDisplay.setMap(null);

                        setMarker(newLatLng(
                            position.coords.latitude,
                            position.coords.longitude
                        ));

                        generateInfoWindow(userMarker,
                            `<div class="info-window-container">
                                <div class="info-description">
                                    <center>You are here.</center>
                                </div>
                            </div>`
                        );

                        map.setCenter(userMarker.getPosition());
                        map.setZoom(18);
                        scrollToMap();
                    });
            });

            $(document).on("click", "#locateNearestBtn, .locateEvacuationCenter", function() {
                if (!locating) {
                    const findNearestActive = this.id == "locateNearestBtn" ? true : false;
                    locating = true;
                    locateEvacuationCenter(findNearestActive, this);
                    intervalId = setInterval(() => locateEvacuationCenter(findNearestActive, this), 20000);
                    scrollToMap();
                }
            });

            $(document).on("click", "#stopLocatingBtn", function() {
                clearInterval(intervalId);
                directionDisplay.setMap(null);
                userMarker.setMap(null);
                userBounds.setMap(null);
                $('.stop-btn-container').hide();
                map.setZoom(12);
                map.setCenter(newLatLng(14.242311, 121.12772));
                locating = false;
            });
        });
    </script>
</body>

</html>
