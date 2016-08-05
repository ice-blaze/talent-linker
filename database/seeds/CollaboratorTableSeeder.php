<?php

use Illuminate\Database\Seeder;

class CollaboratorTableSeeder extends Seeder
{
  public function run()
  {
    $user = DB::table('users')->orderBy('created_at', 'desc')->first();;
    $project = DB::table('projects')->orderBy('created_at', 'desc')->first();;

    DB::table('project_collaborators')->insert([
      'project_id' => $project->id,
      'user_id' => $user->id,
    ]);
  }
}
