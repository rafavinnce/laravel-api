<?php

Route::group(['namespace' => 'Modules\Dock\Http\Controllers', 'middleware' => ['auth:api', 'permission']], function() {
    Route::apiResource('docks', 'DockController');
});
