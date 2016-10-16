<?php

class visitor_test extends TestCase
{
    use DatabaseMigrations;

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
            ->see('Find talents')
            ;
    }

    public function testProjectsPage()
    {
        $this->visit('/projects')
            ->see('Search Project')
            ->see('Cool Cats')
            ->see('Programming')
            ->see('Marketing')
            ;
    }

    public function testTalentsPage()
    {
        $this->visit('/talents')
            ->see('Search Talent')
            ->see('James Test')
            ->see('Programming')
            ->see('Game Engine')
            ->see('Marketing')
            ;
    }

    public function testAboutPage()
    {
        $this->visit('/about')
            ->see('Etienne Frank')
            ->see('Michael Caraccio')
            ;
    }

    public function testProjectPage()
    {
        //TODO
    }

    public function testTalentPage()
    {
        //TODO
    }
}
