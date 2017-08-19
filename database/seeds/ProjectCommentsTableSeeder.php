<?php

use App\User;
use App\ProjectComment;
use App\ProjectCollaborator;
use Illuminate\Database\Seeder;

class ProjectCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_james = User::find(1);
        $user_nico = User::find(2);

        $project = ProjectCollaborator::where([['user_id', '=', $user_james->id]])->first();

        ProjectComment::create([
            'project_id'       => $project->id,
            'user_id'          => $user_james->id,
            'private'          => 1,
            'content'          => 'Hello!',
        ]);

        ProjectComment::create([
            'project_id'       => $project->id,
            'user_id'          => $user_nico->id,
            'private'          => 1,
            'content'          => 'Hi!',
        ]);
    }
}
