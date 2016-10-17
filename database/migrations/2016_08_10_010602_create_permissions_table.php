<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('object_id')->unsigned()->index();
            $table->foreign('object_id')->references('id')->on('codes');
            $table->integer('action_id')->unsigned()->index();
            $table->foreign('action_id')->references('id')->on('codes');
            $table->timestamps();
            $table->integer('created_by')->unsigned()->default(1);
            $table->integer('updated_by')->unsigned()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permissions');
    }
}
