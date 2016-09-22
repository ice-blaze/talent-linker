<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\ProjectCollaborator;
use App\User;
use App\Project;
use App\GeneralSkill;

class CollaboratorTableSeeder extends Seeder
{
  public function run()
  {
    // create some invitations
    $user_james = User::find(1);
    $user_nico = User::find(2);
    $user_richard = User::find(3);

    $project_james = Project::find(1);
    $project_nico = Project::find(2);
    $project_richard = Project::find(3);

    $skill_prog = GeneralSkill::find(1);
    $skill_art_2d = GeneralSkill::find(4);

    ProjectCollaborator::create([
      'skill_id' => $skill_prog->id,
      'project_id' => $project_james->id,
      'is_project_owner' => false,
      'user_id' => $user_nico->id,
      'accepted' => false,
      'from_collaborator' => false,
      'invite_message' => 'initial seed',
    ]);

    ProjectCollaborator::create([
      'skill_id' => $skill_art_2d->id,
      'project_id' => $project_nico->id,
      'is_project_owner' => false,
      'user_id' => $user_james->id,
      'accepted' => true,
      'from_collaborator' => true,
      'invite_message' => 'initial seed',
    ]);
    ProjectCollaborator::create([
      'skill_id' => $skill_prog->id,
      'project_id' => $project_nico->id,
      'is_project_owner' => false,
      'user_id' => $user_richard->id,
      'accepted' => true,
      'from_collaborator' => true,
      'invite_message' => 'initial seed',
    ]);

    ProjectCollaborator::create([
      'skill_id' => $skill_art_2d->id,
      'project_id' => $project_nico->id,
      'is_project_owner' => false,
      'user_id' => $user_james->id,
      'accepted' => false,
      'from_collaborator' => false,
      'invite_message' => 'initial seed',
    ]);
  }
}
