<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFeedbacks extends Migration
{
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();;
            $table->text('content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('feedbacks');
    }
}
