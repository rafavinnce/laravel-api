<?php

Route::group(['namespace' => 'Modules\Permission\Http\Controllers', 'middleware' => ['auth:api']], function() {
    Route::apiResource('permissions', 'PermissionController', ['only' => ['index', 'show']]);
    Route::post('permissions/sync', 'PermissionController@sync')->middleware(['superuser'])->name('permissions.sync');
    Route::apiResource('roles', 'RoleController', ['only' => ['show', 'index']]);
    Route::apiResource('roles', 'RoleController', ['except' => ['show', 'index'], 'middleware' => ['superuser']]);
});
