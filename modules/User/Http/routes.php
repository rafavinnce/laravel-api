<?php

Route::group(['namespace' => 'Modules\User\Http\Controllers', 'middleware' => ['auth:api', 'permission']], function() {
    Route::resource('users', 'UserController', ['except' => ['create', 'edit']]);
});