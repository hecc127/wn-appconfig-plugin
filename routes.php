<?php

use SoftWorksPy\AppConfig\Middlewares\AuthorizationControl;

Route::group(['prefix' => 'api/softworkspy/remote-config'], function () {

    Route::get('check-version', 'SoftWorksPy\RemoteConfig\Api\Applications@checkVersion');

    Route::group(['middleware' => AuthorizationControl::class], function () {
        Route::get('get', 'SoftWorksPy\RemoteConfig\Api\Applications@getConfig');
    });
});
