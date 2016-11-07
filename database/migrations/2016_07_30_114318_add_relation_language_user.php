<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddRelationLanguageUser extends Migration
{
    public function up()
    {
        Schema::create('language_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('language_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('language_user');
    }
}
