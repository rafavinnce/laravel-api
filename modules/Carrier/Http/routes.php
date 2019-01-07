<?php

Route::get('carriers/download','Modules\Carrier\Http\Controllers\CarrierController@download')->name('carriers.download');
Route::group(['namespace' => 'Modules\Carrier\Http\Controllers', 'middleware' => ['auth:api', 'permission']], function() {
    Route::apiResource('carriers', 'CarrierController');
});
