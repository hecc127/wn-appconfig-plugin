<?php

use SoftWorksPy\AppConfig\Middlewares\AuthorizationControl;

Route::group(['prefix' => 'api/softworkspy/appconfig'], function () {

    Route::get('check-version', 'SoftWorksPy\AppConfig\Api\Applications@checkVersion');

    Route::group(['middleware' => AuthorizationControl::class], function () {
        Route::get('get', 'SoftWorksPy\AppConfig\Api\Applications@getConfig');
    });
});
