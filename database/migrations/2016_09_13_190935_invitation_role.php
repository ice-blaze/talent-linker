<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvitationRole extends Migration
{
    public function up()
    {
        Schema::table('project_collaborators', function (Blueprint $table) {
            $table->integer('skill_id')->unsigned()->index();
            $table->boolean('is_project_owner');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }

    public function down()
    {
        Schema::table('project_collaborators', function (Blueprint $table) {
            $table->dropColumn('skill_id');
            $table->dropColumn('is_project_owner');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index();
        });
    }
}
