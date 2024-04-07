<?php namespace SoftWorksPy\AppConfig\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateSoftWorksPyAppConfigVersions extends Migration
{
    public function up()
    {
        Schema::create('softworkspy_appconfig_versions', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('application_id')->unsigned();
            $table->string('number', 50);
            $table->boolean('important');
            $table->string('message', 200)->nullable();
            $table->string('url', 250)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->boolean('is_approved')->default(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('softworkspy_appconfig_versions');
    }
}
