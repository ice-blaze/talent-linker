<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class InvitationRole extends Migration
{
    public function up()
    {
        Schema::table('project_collaborators', function (Blueprint $table) {
            $table->integer('skill_id')->unsigned()->index();
            $table->boolean('is_project_owner');
        });
    }

    public function down()
    {
        Schema::table('project_collaborators', function (Blueprint $table) {
            $table->dropColumn('skill_id');
            $table->dropColumn('is_project_owner');
        });
    }
}
