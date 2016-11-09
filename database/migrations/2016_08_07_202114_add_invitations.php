<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddInvitations extends Migration
{
    public function up()
    {
        Schema::table('project_collaborators', function (Blueprint $table) {
            $table->boolean('from_collaborator')->default(false);
            $table->boolean('accepted')->default(false);
            $table->text('invite_message')->default('Hey !');
            $table->timestamp('accepted_date')->nullable();
        });
    }

    public function down()
    {
        Schema::table('project_collaborators', function (Blueprint $table) {
            $table->dropColumn('from_collaborator');
            $table->dropColumn('accepted');
            $table->dropColumn('invite_message');
            $table->dropColumn('accepted_date')->nullable();
        });
    }
}
