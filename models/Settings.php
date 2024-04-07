<?php

namespace SoftWorksPy\AppConfig\Models;

use Model;

/**
 * Model
 */
class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'softworkspy_appconfig_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
}