<?php

use App\Traits\DatabaseRefreshMigrations;
use App\Traits\DatabaseRefreshSeedMigrations;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class VisitorTest extends TestCase
{
    // use DatabaseMigrations;
    // use DatabaseRefreshMigrations;
    use DatabaseRefreshSeedMigrations;

    public function testHomePage()
    {
        $this->visit('/')
            ->see('Projects')
            ->see('Talents')
            ->see('About')
            ->see('Login')
            ->see('Register')
            ->see('Talent Linker')
            ->see('Find projects')
            ->see('Find talents');
    }

    public function testAboutPage()
    {
        $this->visit('/about')
            ->see('Etienne Frank')
            ->see('Michael Caraccio');
    }

    public function testWhenNoProjects()
    {
        $this->truncDatabase();
        $this->visit('/projects')
            ->see('No Projects...')
            ->see('Search Project');
    }

    public function testWhenNoTalents()
    {
        $this->truncDatabase();
        $this->visit('/talents')
            ->see('No Talents...')
            ->see('Search Talent');
    }

    public function testProjectsPage()
    {
        $this->visit('/projects')
            ->see('Search Project')
            ->see('Cool Cats')
            ->see('Programming')
            ->see('Marketing');
    }

    public function testTalentsPage()
    {
        $this->visit('/talents')
            ->see('Search Talent')
            ->see('James Test')
            ->see('Programming')
            ->see('Game Engine')
            ->see('Marketing');
    }

    public function testProjectPage()
    {
        $this->visit('/projects/1')
            ->see('Cool Cats')
            ->see('Programming')
            ->see('3 / 3')
            ->see('Game Engine')
            ->see('0 / 1')
            ->see('James Test')
            ->see('English')
            ->see('French');
    }

    public function testTalentPage()
    {
        $this->visit('/talents/1')
            ->see('James Test')
            ->see('test@test.com')
            ->see('Programming')
            ->see('Game Engine')
            ->see('Art 2D')
            ->see('Art 3D')
            ->see('English')
            ->see('French')
            ->see('German')
            ->see('Cool Cats');
    }
}
