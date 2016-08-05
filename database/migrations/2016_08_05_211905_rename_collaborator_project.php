<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameCollaboratorProject extends Migration
{
  public function up()
  {
    Schema::rename('collaborator_project', 'project_collaborators');
  }

  public function down()
  {
    Schema::rename('project_collaborators', 'collaborator_project');
  }
}
