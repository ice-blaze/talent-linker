<?php

use App\Traits\DatabaseTransactionWorking;

class MiddlewareTest extends TestCase
{
    use DatabaseTransactionWorking;

    /**
     * Create users / projects / comments / chat.
     **/
    public function init()
    {
        $general_skills = factory(App\GeneralSkill::class, 3)->create();
        $general_skills_not_used = factory(App\GeneralSkill::class, 3)->create();
        $languages = factory(App\Language::class, 3)->create();
        $languages_not_used = factory(App\Language::class, 3)->create();

        $user1 = factory(App\User::class)->create();
        $user1->languages()->attach($languages);
        $user1->generalSkills()->attach($general_skills);

        $collab_owner = factory(App\ProjectCollaborator::class)->states('with_skill', 'with_project', 'owner')->make();
        $collab_owner->user()->associate($user1);
        $collab_owner->save();
        $project = $collab_owner->project;

        $user2 = factory(App\User::class)->create();
        $chat = factory(App\ChatUser::class, 'no_users')->states('seen')->make();
        $chat->sender()->associate($user1);
        $chat->reciever()->associate($user2);
        $chat->save();

        $collab_owner2 = factory(App\ProjectCollaborator::class)->states('with_skill', 'with_project', 'owner')->make();
        $collab_owner2->user()->associate($user2);
        $collab_owner2->save();
        $project2 = $collab_owner2->project;

        $comment_private = factory(App\ProjectComment::class)->states('with_project', 'with_user', 'private')->create();
        $comment_private->user()->associate($user1);
        $comment_private->project()->associate($project);
        $comment_private->save();

        return [$user1, $project, $chat, $comment_private, $user2, $project2];
    }

    /**
     * Get routes.
     **/
    public function getRoutes($user, $project, $chat, $comment_private, $recruit, $recruit_project)
    {
        return [
            ['GET', '/', 200, 'guest'],
            ['GET', '/about', 200, 'guest'],
            ['GET', '/feedbacks', 200, 'auth'],
            ['GET', '/feedbacks', 302, 'guest'],
            ['GET', '/', 200, 'auth'],
            ['GET', '/about', 200, 'auth'],
            ['GET', '/talents/'.$user->id.'/edit', 200, 'auth'],
            ['GET', '/talents/'.$recruit->id.'/edit', 302, 'auth'],
            ['GET', '/talents/'.$user->id, 200, 'auth'],
            ['GET', '/talents/'.$user->id.'/chat', 200, 'auth'],
            ['GET', '/talents/'.$user->id.'/projects', 200, 'auth'],
            ['GET', '/chat/'.$chat->id.'/edit', 200, 'auth'],
            ['GET', '/projects/create', 200, 'auth'],
            ['GET', '/projects/'.$project->id.'/edit', 200, 'auth'],
            ['GET', '/projects/'.$recruit_project->id.'/edit', 302, 'auth'],
            ['GET', '/comments/'.$comment_private->id.'/edit', 200, 'auth'],
            ['GET', '/projects/'.$project->id.'/privateComments', 200, 'auth'],
            ['GET', '/projects/'.$project->id.'/invitations', 200, 'auth'],
            ['GET', '/projects/'.$project->id.'/join', 200, 'auth'],
            ['GET', '/talents/'.$user->id.'/invitations', 200, 'auth'],
            ['GET', '/talents/'.$recruit->id.'/recruit', 200, 'auth'],
            //['GET', '/projects', 200, 'auth'], TODO Failed asserting that 500 matches expected 200
            ['GET', '/projects/'.$project->id, 200, 'auth'],
            ['GET', '/talents', 200, 'auth'],
            ['GET', '/talents/'.$user->id, 200, 'auth'],
            ['GET', '/projects', 200, 'guest'],
            ['POST', '/projects', 200, 'guest'],
            ['GET', '/projects/'.$project->id, 200, 'guest'],
            ['GET', '/talents', 200, 'guest'],
            ['POST', '/talents', 200, 'guest'],
            ['GET', '/talents/'.$recruit->id.'/edit', 302, 'guest'],
            ['GET', '/talents/'.$user->id, 200, 'guest'],
            ['GET', '/projects/create', 302, 'guest'],
            ['GET', '/talents/'.$user->id.'/edit', 302, 'guest'],
            ['GET', '/talents/'.$user->id.'/chat', 302, 'guest'],
            ['GET', '/talents/'.$user->id.'/projects', 302, 'guest'],
            ['GET', '/projects/'.$recruit_project->id.'/edit', 302, 'guest'],
            ['GET', '/chat/'.$chat->id.'/edit', 302, 'guest'],
            ['GET', '/projects/create', 302, 'guest'],
            ['GET', '/projects/'.$project->id.'/edit', 302, 'guest'],
            ['GET', '/comments/'.$comment_private->id.'/edit', 302, 'guest'],
            ['GET', '/projects/'.$project->id.'/privateComments', 302, 'guest'],
            ['GET', '/projects/'.$project->id.'/invitations', 302, 'guest'],
            ['GET', '/projects/'.$project->id.'/join', 302, 'guest'],
            ['GET', '/talents/'.$user->id.'/invitations', 302, 'guest'],
            ['GET', '/talents/'.$recruit->id.'/recruit', 302, 'guest'],
            ['GET', '/dashboard', 302, 'guest'],
            ['GET', '/dashboard', 302, 'auth'],
            ['GET', '/dashboard', 200, 'admin'],
            ['GET', '/talents/'.$user->id, 200, 'admin'],
            ['GET', '/projects/create', 200, 'admin'],
            ['GET', '/talents/'.$user->id.'/edit', 302, 'admin'],
            ['GET', '/talents/'.$user->id.'/chat', 200, 'admin'],
            ['GET', '/talents/'.$user->id.'/projects', 200, 'admin'],
            ['GET', '/chat/'.$chat->id.'/edit', 302, 'admin'],
            ['GET', '/projects/create', 200, 'admin'],
            ['GET', '/projects/'.$project->id.'/edit', 200, 'admin'],
            ['GET', '/comments/'.$comment_private->id.'/edit', 302, 'admin'],
            ['GET', '/projects/'.$project->id.'/privateComments', 200, 'admin'],
            ['GET', '/projects/'.$project->id.'/invitations', 302, 'admin'],
            ['GET', '/projects/'.$project->id.'/join', 200, 'admin'],
            ['GET', '/talents/'.$user->id.'/invitations', 302, 'admin'],
            ['GET', '/talents/'.$recruit->id.'/recruit', 302, 'admin'],
            ['GET', '/projects/'.$recruit_project->id.'/edit', 200, 'admin'],
            //['GET', '/talents/'.$recruit->id.'/edit', 302, 'admin'], TODO Admin can edit users profiles.
        ];
    }

    /**
     * Run Auth Test.
     **/
    public function runAuth($route, $user)
    {
        list($type, $uri, $responseCode, $middleware) = $route;
        $this->actingAs($user);

        $response = $this->call($type, $uri);
        $this->assertEquals($responseCode, $response->status());
    }

    /**
     * Run Admin Test.
     **/
    public function runAdmin($route)
    {
        list($type, $uri, $responseCode, $middleware) = $route;
        $adminUser = factory(App\User::class)->states('admin')->create();
        $this->actingAs($adminUser);

        $response = $this->call($type, $uri);
        $this->assertEquals($responseCode, $response->status());
    }

    /**
     * Run Guest Test.
     **/
    public function runGuest($route)
    {
        list($type, $uri, $responseCode, $middleware) = $route;

        $response = $this->call($type, $uri);
        $this->assertEquals($responseCode, $response->status());
    }

    public function testAuthMiddleware()
    {
        list($user, $project, $chat, $comment_private, $recruit, $recruit_project) = $this->init();

        $routes = $this->getRoutes($user, $project, $chat, $comment_private, $recruit, $recruit_project);

        foreach ($routes as $route) {
            list($type, $uri, $responseCode, $middleware) = $route;

            if ($middleware == 'auth') {
                $this->runAuth($route, $user);
            }
        }
    }

    public function testAdminMiddleware()
    {
        list($user, $project, $chat, $comment_private, $recruit, $recruit_project) = $this->init();

        $routes = $this->getRoutes($user, $project, $chat, $comment_private, $recruit, $recruit_project);

        foreach ($routes as $route) {
            list($type, $uri, $responseCode, $middleware) = $route;

            if ($middleware == 'admin') {
                $this->runAdmin($route);
            }
        }
    }

    public function testGuestMiddleware()
    {
        list($user, $project, $chat, $comment_private, $recruit, $recruit_project) = $this->init();

        $routes = $this->getRoutes($user, $project, $chat, $comment_private, $recruit, $recruit_project);

        foreach ($routes as $route) {
            list($type, $uri, $responseCode, $middleware) = $route;

            if ($middleware == 'guest') {
                $this->runGuest($route);
            }
        }
    }
}
