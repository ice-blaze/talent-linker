<?php

use Illuminate\Database\Seeder;
use App\Project;
use Carbon\Carbon;
use App\User;
use App\ProjectCollaborator;
use App\GeneralSkill;

class ProjectsTableSeeder extends Seeder
{
    public function run() {
      $skill_prog = GeneralSkill::find(1);
      $skill_gameengine = GeneralSkill::find(2);
      $user_james = User::find(1);
      $user_nico = User::find(2);
      $user_richard = User::find(3);

      $long_description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

      $project = Project::create([
        'title' => 'Cool Cats',
        'short_description' => 'Cool all those cats!',
        'long_description' => $long_description,
        'image' => 'http://i.imgur.com/CQbO0cc.jpg',
      ]);

      ProjectCollaborator::create([
        'skill_id' => $skill_prog->id,
        'project_id' => $project->id,
        'is_project_owner' => true,
        'user_id' => $user_james->id,
        'accepted' => true,
        'from_collaborator' => false,
        'invite_message' => 'initial seed',
        'accepted_date' => Carbon::now(),
      ]);

      DB::table('general_skill_project')->insert([
        'general_skill_id' => $skill_gameengine->id,
        'project_id' => $project->id,
        'count' => 1,
      ]);

      DB::table('general_skill_project')->insert([
        'general_skill_id' => $skill_prog->id,
        'project_id' => $project->id,
        'count' => 3,
      ]);

      $project = Project::create([
        'title' => 'Cat Blender',
        'short_description' => 'Cat bulenderu!',
        'long_description' => $long_description,
        'image' => 'https://cuteoverload.files.wordpress.com/2009/09/kitten_in_blender.jpg',
      ]);

      ProjectCollaborator::create([
        'skill_id' => $skill_gameengine->id,
        'project_id' => $project->id,
        'is_project_owner' => true,
        'user_id' => $user_nico->id,
        'accepted' => true,
        'from_collaborator' => false,
        'invite_message' => 'initial seed',
        'accepted_date' => Carbon::now(),
      ]);

      DB::table('general_skill_project')->insert([
        'general_skill_id' => $skill_gameengine->id,
        'project_id' => $project->id,
        'count' => 1,
      ]);

      DB::table('general_skill_project')->insert([
        'general_skill_id' => $skill_prog->id,
        'project_id' => $project->id,
        'count' => 3,
      ]);

      $project = Project::create([
        'title' => 'Burrito Cat',
        'short_description' => 'Amazing BURRITO CAT !!',
        'long_description' => $long_description,
        'image' => 'https://c1.staticflickr.com/3/2389/2073509907_345ad52bc1.jpg'
      ]);

      ProjectCollaborator::create([
        'skill_id' => $skill_prog->id,
        'project_id' => $project->id,
        'is_project_owner' => true,
        'user_id' => $user_richard->id,
        'accepted' => true,
        'from_collaborator' => false,
        'invite_message' => 'initial seed',
        'accepted_date' => Carbon::now(),
      ]);

      DB::table('general_skill_project')->insert([
        'general_skill_id' => $skill_gameengine->id,
        'project_id' => $project->id,
        'count' => 1,
      ]);

      DB::table('general_skill_project')->insert([
        'general_skill_id' => $skill_prog->id,
        'project_id' => $project->id,
        'count' => 3,
      ]);
    }
}
