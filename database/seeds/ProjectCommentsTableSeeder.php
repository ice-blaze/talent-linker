<?php
use App\User;
use App\ProjectCollaborator;
use Illuminate\Database\Seeder;
use App\ProjectComment;

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
            'content'          => "Hello!",
        ]);

        ProjectComment::create([
            'project_id'       => $project->id,
            'user_id'          => $user_nico->id,
            'content'          => "Hi!",
        ]);
    }
}
