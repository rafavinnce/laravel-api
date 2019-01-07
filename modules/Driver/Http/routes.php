<?php

Route::group(['namespace' => 'Modules\Driver\Http\Controllers', 'middleware' => ['auth:api', 'permission']], function() {
    Route::apiResource('drivers', 'DriverController');
});
