<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGeneralSkills extends Migration
{
    public function up()
    {
        Schema::create('general_skills', function (Blueprint $table) {
            $table->increments('id');
            $table->char('name');
            $table->timestamps();
        });

        Schema::create('general_skill_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('general_skill_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->timestamps();
        });

        Schema::create('general_skill_project', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('general_skill_id')->unsigned()->index();
            $table->integer('project_id')->unsigned()->index();
            $table->integer('count')->unsigned();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('general_skills');
        Schema::drop('general_skill_user');
        Schema::drop('general_skill_project');
    }
}
