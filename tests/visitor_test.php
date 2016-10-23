<?php

class visitor_test extends TestCase
{
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
        $this->visit('/projects/1')
            ->see('Cool Cats')
            ->see('Programming 2 / 3')
            ->see('Game Engine 0 / 1')
            ->see('James Test')
            ->see('English')
            ->see('French')
            ;
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
            ->see('Cool Cats')
            ->see('Cat Blender')
            ;
    }
}
