<?php

Route::group(['namespace' => 'Modules\Account\Http\Controllers', 'middleware' => ['api']], function() {
    Route::apiResource('accounts', 'AccountController', ['except' => ['index']])->parameters([
        'accounts' => 'token_id',
    ]);

    Route::post('accounts/password/token', 'TokenPasswordController@token')->name('password.token');
    Route::post('accounts/password/reset', 'ResetPasswordController@reset')->name('password.reset');
});
