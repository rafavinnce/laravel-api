<?php

Route::group(['namespace' => 'Modules\Vehicle\Http\Controllers', 'middleware' => ['auth:api', 'permission']], function() {
    Route::apiResource('vehicles', 'VehicleController');
});
