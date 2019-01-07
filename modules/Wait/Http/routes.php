<?php

Route::get('waits/download','Modules\Wait\Http\Controllers\WaitController@download')->name('waits.download');
Route::group(['namespace' => 'Modules\Wait\Http\Controllers', 'middleware' => ['auth:api', 'permission']], function() {
    Route::apiResource('waits', 'WaitController');
});

