<?php namespace SoftWorksPy\AppConfig\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateSoftWorksPyAppConfigAuthCodes extends Migration
{
    public function up()
    {
        Schema::create('softworkspy_appconfig_auth_codes', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('application_id')->unsigned();
            $table->boolean('is_active')->default(false);
            $table->string('code', 200);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('softworkspy_appconfig_auth_codes');
    }
}
