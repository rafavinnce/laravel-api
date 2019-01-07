<?php

Route::group(['namespace' => 'Modules\Shipment\Http\Controllers', 'middleware' => ['auth:api', 'permission']], function() {
    Route::apiResource('shipments', 'ShipmentController');
    Route::apiResource('steps', 'StepController');
    Route::apiResource('loads', 'LoadController', ['only' => ['index', 'show']]);
    Route::apiResource('pendencies', 'PendencyController');
});
