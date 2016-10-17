<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionRecordRolePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_record_role', function (Blueprint $table) {
            $table->integer('role_id')->unsigned()->index();
            $table->foreign('role_id')->references('id')->on('codes')->onDelete('cascade');
            $table->integer('permission_record_id')->unsigned()->index();
            $table->foreign('permission_record_id')->references('id')->on('permission_records')->onDelete('cascade');
            $table->primary(['role_id', 'permission_record_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permission_record_role');
    }
}
