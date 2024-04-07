<?php

namespace SoftWorksPy\AppConfig;

use App;
use System\Classes\PluginBase;
use SoftWorksPy\AppConfig\Middlewares\AuthorizationControl;
use SoftWorksPy\AppConfig\Models\Settings;

class Plugin extends PluginBase
{
    public function register()
    {
        // register apis middleware
        App::singleton(AuthorizationControl::class, function () {
            return new AuthorizationControl;
        });
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'softworkspy.appconfig::lang.settings.settings.label',
                'description' => 'softworkspy.appconfig::lang.settings.settings.description',
                'category'    => 'softworkspy.appconfig::lang.plugin.name',
                'icon'        => 'icon-user',
                'class'       => Settings::class,
                'order'       => 500,
                'keywords'    => 'security users',
                'permissions' => ['softworkspy.appconfig.access_settings']
            ]
        ];
    }
}
