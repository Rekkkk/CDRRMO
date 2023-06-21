<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('active-evacuees', function () {
    return true;
});

Broadcast::channel('report-incident', function () {
    return true;
});