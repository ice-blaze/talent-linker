<?php

use App\Traits\DatabaseTransactionWorking;

class VisitorTest extends TestCase
{
    use DatabaseTransactionWorking;

    private function initProjects()
    {
        $collab = factory(App\ProjectCollaborator::class)->states('with_skill', 'with_project', 'with_user', 'owner')->create();
        $project = $collab->project;
        $user = $collab->user;
        $skill = $collab->skill;

        return [$collab, $user, $project, $skill];
    }

    public function testVisitorShouldSeeHomePage()
    {
        $this->visit('/');
        $this->see('Projects');
        $this->see('Talents');
        $this->see('About');
        $this->see('Login');
        $this->see('Register');
        $this->see('Talent Linker');
        $this->see('Find projects');
        $this->see('Find talents');
    }

    public function testVisitorShouldSeeAboutPage()
    {
        $this->visit('/');
        $this->click('About');
        $this->seePageIs('/about');
        $this->see('Etienne Frank');
        $this->see('Michael Caraccio');
    }

    public function testVisitorShouldSeeWhenNoProjects()
    {
        $this->truncateDatabase();

        $this->visit('/');
        $this->click('Projects');
        $this->seePageIs('/projects');
        $this->see('No Projects...');
        $this->see('Search Project');
    }

    public function testVisitorShouldSeeWhenNoTalents()
    {
        $this->truncateDatabase();

        $this->visit('/');
        $this->click('Talents');
        $this->seePageIs('/talents');
        $this->see('No Talents...');
        $this->see('Search Talent');
    }

    public function testVisitorShouldSeeProjectsPage()
    {
        list($collab, $user, $project, $skill) = $this->initProjects();

        $this->visit('/projects');
        $this->see('Search Project');
        $this->see($project->name);
        $this->see($skill->name);
    }

    public function testVisitorShouldSeeTalentsPage()
    {
        list($collab, $user, $project, $skill) = $this->initProjects();

        $this->visit('/talents');
        $this->see('Search Talent');
        $this->see($user->name);
        $this->see($skill->name);
    }

    public function testVisitorShouldSeeProjectPage()
    {
        list($collab, $user, $project, $skill) = $this->initProjects();
        $language = factory(App\Language::class)->create();
        $project->languages()->attach($language);

        $skills_count = 20;
        $project->generalSkills()->attach($skill, ['count' => $skills_count]);

        $this->visit($project->path());
        $this->see($project->name);
        $this->see($skill->name);
        $this->see($language->name);
        $this->see($user->name);
        $this->see('1 / '.$skills_count);
    }

    public function testVisitorShouldSeeTalentPage()
    {
        list($collab, $user, $project, $skill) = $this->initProjects();
        $language = factory(App\Language::class)->create();
        $user->languages()->attach($language);

        $this->visit($user->path());
        $this->see($user->name);
        $this->see($user->email);
        $this->see($skill->name);
        $this->see($language->name);
        $this->see($project->name);
    }
}
