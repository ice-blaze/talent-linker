<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLanguages extends Migration
{
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->char('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('languages');
    }
}
