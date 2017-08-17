<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserMissingFieldsExceptCity extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->char('last_name')->nullable();
            $table->char('first_name')->nullable();
            $table->text('talent_description')->nullable();
            $table->text('website')->nullable();
            $table->text('github')->nullable();
            $table->text('stack_overflow')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_name');
            $table->dropColumn('first_name');
            $table->dropColumn('talent_description');
            $table->dropColumn('website');
            $table->dropColumn('github');
            $table->dropColumn('stack_overflow');
        });
    }
}
