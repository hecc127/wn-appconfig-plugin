<?php

namespace SoftWorksPy\AppConfig\Models;

use Model;

/**
 * Model
 */
class Application extends Model
{
    use \Winter\Storm\Database\Traits\Purgeable;
    use \Winter\Storm\Database\Traits\Validation;
    use \Winter\Storm\Database\Traits\SoftDelete;

    /**
     * @var array List of attributes to purge.
     */
    protected $purgeable = ['identity_code'];

    public $table = 'softworkspy_appconfig_applications';

    protected $dates = ['deleted_at'];

    protected $jsonable = ['other_settings'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['settings', 'lastVersion'];

    protected $with = ['icon', 'logo', 'background', 'images', 'files'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $visible = [
        'name',
        'description',
        'primary_color',
        'secondary_color',
        'background_color',
        'settings',
        'icon',
        'logo',
        'background',
        'images',
        'files',
        'lastVersion',
    ];

    /*
     * Validation
     */
    public $rules = [
        'user_id' => 'required',
        'name' => 'required|max:100',
    ];

    // ------------ RELATIONSHIPS ------------ //

    public $hasMany = [
        'versions' => Version::class,
        'authCodes' => AuthCode::class,
    ];

    public $attachOne = [
        'icon' => \System\Models\File::class,
        'logo' => \System\Models\File::class,
        'background' => \System\Models\File::class,
    ];

    public $attachMany = [
        'images' => \System\Models\File::class,
        'files'  => \System\Models\File::class,
    ];

    // ------------ EVENTS ------------ //

    public function beforeCreate()
    {
        // set a unique identifier for API requests
        $this->identity_code = str_slug($this->name) . time();
    }

    // ------------ ACCESSORS ------------ //

    public function getSettingsAttribute()
    {
        $settings = [];

        foreach ($this->other_settings as $setting) {
            $settings[$setting['key']] = $setting['value'];
        }

        return $settings;
    }

    public function getLastVersionAttribute()
    {
        return $this->versions()->orderBy('created_at', 'desc')->first();
    }

    // ------------ SCOPES ------------ //

    public function scopeIsActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function findByCode($code)
    {
        return self::isActive()->where('identity_code', 'like', $code)->first();
    }

    // ------------ EXTEND BEHAVIORS ------------ //

    public function filterFields($fields, $context = null)
    {
        if ($context === 'update') {
            $user = \BackendAuth::getUser();
            if (!$user->hasAccess('softworkspy.appconfig.activate_applications')) {
                $fields->is_active->hidden = true;
            }

            if (!$user->hasAccess('softworkspy.appconfig.view_applications_codes')) {
                $fields->identity_code->hidden = true;
                $fields->authCodes->hidden = true;
            }
        }
    }

    // ------------ PUBLIC METHODS ------------ //

    public function checkVersion(String $version)
    {
        $checkedVersion = $this->versions()
            ->where('is_approved', true)
            ->where('number', 'like', $version)
            ->first();

        $lastVersion = $this->versions()
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$checkedVersion) {

            $checkedVersion = $this->versions()
                ->where('is_approved', false)
                ->where('number', 'like', $version)
                ->first();

            if (!$checkedVersion) {

                return [
                    'updated' => false,
                    'important' => false,
                    'message' => 'No existen versiones registradas para esta Aplicación',
                ];

            } else {
                
                return [
                    'updated' => true,
                    'important' => false,
                    'message' => 'Version en prueba',
                ];
            }
        }

        $checkedId = $checkedVersion ? $checkedVersion->id : 0;
        $lastId = $lastVersion ? $lastVersion->id : 0;

        $updated = $checkedId === $lastId;

        return [
            'updated' => $updated,
            'important' => $updated ? false : $this->_checkImportantUpdate($checkedId),
            'message' => $lastVersion->message,
            'url' => $lastVersion->url,
        ];
    }

    // ------------ PRIVATE METHODS ------------ //

    private function _checkImportantUpdate($checkedId)
    {
        $count = $this->versions()
            ->where('id', '>', $checkedId)
            ->where('important', true)
            ->count();

        return $count > 0;
    }
}
