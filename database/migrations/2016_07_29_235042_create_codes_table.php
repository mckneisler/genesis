<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codes', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('parent_code_id')->unsigned()->index();
            $table->foreign('parent_code_id')->references('id')->on('codes')->onDelete('cascade');
            $table->string('code');
            $table->integer('values_code_id')->unsigned()->nullable();
            $table->foreign('values_code_id')->references('id')->on('codes')->onDelete('cascade');

            $table->timestamps();
			$table->softDeletes();
            $table->integer('created_by')->unsigned()->default(1);
            $table->integer('updated_by')->unsigned()->default(1);
            $table->integer('deleted_by')->unsigned()->nullable();

            $table->unique(['parent_code_id', 'code']);
        });

        Schema::create('code_locales', function (Blueprint $table) {
			$table->increments('code_locale_id');
            $table->integer('model_id')->unsigned()->index();
            $table->foreign('model_id')->references('id')->on('codes')->onDelete('cascade');
            $table->integer('locale_id')->unsigned()->index();
            $table->foreign('locale_id')->references('id')->on('codes')->onDelete('cascade');
			$table->boolean('requires_review')->default(false);

            $table->string('name');
            $table->text('description')->nullable();

            $table->unique(['model_id', 'locale_id']);
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
        Schema::drop('code_locales');
        Schema::drop('codes');
    }
}
