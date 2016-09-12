<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageField extends Migration
{
  public function up()
  {
    Schema::table('projects', function (Blueprint $table) {
      $table->string('image');
    });

    Schema::table('users', function (Blueprint $table) {
      $table->string('image');
    });
  }

  public function down()
  {
    Schema::table('projects', function (Blueprint $table) {
      $table->dropColumn('image');
    });

    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn('image');
    });
  }
}
