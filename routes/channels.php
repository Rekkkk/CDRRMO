<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('active-evacuees', function () {
    return true;
});

Broadcast::channel('incident-report', function () {
    return true;
});

Broadcast::channel('evacuation-center-locator', function () {
    return true;
});