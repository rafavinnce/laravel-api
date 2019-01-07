<?php

Route::group(['prefix' => 'notification', 'as' => 'notification.', 'namespace' => 'Modules\Notification\Http\Controllers', 'middleware' => ['auth:api']], function() {
    Route::apiResource('notifications', 'NotificationController');
    Route::apiResource('notifications/{notification}/comments', 'CommentController');
});
