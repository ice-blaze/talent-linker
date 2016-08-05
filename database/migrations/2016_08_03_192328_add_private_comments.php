<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrivateComments extends Migration
{
  public function up()
  {
    Schema::create('collaborator_project', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('project_id')->unsigned()->index();
      $table->integer('user_id')->unsigned()->index();
      $table->timestamps();
    });

    Schema::create('chat_user', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('sender_id')->unsigned()->index();
      $table->integer('reciever_id')->unsigned()->index();
      $table->text('content');
      $table->timestamps();
    });

    Schema::table('project_comments', function (Blueprint $table) {
      $table->boolean('private');
    });

    Schema::table('projects', function (Blueprint $table) {
      $table->integer('user_id')->unsigned()->index();;
    });
  }

  public function down()
  {
    Schema::table('project_comments', function (Blueprint $table) {
      $table->dropColumn('private');
    });

    Schema::table('projects', function (Blueprint $table) {
      $table->dropColumn('user_id');
    });

    Schema::drop('collaborator_project');
    Schema::drop('chat_user');
  }
}
