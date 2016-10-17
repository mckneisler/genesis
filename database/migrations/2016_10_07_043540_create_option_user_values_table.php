<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionUserValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('option_user_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('option_id')->unsigned()->index();
            $table->foreign('option_id')->references('id')->on('codes');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('value_id')->unsigned()->index();
            $table->foreign('value_id')->references('id')->on('codes');
            $table->timestamps();
            $table->integer('created_by')->unsigned()->default(1);
            $table->integer('updated_by')->unsigned()->default(1);
            $table->unique(['option_id', 'user_id', 'value_id']);
        });
     }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::drop('option_user_values');
     }
}
