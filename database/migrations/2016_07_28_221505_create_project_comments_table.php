<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('project_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->text('content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('project_comments');
    }
}
