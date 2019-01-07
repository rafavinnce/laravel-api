<?php

Route::group(['namespace' => 'Modules\Status\Http\Controllers', 'middleware' => ['auth:api']], function() {
    Route::apiResource('status', 'StatusController', ['only' => ['index', 'show']]);
});
