<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameChatTable extends Migration
{
  public function up()
  {
    Schema::rename('chat_user', 'chat_users');
  }

  public function down()
  {
    Schema::rename('chat_users', 'chat_user');
  }
}
