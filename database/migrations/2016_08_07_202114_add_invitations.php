<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvitations extends Migration
{
    public function up()
    {
        Schema::table('project_collaborators', function (Blueprint $table) {
            $table->boolean('from_collaborator');
            $table->boolean('accepted');
            $table->text('invite_message');
            $table->timestamp('accepted_date');
        });
    }

    public function down()
    {
        Schema::table('project_collaborators', function (Blueprint $table) {
            $table->dropColumn('from_collaborator');
            $table->dropColumn('accepted');
            $table->dropColumn('invite_message');
            $table->dropColumn('accepted_date');
        });
    }
}
