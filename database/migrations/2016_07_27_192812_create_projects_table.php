<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
  public function up()
  {
    Schema::create('projects', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->text('short_description');
      $table->text('long_description');
      $table->text('github_link');
      $table->text('siteweb_link');
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::drop('projects');
  }
}
