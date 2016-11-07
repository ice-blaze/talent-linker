<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddLanguageToProject extends Migration
{
    public function up()
    {
        Schema::create('language_project', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('language_id')->unsigned()->index();
            $table->integer('project_id')->unsigned()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('language_project');
    }
}
