<?php

use App\User;
use App\Project;
use App\Language;
use Carbon\Carbon;
use App\GeneralSkill;
use App\ProjectCollaborator;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    public function run()
    {
        $skill_prog = GeneralSkill::find(1);
        $skill_gameengine = GeneralSkill::find(2);
        $user_james = User::find(1);
        $user_nico = User::find(2);
        $user_richard = User::find(3);

        $language_english = Language::find(1);
        $language_french = Language::find(2);

        $long_description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

        $project = Project::create([
            'name'              => 'Cool Cats',
            'short_description' => 'Cool all those cats!',
            'long_description'  => $long_description,
            'image'             => 'http://i.imgur.com/CQbO0cc.jpg',
            'github_link'       => 'http://example.com/my_github',
            'website_link'      => 'http://example.com/my_project',
        ]);

        ProjectCollaborator::create([
            'skill_id'          => $skill_prog->id,
            'project_id'        => $project->id,
            'is_project_owner'  => true,
            'user_id'           => $user_james->id,
            'accepted'          => true,
            'from_collaborator' => false,
            'invite_message'    => 'initial seed',
            'accepted_date'     => Carbon::now(),
        ]);

        DB::table('language_project')->insert([
            'language_id' => $language_english->id,
            'project_id'  => $project->id,
        ]);
        DB::table('language_project')->insert([
            'language_id' => $language_french->id,
            'project_id'  => $project->id,
        ]);

        DB::table('general_skill_project')->insert([
            'general_skill_id' => $skill_gameengine->id,
            'project_id'       => $project->id,
            'count'            => 1,
        ]);
        DB::table('general_skill_project')->insert([
            'general_skill_id' => $skill_prog->id,
            'project_id'       => $project->id,
            'count'            => 3,
        ]);

        $project = Project::create([
            'name'              => 'Cat Blender',
            'short_description' => 'Cat bulenderu!',
            'long_description'  => $long_description,
            'image'             => 'https://cuteoverload.files.wordpress.com/2009/09/kitten_in_blender.jpg',
            'github_link'       => 'http://example.com/my_github',
        ]);

        ProjectCollaborator::create([
            'skill_id'          => $skill_gameengine->id,
            'project_id'        => $project->id,
            'is_project_owner'  => true,
            'user_id'           => $user_nico->id,
            'accepted'          => true,
            'from_collaborator' => false,
            'invite_message'    => 'initial seed',
            'accepted_date'     => Carbon::now(),
        ]);

        DB::table('language_project')->insert([
            'language_id' => $language_french->id,
            'project_id'  => $project->id,
        ]);

        DB::table('general_skill_project')->insert([
            'general_skill_id' => $skill_gameengine->id,
            'project_id'       => $project->id,
            'count'            => 1,
        ]);
        DB::table('general_skill_project')->insert([
            'general_skill_id' => $skill_prog->id,
            'project_id'       => $project->id,
            'count'            => 3,
        ]);

        $project = Project::create([
            'name'              => 'Burrito Cat',
            'short_description' => 'Amazing BURRITO CAT !!',
            'long_description'  => $long_description,
            'image'             => 'https://c1.staticflickr.com/3/2389/2073509907_345ad52bc1.jpg',
        ]);

        ProjectCollaborator::create([
            'skill_id'          => $skill_prog->id,
            'project_id'        => $project->id,
            'is_project_owner'  => true,
            'user_id'           => $user_richard->id,
            'accepted'          => true,
            'from_collaborator' => false,
            'invite_message'    => 'initial seed',
            'accepted_date'     => Carbon::now(),
        ]);

        DB::table('language_project')->insert([
            'language_id' => $language_english->id,
            'project_id'  => $project->id,
        ]);

        DB::table('general_skill_project')->insert([
            'general_skill_id' => $skill_gameengine->id,
            'project_id'       => $project->id,
            'count'            => 1,
        ]);
        DB::table('general_skill_project')->insert([
            'general_skill_id' => $skill_prog->id,
            'project_id'       => $project->id,
            'count'            => 3,
        ]);

        $project = Project::create([
            'name'              => 'Cat of Hell',
            'short_description' => 'Devil cat is here!',
            'long_description'  => $long_description,
            'image'             => 'http://i.imgur.com/QUTsudb.jpg',
        ]);
        ProjectCollaborator::create([
            'skill_id'          => $skill_prog->id,
            'project_id'        => $project->id,
            'is_project_owner'  => true,
            'user_id'           => $user_richard->id,
            'accepted'          => true,
            'from_collaborator' => false,
            'invite_message'    => 'initial seed',
            'accepted_date'     => Carbon::now(),
        ]);
        $project = Project::create([
            'name'              => 'Trumpo Cat',
            'short_description' => 'Make Amurica great again !',
            'long_description'  => $long_description,
            'image'             => 'http://i.imgur.com/7NPGotE.jpg',
        ]);
        ProjectCollaborator::create([
            'skill_id'          => $skill_prog->id,
            'project_id'        => $project->id,
            'is_project_owner'  => true,
            'user_id'           => $user_richard->id,
            'accepted'          => true,
            'from_collaborator' => false,
            'invite_message'    => 'initial seed',
            'accepted_date'     => Carbon::now(),
        ]);
        $project = Project::create([
            'name'              => 'Cat Box',
            'short_description' => 'A place to stow your cat!',
            'long_description'  => $long_description,
            'image'             => 'http://i.imgur.com/MpE7Aop.jpg',
        ]);
        ProjectCollaborator::create([
            'skill_id'          => $skill_prog->id,
            'project_id'        => $project->id,
            'is_project_owner'  => true,
            'user_id'           => $user_richard->id,
            'accepted'          => true,
            'from_collaborator' => false,
            'invite_message'    => 'initial seed',
            'accepted_date'     => Carbon::now(),
        ]);

        $project = Project::create([
            'name'              => 'Empty',
            'short_description' => 'Empty',
            'long_description'  => 'Empty',
        ]);
        ProjectCollaborator::create([
            'skill_id'          => $skill_prog->id,
            'project_id'        => $project->id,
            'is_project_owner'  => true,
            'user_id'           => $user_richard->id,
            'accepted'          => true,
            'from_collaborator' => false,
            'invite_message'    => 'initial seed',
            'accepted_date'     => Carbon::now(),
        ]);

        // create empty projects for the pagination
        function createRandomProject($projectId, $user, $skill) {
            $project = Project::create([
                'name'              => 'Empty'.$projectId,
                'short_description' => 'Empty short description '.$projectId,
                'long_description'  => 'Empty long description '.$projectId,
            ]);
            ProjectCollaborator::create([
                'skill_id'          => $skill->id,
                'project_id'        => $project->id,
                'is_project_owner'  => true,
                'user_id'           => $user->id,
                'accepted'          => true,
                'from_collaborator' => false,
                'invite_message'    => 'initial seed',
                'accepted_date'     => Carbon::now(),
            ]);
        }
        foreach (range(0, 100) as $number) {
            createRandomProject($number, $user_richard, $skill_prog);
        }
    }
}
