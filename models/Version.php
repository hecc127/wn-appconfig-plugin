<?php

namespace SoftWorksPy\AppConfig\Models;

use Model;

/**
 * Model
 */
class Version extends Model
{
    use \Winter\Storm\Database\Traits\Validation;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'softworkspy_appconfig_versions';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'application_id' => 'required',
        'number' => 'required',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $visible = [
        'number',
        'important',
        'created_at',
    ];

    public $belongsTo = [
        'application' => Application::class,
    ];
    
    /**
     * @var array Attribute names to encode and decode using JSON.
     */
    public $jsonable = [];
}
