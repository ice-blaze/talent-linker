<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Traits\DatabaseRefreshMigrations;
use App\Traits\DatabaseRefreshSeedMigrations;

class visitor_test extends TestCase
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
            ->see('Find talents')
            ;
    }

    public function testAboutPage()
    {
        $this->visit('/about')
            ->see('Etienne Frank')
            ->see('Michael Caraccio')
            ;
    }

    public function testWhenNoProjects()
    {
        $this->truncDatabase();
        $this->visit('/projects')
            ->see('No Projects...')
            ->see('Search Project')
            ;
    }

    public function testWhenNoTalents()
    {
        $this->truncDatabase();
        $this->visit('/talents')
            ->see('No Talents...')
            ->see('Search Talent')
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

    public function testProjectPage()
    {
        $this->visit('/projects/1')
            ->see('Cool Cats')
            ->see('Programming')
            ->see('2 / 3')
            ->see('Game Engine')
            ->see('0 / 1')
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

    // learning purpose:
    // public function initializeData(){
    // $project = factory(App\Project::class)->create(); #TODO not working, missing short description
    // $general_skill = factory(App\GeneralSkill::class)->create();
    // $user1 = factory(App\User::class)->create();
    // $user2 = factory(App\User::class)->create();
    // $chatuser = factory(App\ChatUser::class)->make();
    // $chatuser->sender_id = $user1->id;
    // $chatuser->reciever_id = $user2->id;
    // $chatuser->save();
    // $feedback = factory(App\Feedback::class, 'no_user')
    //     ->make()
    //     ->each(function ($f) {
    //         $f->user(factory(App\User::class)->create());
    //     });
    // $feedback = factory(App\Feedback::class)
    //     ->create();
    // }
    //
    // $chat = factory(App\ChatUser::class, 'no_users')->states('seen')->make();
    // $chat->sender()->associate($user1);
    // $chat->reciever()->associate($user2);
    // $chat->save();
}
