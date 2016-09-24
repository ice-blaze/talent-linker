<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserGeolocalisation extends Migration
{
    public function up() {
      Schema::table('users', function (Blueprint $table) {
        $table->double('lat');
        $table->double('lng');
        $table->float('find_distance');
      });
    }

    public function down() {
      Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('lat');
        $table->dropColumn('lng');
        $table->dropColumn('find_distance');
      });
    }
}
