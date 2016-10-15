<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SkillsTechnicalName extends Migration
{
    public function up()
    {
        Schema::table('general_skills', function (Blueprint $table) {
            $table->char('technical_name');
        });
    }

    public function down()
    {
        Schema::table('general_skills', function (Blueprint $table) {
            $table->dropColumn('technical_name');
        });
    }
}
