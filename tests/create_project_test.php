<?php

use App\Traits\DatabaseRefreshSeedMigrations;

class create_project_test extends TestCase
{
    use DatabaseRefreshSeedMigrations;

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
        /*$this->visit('/');
        $this->visit('/projects/create');
        $this->seePageIs('/projects/create');*/
    }

    /**
     * User must be logged. Test if creation page is display when the user call it.
     */
    public function testProjectShouldAccessToCreateProjectPage()
    {
        $this->login();
        $this->visit('/');
        $this->visit('/talents/1/projects');
        $this->visit('/projects/create');
        $this->seePageIs('/projects/create');
    }

    /**
     * User must be logged. Test if field Title is empty, return an error.
     */
    public function testCreateProjectDisplayErrorWhenTitleIsMissing()
    {
        $this->login();
        $this->visit('/');
        $this->visit('/talents/1/projects');
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
        $this->visit('/');
        $this->visit('/talents/1/projects');
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
        $this->visit('/');
        $this->visit('/talents/1/projects');
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
        $this->visit('/');
        $this->visit('/talents/1/projects');
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

        // Create a new project
        $collab_owner = factory(App\ProjectCollaborator::class)->states('with_skill', 'with_project', 'with_user', 'owner')->create();
        $user = $collab_owner->user;
        $project = $collab_owner->project;

        // Find the project that the user created
        $url = '/talents/'.$user->id.'/projects';

        $this->actingAs($user);

        // Visit users project and check if it exists
        $this->visit($url);
        $this->see($project->name);

        // Check in database
        $this->seeInDatabase('projects', ['id' => $project->id,
            'short_description' => $project->short_description,
            'long_description' => $project->long_description,
            'github_link' => $project->github_link,
            'website_link' => $project->website_link,
            'github_link' => $project->github_link,
            'image' => $project->image, ]);

        // See project details
        $this->visit('/projects/'.$project->id);
        $this->see($project->name);
        $this->see($project->short_description);
        $this->see($project->long_description);
        $this->see($project->website_link);
        $this->see($project->image);
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

        // Edit the project
        $url = '/talents/'.$user->id.'/projects';
        $this->visit($url);
        $this->see($project->name);
        $this->visit('/projects/'.$project->id.'/edit');

        // Set new values
        $skills_1 = '3';
        $skills_2 = '5';
        $language_1 = '1';
        $language_2 = '2';
        $github_link = 'http://www.google.com';
        $image = 'http://images.com/image.jpg';
        $short_description = 'New short description';
        $long_description = 'New long description';
        $name = 'New title';
        $website_link = 'http://www.google.fr';

        $this->type($skills_1, 'general_skills[1]');
        $this->type($skills_2, 'general_skills[5]');
        $this->select($language_1, 'languages[]');
        $this->select($language_2, 'languages[]');
        $this->type($github_link, 'github_link');
        $this->type($image, 'image');
        $this->type($short_description, 'short_description');
        $this->type($long_description, 'long_description');
        $this->type($name, 'name');
        $this->type($website_link, 'website_link');
        $this->press('submit_project');
        $this->seePageIs('/projects/'.$project->id);

        $this->visit('/projects/'.$project->id.'/edit');
        $this->see($name);
        $this->see($short_description);
        $this->see($long_description);
        $this->see($website_link);
        $this->see($image);

        // Check if correclty updated in database
        $this->seeInDatabase('projects', ['id' => $project->id,
            'short_description' => 'New short description',
            'long_description' => 'New long description',
            'github_link' => 'http://www.google.com',
            'website_link' => 'http://www.google.fr',
            'image' => 'http://images.com/image.jpg', ]);
    }

    /**
     * Delete a project and check if it is correctly deleted in database and display.
     */
    public function testDeleteProjectAndCheckDeletedProject()
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
}
