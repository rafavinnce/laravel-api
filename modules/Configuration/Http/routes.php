<?php

Route::group(['namespace' => 'Modules\Configuration\Http\Controllers', 'middleware' => ['auth:api', 'permission']], function() {
    Route::apiResource('configurations', 'ConfigurationController', ['except' => ['destroy', 'store']]);
});

