<?php

Route::group(['namespace' => 'Modules\Lobby\Http\Controllers', 'middleware' => ['auth:api', 'permission']], function() {
    Route::apiResource('lobbies', 'LobbyController');
});
