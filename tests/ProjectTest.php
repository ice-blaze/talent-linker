<?php

use App\Traits\DatabaseTransactionWorking;

class ProjectTest extends TestCase
{
    use DatabaseTransactionWorking;

    /**
     * Login method.
     */
    public function login()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user);
    }

    /**
     * Guest user should not have access to create project page.
     */
    public function testGuestShouldNotHaveAccessToCreateProjectPage()
    {
        $this->visit('/');
        $this->visit('/projects/create');
        $this->seePageIs('/login');
    }

    /**
     * User must be logged. Test if creation page is display when the user call it.
     */
    public function testProjectShouldAccessToCreateProjectPage()
    {
        $this->login();
        $this->visit('/projects/create');
        $this->seePageIs('/projects/create');
    }

    /**
     * User must be logged. Test if field Title is empty, return an error.
     */
    public function testCreateProjectDisplayErrorWhenTitleIsMissing()
    {
        $this->login();
        $this->visit('/projects/create');
        $this->press('submit_project');
        $this->seePageIs('/projects/create');
        $this->see('The name field is required.');
    }

    /**
     * User must be logged. Test if field Short Description is empty, return an error.
     */
    public function testCreateProjectDisplayErrorWhenShortDescriptionIsMissing()
    {
        $this->login();
        $this->visit('/projects/create');
        $this->press('submit_project');
        $this->seePageIs('/projects/create');
        $this->see('The short description field is required.');
    }

    /**
     * User must be logged. Test if field Long Description is empty, return an error.
     */
    public function testCreateProjectDisplayErrorWhenLongDescriptionIsMissing()
    {
        $this->login();
        $this->visit('/projects/create');
        $this->press('submit_project');
        $this->seePageIs('/projects/create');
        $this->see('The long description field is required.');
    }

    /**
     * User must be logged. Test if field Language is empty, return an error.
     */
    public function testCreateProjectDisplayErrorWhenLanguageIsMissing()
    {
        $this->login();
        $this->visit('/projects/create');
        $this->press('submit_project');
        $this->seePageIs('/projects/create');
        $this->see('The languages field is required.');
    }

    /**
     * Create a project and check if it is correctly added in database and display.
     */
    public function testCreateProjectAndCheckCreatedProject()
    {
        // Prepare values
        $user = factory(App\User::class)->create();
        $project_skill_1 = factory(App\GeneralSkill::class)->create();
        $project_skill_1_count = '3';
        $project_skill_2 = factory(App\GeneralSkill::class)->create();
        $project_skill_2_count = '5';
        $project_language_1 = factory(App\Language::class)->create();
        $project_language_2 = factory(App\Language::class)->create();
        $project_github_link = 'http://www.google.com';
        $project_image = 'http://images.com/image.jpg';
        $project_short_description = 'New short description';
        $project_long_description = 'New long description';
        $project_name = 'New title';
        $project_website_link = 'http://www.google.fr';

        // Create project trough the interface
        $this->actingAs($user);
        $this->visit('/projects');
        $this->click('Create Project');
        $this->type($project_github_link, 'github_link');
        $this->type($project_image, 'image');
        $this->type($project_skill_1_count, 'general_skills['.$project_skill_1->id.']');
        $this->type($project_skill_2_count, 'general_skills['.$project_skill_2->id.']');
        $this->select([$project_language_1->id, $project_language_2->id], 'languages[]');
        $this->type($project_short_description, 'short_description');
        $this->type($project_long_description, 'long_description');
        $this->type($project_name, 'name');
        $this->type($project_website_link, 'website_link');
        $this->press('submit_project');

        // Get the last project created (it means our project)
        $project = App\Project::orderBy('id', 'desc')->first();

        // Check if our project display all the values
        $this->seePageIs($project->path());
        $this->see($project->name);
        $this->see($project->short_description);
        $this->see($project->long_description);
        $this->see($project->website_link);
        $this->see($project->github_link);
        $this->see($project->image);
        $this->see($project_language_1->name);
        $this->see($project_language_2->name);
        $this->see($project_skill_1->name);
        $this->see($project_skill_2->name);
        $this->see('/ '.$project_skill_1_count);
        $this->see('/ '.$project_skill_2_count);

        // Check in database
        $this->seeInDatabase('projects', [
            'id' => $project->id,
            'short_description' => $project->short_description,
            'long_description' => $project->long_description,
            'github_link' => $project->github_link,
            'website_link' => $project->website_link,
            'github_link' => $project->github_link,
            'image' => $project->image,
        ]);
    }

    /**
     * Edit a project and check if it is correctly edited in database and display.
     */
    public function testEditProjectAndCheckEditedProject()
    {
        // Create a new project
        $collab_owner = factory(App\ProjectCollaborator::class)->states('with_skill', 'with_project', 'with_user', 'owner')->create();
        $user = $collab_owner->user;
        $project = $collab_owner->project;
        $this->actingAs($user);

        // Check in database
        $this->seeInDatabase('projects', ['id' => $project->id,
            'short_description' => $project->short_description,
            'long_description' => $project->long_description,
            'github_link' => $project->github_link,
            'website_link' => $project->website_link,
            'github_link' => $project->github_link,
            'image' => $project->image, ]);

        // Set new values
        $project_skill_1 = factory(App\GeneralSkill::class)->create();
        $project_skill_1_count = '3';
        $project_skill_2 = factory(App\GeneralSkill::class)->create();
        $project_skill_2_count = '5';
        $project_language_1 = factory(App\Language::class)->create();
        $project_language_2 = factory(App\Language::class)->create();
        $github_link = 'http://www.google.com';
        $image = 'http://images.com/image.jpg';
        $short_description = 'New short description';
        $long_description = 'New long description';
        $name = 'New title';
        $website_link = 'http://www.google.fr';

        // Edit the project
        $this->visit($user->path().'/projects');
        $this->see($project->name);
        $this->visit($project->path().'/edit');
        $this->type($github_link, 'github_link');
        $this->type($image, 'image');
        $this->type($short_description, 'short_description');
        $this->type($long_description, 'long_description');
        $this->type($name, 'name');
        $this->type($website_link, 'website_link');
        $this->type($project_skill_1_count, 'general_skills['.$project_skill_1->id.']');
        $this->type($project_skill_2_count, 'general_skills['.$project_skill_2->id.']');
        $this->select([$project_language_1->id, $project_language_2->id], 'languages[]');
        $this->press('submit_project');

        // Check if the edition worked
        $this->seePageIs($project->path());
        $this->see($name);
        $this->see($short_description);
        $this->see($long_description);
        $this->see($website_link);
        $this->see($image);
        $this->see($project_language_1->name);
        $this->see($project_language_2->name);
        $this->see($project_skill_1->name);
        $this->see($project_skill_2->name);
        $this->see('/ '.$project_skill_1_count);
        $this->see('/ '.$project_skill_2_count);

        //TODO tests for the issue#106
        // Check if edit mode keep default values
        // $this->visit($project->path().'/edit');
        // $this->see($name);
        // $this->see($short_description);
        // $this->see($long_description);
        // $this->see($website_link);
        // $this->see($image);
        // $this->see($project_language_1->name);
        // $this->see($project_language_2->name);
        // $this->see($project_skill_1->name);
        // $this->see($project_skill_2->name);
        // $this->see('/ '.$project_skill_1_count);
        // $this->see('/ '.$project_skill_2_count);

        // Check if correclty updated in database
        $this->seeInDatabase('projects', [
            'id' => $project->id,
            'short_description' => 'New short description',
            'long_description' => 'New long description',
            'github_link' => 'http://www.google.com',
            'website_link' => 'http://www.google.fr',
            'image' => 'http://images.com/image.jpg',
        ]);
    }

    /**
     * Delete a project and check if it is correctly deleted in database and display.
     */
    public function testDeleteProjectAndCheckDeletedProject()
    {
        // Create a new project
        $collab_owner = factory(App\ProjectCollaborator::class)
            ->states('with_skill', 'with_project', 'with_user', 'owner')
            ->create();
        $user = $collab_owner->user;
        $project = $collab_owner->project;
        $this->actingAs($user);

        // Check in database
        $this->seeInDatabase('projects', [
            'id' => $project->id,
            'short_description' => $project->short_description,
            'long_description' => $project->long_description,
            'github_link' => $project->github_link,
            'website_link' => $project->website_link,
            'github_link' => $project->github_link,
            'image' => $project->image,
        ]);

        // Delete the project
        $url = '/talents/'.$user->id.'/projects';
        $this->visit($url);
        $this->see($project->name);
        $this->visit('/projects/'.$project->id);
        $this->press('delete');
        $this->seePageIs('/projects');

        // Check if deleted in database too
        $response = $this->call('DELETE', '/projects/'.$project->id, ['_token' => csrf_token()]);
        $this->assertEquals(404, $response->getStatusCode());
        $this->notSeeInDatabase('projects', ['id' => $project->id]);

        // Check if also deleted in project_collaborators table
        $this->notSeeInDatabase('project_collaborators', ['project_id' => $project->id]);
    }

    public function testGeneralSkillMethodes()
    {
        $collab_owner = factory(App\ProjectCollaborator::class)->states('with_skill', 'with_project', 'with_user', 'owner')->create();
        $general_skill = $collab_owner->skill;
        $user = $collab_owner->user;
        $project = $collab_owner->project;
        $user->generalSkills()->attach($general_skill);
        $project->generalSkills()->attach($general_skill, ['count' => 2]);

        $this->assertTrue($general_skill->users->contains($user));
        $this->assertTrue($general_skill->projects->contains($project));
    }

    public function testLanguageMethodes()
    {
        $collab_owner = factory(App\ProjectCollaborator::class)->states('with_skill', 'with_project', 'with_user', 'owner')->create();
        $language = factory(App\Language::class)->create();
        $user = $collab_owner->user;
        $project = $collab_owner->project;
        $user->languages()->attach($language);
        $project->languages()->attach($language);

        $this->assertTrue($language->users->contains($user));
        $this->assertTrue($language->projects->contains($project));
    }

    public function testProjectSearch()
    {
        $collab = factory(App\ProjectCollaborator::class, 2)->states('with_skill', 'with_project', 'with_user', 'owner')->create();
        $project1 = $collab[0]->project;
        $project2 = $collab[1]->project;

        $this->visit('/projects');
        $this->see($project1->name);
        $this->see($project2->name);
        $this->type($project1->name, 'search');
        $this->press('search_button');
        $this->seePageIs('/projects');
        $this->see($project1->name);
        $this->dontSee($project2->name);
    }

    public function testProjectSkillSearch()
    {
        $collab1 = factory(App\ProjectCollaborator::class)->states('with_user', 'with_skill', 'with_project', 'owner')->create();
        $project1 = $collab1->project;
        $skill1 = $collab1->skill;
        $project1->generalSkills()->attach($skill1, ['count' => 2]);
        $collab2 = factory(App\ProjectCollaborator::class)->states('with_user', 'with_skill', 'with_project', 'owner')->create();
        $project2 = $collab2->project;
        $user2 = $collab2->user;
        $skill2 = $collab2->skill;
        $project2->generalSkills()->attach($skill2, ['count' => 2]);

        $this->visit('/projects');
        $this->see($project1->name);
        $this->see($project2->name);
        $this->check('skills['.$skill1->technical_name.']');
        $this->press('search_button');
        $this->seePageIs('/projects');
        $this->see($project1->name);
        $this->dontSee($project2->name);
    }

    public function testProjectNearbySearch()
    {
        // create users
        $heidi = factory(App\User::class)->states('geo_neuchatel')->create();
        $motoko = factory(App\User::class)->states('geo_osaka')->create();
        $bato = factory(App\User::class)->states('geo_osaka')->create();

        // link users to projects as owners
        $collab_heidi = factory(App\ProjectCollaborator::class)->states('with_skill', 'with_project', 'owner')->make();
        $collab_heidi->user()->associate($heidi);
        $collab_heidi->save();
        $heidi_project = $collab_heidi->project;
        $collab_motoko = factory(App\ProjectCollaborator::class)->states('with_skill', 'with_project', 'owner')->make();
        $collab_motoko->user()->associate($motoko);
        $collab_motoko->save();
        $motoko_project = $collab_motoko->project;
        $collab_bato = factory(App\ProjectCollaborator::class)->states('with_skill', 'with_project', 'owner')->make();
        $collab_bato->user()->associate($bato);
        $collab_bato->save();
        $bato_project = $collab_bato->project;

        // Test the nearby feature
        $this->visit('/projects')
            ->dontSee('Near By')
            ->actingAs($motoko)
            ->visit('/projects')
            ->see('Near By')
            ->see('Near You')
            ->see('Not Near')
            ->see($heidi_project->name)
            ->see($bato_project->name)
            ->check('near_by')
            ->press('search_button')
            ->seePageIs('/projects')
            ->see('Near You')
            ->dontSee('Not Near')
            ->dontSee($heidi_project->name)
            ->see($bato_project->name);
    }
}
