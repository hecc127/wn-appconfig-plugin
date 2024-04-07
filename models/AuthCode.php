<?php

namespace SoftWorksPy\AppConfig\Models;

use Model;

/**
 * Model
 */
class AuthCode extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    use \Winter\Storm\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'softworkspy_appconfig_auth_codes';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'is_active' => 'boolean',
        'code' => 'required|min:10|max:200',
    ];
}
