<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeenOnChat extends Migration
{
    public function up()
    {
        Schema::table('chat_user', function (Blueprint $table) {
            $table->boolean('seen');
        });
    }

    public function down()
    {
        Schema::table('chat_user', function (Blueprint $table) {
            $table->dropColumn('seen');
        });
    }
}
