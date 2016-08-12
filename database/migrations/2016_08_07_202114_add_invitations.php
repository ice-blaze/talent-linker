<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvitations extends Migration
{
  public function up()
  {
    Schema::create('invitations', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('guest_id')->unsigned()->index();
      $table->integer('project_id')->unsigned()->index();
      $table->boolean('from_guest');
      $table->boolean('accepted');
      $table->text('invite_message');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::drop('invitations');
  }
}
