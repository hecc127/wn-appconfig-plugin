<?php

namespace SoftWorksPy\AppConfig\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

class Applications extends Controller
{
    public $implement = [
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\RelationController::class,
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = [
        'softworkspy.appconfig.manage_applications',
        'softworkspy.appconfig.activate_applications'
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('SoftWorksPy.AppConfig', 'applications');
    }

    public function formExtendModel($model)
    {
        if ($this->action == 'create') {
            $model->user_id = $this->user->id;
        }

        return $model;
    }
}
