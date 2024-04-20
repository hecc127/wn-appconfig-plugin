<?php namespace SoftWorksPy\AppConfig\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateSoftWorksPyAppConfigApp extends Migration
{
    public function up()
    {
        Schema::create('softworkspy_appconfig_applications', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('primary_color', 50)->nullable();
            $table->string('secondary_color', 50)->nullable();
            $table->string('background_color', 200)->nullable();
            $table->text('other_settings')->nullable();
            $table->string('identity_code', 110)->nullable();
            $table->boolean('is_active')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('softworkspy_appconfig_applications');
    }
}