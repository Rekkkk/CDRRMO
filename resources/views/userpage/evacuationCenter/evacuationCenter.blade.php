<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.headPackage')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    {{-- @vite(['resources/js/app.js']) --}}
</head>

<body>
    <div class="wrapper">
        @include('partials.header')
        @include('partials.sidebar')
        <div class="main-content">
            <div class="label-container">
                <div class="icon-container">
                    <div class="icon-content"><i class="bi bi-house"></i></div>
                </div>
                <span>EVACUATION CENTER LOCATOR</span>
            </div>
            <hr>
            <div class="locator-content">
                <div class="locator-header">
                    <div class="header-title"><span>Cabuyao City Map</span></div>
                </div>
                <div class="map-section">
                    <div class="locator-map" id="map"></div>
                </div>
            </div>
            <div class="evacuation-button-container">
                <div class="evacuation-markers">
                    <div class="markers-header">
                        <p>Markers</p>
                    </div>
                    <div class="marker-container">
                        <div class="markers">
                            <img src="{{ asset('assets/img/evacMarkerActive.png') }}" alt="Icon">
                            <span class="fw-bold">Active</span>
                        </div>
                        <div class="markers">
                            <img src="{{ asset('assets/img/evacMarkerInactive.png') }}" alt="Icon">
                            <span class="fw-bold">Inactive</span>
                        </div>
                        <div class="markers">
                            <img src="{{ asset('assets/img/evacMarkerFull.png') }}" alt="Icon">
                            <span class="fw-bold">Full</span>
                        </div>
                        <div class="markers" id="flood-marker">
                            <img src="{{ asset('assets/img/floodedMarker.png') }}" alt="Icon">
                            <span class="fw-bold">Flooded</span>
                        </div>
                        <div class="markers" id="user-marker" hidden>
                            <img src="{{ asset('assets/img/userMarker.png') }}" alt="Icon">
                            <span class="fw-bold">You</span>
                        </div>
                    </div>
                </div>
                <div class="locator-button-container">
                    <button type="button" id="locateNearestBtn" disabled>
                        <i class="bi bi-search"></i>Locate Nearest Active Evacuation</button>
                    <button type="button" id="pinpointCurrentLocationBtn">
                        <i class="bi bi-geo-fill"></i>Pinpoint Current Location</button>
                </div>
            </div>
            <div class="table-container">
                <div class="table-content">
                    <header class="table-label">Evacuation Centers Table</header>
                    <table class="table" id="evacuationCenterTable" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
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
        let map, activeInfoWindow, userMarker, userBounds, evacuationCentersData, prevNearestEvacuationCenter,
            evacuationCenterTable, directionDisplay, directionService, findNearestActive, rowData,
            evacuationCenterJson = [],
            evacuationCenterMarkers = [],
            intervalId = null,
            locating = false,
            geolocationBlocked = false,
            hasActiveEvacuationCenter = false;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: 14.246261,
                    lng: 121.12772
                },
                zoom: 13,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                }
            });

            directionService = new google.maps.DirectionsService();
            directionDisplay = new google.maps.DirectionsRenderer({
                map,
                suppressMarkers: true,
                preserveViewport: true,
                markerOptions: {
                    icon: {
                        url: "{{ asset('assets/img/userMarker.png') }}",
                        scaledSize: new google.maps.Size(35, 35)
                    }
                }
            });

            const buttonContainer = document.createElement('div');
            buttonContainer.className = 'stop-btn-container';
            buttonContainer.innerHTML = `<button id="stopLocatingBtn" class="btn-remove">Stop Locating</button>`;
            map.controls[google.maps.ControlPosition.TOP_RIGHT].push(buttonContainer);
        }

        function initMarkers(evacuationCenters) {
            while (evacuationCenterMarkers.length) evacuationCenterMarkers.pop().setMap(null);

            evacuationCenters.forEach(evacuationCenter => {
                let picture = evacuationCenter.status == 'Active' ?
                    "evacMarkerActive" : evacuationCenter.status == 'Full' ?
                    "evacMarkerFull" : "evacMarkerInactive";

                let evacuationCenterMarker = generateMarker({
                    lat: parseFloat(evacuationCenter.latitude),
                    lng: parseFloat(evacuationCenter.longitude)
                }, "{{ asset('assets/img/picture.png') }}".replace('picture', picture));

                evacuationCenterMarkers.push(evacuationCenterMarker);

                generateInfoWindow(
                    evacuationCenterMarker,
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

        function generateInfoWindow(marker, content) {
            if (!locating) closeInfoWindow();

            const infoWindow = new google.maps.InfoWindow({
                content
            });

            marker.addListener('click', () => {
                closeInfoWindow();
                infoWindow.open({
                    anchor: marker,
                    map
                });
                activeInfoWindow = infoWindow;
                if (marker.icon.url.includes('userMarker'))
                    zoomToUserLocation();
            });
        }

        function generateMarker(position, icon) {
            return new google.maps.Marker({
                position,
                map,
                icon: {
                    url: icon,
                    scaledSize: new google.maps.Size(35, 35)
                }
            });
        }

        function generateCircle(center) {
            return new google.maps.Circle({
                map,
                center,
                radius: 14,
                fillColor: "#557ed8",
                fillOpacity: 0.3,
                strokeColor: "#557ed8",
                strokeOpacity: 0.8,
                strokeWeight: 2
            });
        }

        function request(origin, destination) {
            return {
                origin,
                destination,
                travelMode: google.maps.TravelMode.WALKING
            };
        }

        function getStatusColor(status) {
            return status == 'Active' ? 'success' : status == 'Inactive' ? 'danger' : 'warning';
        }

        function getKilometers(response) {
            return (response.routes[0].legs[0].distance.value / 1000).toFixed(2);
        }

        function newLatLng(lat, lng) {
            return new google.maps.LatLng(lat, lng);
        }

        function scrollMarkers() {
            $('#user-marker').prop('hidden', false);
            $('.evacuation-markers').animate({
                scrollLeft: $('#user-marker').position().left + $('.evacuation-markers').scrollLeft()
            }, 500);
        }

        function scrollToMap() {
            $('html, body').animate({
                scrollTop: $('.locator-content').offset().top - 15
            }, 500);
        }

        function zoomToUserLocation() {
            map.panTo(userMarker.getPosition());
            map.setZoom(18);
        }

        function closeInfoWindow() {
            activeInfoWindow?.close();
        }

        function getUserLocation() {
            return new Promise((resolve, reject) => {
                navigator.geolocation ?
                    navigator.geolocation.getCurrentPosition(
                        (position) => position.coords.accuracy <= 500 ?
                        (geolocationBlocked = false, resolve(position)) :
                        getUserLocation(),
                        (error) => {
                            switch (error.message) {
                                case 'User denied Geolocation':
                                    showWarningMessage(
                                        'Request for geolocation denied. To use this feature, please allow the browser to locate you.'
                                    );
                                    break;
                                default:
                                    showErrorMessage(
                                        'Geolocation service failed. Please restart your browser.'
                                    );
                                    break;
                            }

                            $('#locateNearestBtn').removeAttr('disabled');
                            geolocationBlocked = true;
                            locating = false;
                        }, {
                            enableHighAccuracy: true
                        }
                    ) :
                    (showInfoMessage('Geolocation is not supported by this browser.'),
                        $('#locateNearestBtn').removeAttr('disabled'));
            });
        }

        function setMarker(userlocation) {
            userMarker ?
                (userMarker.setMap(map),
                    userBounds.setMap(map),
                    userMarker.setPosition(userlocation),
                    userBounds.setCenter(userMarker.getPosition())) :
                (userMarker = generateMarker(userlocation,
                        "{{ asset('assets/img/userMarker.png') }}"),
                    userBounds = generateCircle(userMarker.getPosition()));
        }

        async function getEvacuationCentersDistance() {
            prevNearestEvacuationCenter = evacuationCenterJson.length ? evacuationCenterJson[0] : null;
            evacuationCenterJson.splice(0, evacuationCenterJson.length);
            const activeEvacuationCenters = evacuationCentersData.filter(data => data.status != 'Inactive');

            if (activeEvacuationCenters.length == 0) {
                hasActiveEvacuationCenter = false;
                if (locating && findNearestActive) {
                    $('#stopLocatingBtn').trigger('click');
                    showWarningMessage('There are currently no active evacuation centers.');
                }
            } else {
                hasActiveEvacuationCenter = true;
                const position = await getUserLocation();
                const promises = activeEvacuationCenters.map(data => {
                    return new Promise(resolve => {
                        const direction = new google.maps.DirectionsService();
                        direction.route(request(
                                newLatLng(position.coords.latitude, position.coords.longitude),
                                newLatLng(data.latitude, data.longitude)),
                            (response, status) => {
                                if (status == 'OK') {
                                    evacuationCenterJson.push({
                                        id: data.id,
                                        status: data.status,
                                        latitude: data.latitude,
                                        longitude: data.longitude,
                                        distance: parseFloat(getKilometers(response))
                                    });
                                }
                                resolve();
                            }
                        );
                    });
                });

                await Promise.all(promises);
                evacuationCenterJson.sort((a, b) => a.distance - b.distance);
            }

            $('#locateNearestBtn').removeAttr('disabled');
        }

        async function locateEvacuationCenter() {
            const position = await getUserLocation();

            if (geolocationBlocked) return;

            if (findNearestActive && evacuationCenterJson.length == 0) {
                await getEvacuationCentersDistance();
                if (!hasActiveEvacuationCenter) return;
            }

            const {
                latitude,
                longitude
            } = findNearestActive ?
                evacuationCenterJson[0] : rowData;

            directionService.route(request(
                    newLatLng(position.coords.latitude, position.coords.longitude),
                    newLatLng(latitude, longitude)),
                function(response, status) {
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
                            scrollToMap();
                            var bounds = new google.maps.LatLngBounds();
                            response.routes[0].legs.forEach(({
                                    steps
                                }) =>
                                steps.forEach(({
                                        start_location,
                                        end_location
                                    }) =>
                                    (bounds.extend(start_location), bounds.extend(end_location)))
                            );
                            map.fitBounds(bounds);
                            $('.stop-btn-container').show();
                            scrollMarkers();
                        }
                    }
                }
            );
        }

        $(document).ready(() => {
            evacuationCenterTable = $('#evacuationCenterTable').DataTable({
                language: {
                    emptyTable: '<div class="message-text">There are currently no evacuation centers available.</div>'
                },
                ordering: false,
                responsive: true,
                processing: false,
                serverSide: true,
                ajax: '{{ $prefix }}' == 'resident' ?
                    "{{ route('resident.evacuation.center.get', 'locator') }}" :
                    "{{ route('evacuation.center.get', 'locator') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                        visible: false
                    },
                    {
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
                        width: '1rem',
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
                    targets: 6,
                    render: function(data) {
                        return `<div class="status-container">
                                    <div class="status-content bg-${getStatusColor(data)}">
                                        ${data}
                                    </div>
                                </div>`;
                    }
                }],
                drawCallback: function() {
                    if (!this.api().search()) {
                        evacuationCentersData = this.api().ajax.json().data;
                        if (!geolocationBlocked) getEvacuationCentersDistance();
                        initMarkers(evacuationCentersData);
                    }

                    if (locating) {
                        const {
                            id,
                            status,
                            latitude,
                            longitude
                        } = findNearestActive ? prevNearestEvacuationCenter : rowData;

                        const isCenterUnavailable = findNearestActive ?
                            !evacuationCentersData.some(evacuationCenter =>
                                evacuationCenter.id == id && evacuationCenter.status == status) :
                            !evacuationCentersData.some(evacuationCenter =>
                                evacuationCenter.id == id),
                            isLocationUpdated = !evacuationCentersData.some(evacuationCenter =>
                                evacuationCenter.latitude == latitude &&
                                evacuationCenter.longitude == longitude);

                        if (isCenterUnavailable || isLocationUpdated) {
                            $('#stopLocatingBtn').click();
                            showWarningMessage(
                                isCenterUnavailable ?
                                'The evacuation center you are locating is no longer available.' :
                                'The location of the evacuation center you are locating is updated.'
                            );
                        }
                    }
                }
            });

            $(document).on("click", "#pinpointCurrentLocationBtn", function() {
                if (!locating)
                    getUserLocation()
                    .then((position) => {
                        setMarker(newLatLng(position.coords.latitude, position.coords.longitude));
                        generateInfoWindow(userMarker,
                            `<div class="info-window-container">
                                <div class="info-description">
                                    <center>You are here.</center>
                                </div>
                            </div>`);
                        scrollToMap();
                        zoomToUserLocation();
                        scrollMarkers();
                    });
            });

            $(document).on("click", "#locateNearestBtn, .locateEvacuationCenter", function() {
                if (!locating) {
                    rowData = getRowData(this, evacuationCenterTable);
                    locating = true;
                    findNearestActive = $(this).hasClass('locateEvacuationCenter') ? false : true;
                    locateEvacuationCenter();
                    if (geolocationBlocked || (findNearestActive && !hasActiveEvacuationCenter)) return;
                    intervalId = setInterval(locateEvacuationCenter, 10000);
                }
            });

            $(document).on("click", "#stopLocatingBtn", function() {
                locating = false;
                clearInterval(intervalId);
                directionDisplay?.setMap(null);
                userMarker?.setMap(null);
                userBounds?.setMap(null);
                closeInfoWindow();
                $('.stop-btn-container').hide();
                map.setCenter(newLatLng(14.246261, 121.12772));
                map.setZoom(13);
                $('#user-marker').prop('hidden', true);
            });

            // Echo.channel('evacuation-center-locator').listen('EvacuationCenterLocator', (e) => {
            //     evacuationCenterTable.search() ?
            //         ($('.dataTables_filter input').val(''),
            //             evacuationCenterTable.search('').draw()) :
            //         evacuationCenterTable.draw();
            // });
        });
    </script>
</body>

</html>
