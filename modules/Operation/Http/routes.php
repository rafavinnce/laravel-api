<?php

Route::group(['namespace' => 'Modules\Operation\Http\Controllers', 'middleware' => ['auth:api', 'permission']], function() {
    Route::apiResource('operations', 'OperationController');
});
