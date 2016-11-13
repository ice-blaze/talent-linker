<?php

use App\Traits\DatabaseRefreshMigrations;

class invitation_test extends TestCase
{
    use DatabaseRefreshMigrations;

    private function initValues()
    {
        $collab_recruiter = factory(App\ProjectCollaborator::class)->states('with_skill', 'with_project', 'with_user', 'owner')->create();
        $recruiter = $collab_recruiter->user;
        $project = $collab_recruiter->project;
        $skill = $collab_recruiter->skill;
        $new_user = factory(App\User::class)->create();

        return array($collab_recruiter, $recruiter, $project, $skill, $new_user);
    }

    public function testRecruiterShoulInviteUserAndCancelRequest()
    {
        list($collab_recruiter, $recruiter, $project, $skill, $new_user) = $this->initValues();

        // add user
        $this->actingAs($recruiter)
            ->visit($new_user->path())
            ->click('Recruit for one project')
            ->click('Cancel')
            ->seePageIs($new_user->path())
            ->click('Recruit for one project')
            ->select($project->id, 'project')
            ->select($skill->id, 'skill')
            ->press('Invite')
            ->seePageIs($new_user->path())
            ;

        $collaboration = App\ProjectCollaborator::orderBy('id', 'desc')->first();

        // check invitation is there and then delete it
        $this->visit($project->path())
            ->click('See pendings')
            ->see($new_user->name)
            ->press('delete'.$collaboration->id)
            ->seePageIs($project->path().'/invitations')
            ->dontSee($new_user->name)
            ;
    }

    public function testRecruiterShoulInviteUserWhoWantToAccept()
    {
        list($collab_recruiter, $recruiter, $project, $skill, $new_user) = $this->initValues();

        // add user
        $this->actingAs($recruiter)
            ->visit($new_user->path())
            ->click('Recruit for one project')
            ->click('Cancel')
            ->seePageIs($new_user->path())
            ->click('Recruit for one project')
            ->select($project->id, 'project')
            ->select($skill->id, 'skill')
            ->press('Invite')
            ->seePageIs($new_user->path())
            ;

        $collaboration = App\ProjectCollaborator::orderBy('id', 'desc')->first();

        // check invitation is there and then delete it
        $this->actingAs($new_user)
            ->visit($new_user->path())
            ->click('Invitations')
            ->see($project->name)
            ->press('accept'.$collaboration->id)
            ->seePageIs($new_user->path().'/invitations')
            ->see('accepted '.$collaboration->accepted_date)
            ;
    }

    public function testRecruiterShoulInviteUserWhoDontWantToAccept()
    {
        list($collab_recruiter, $recruiter, $project, $skill, $new_user) = $this->initValues();

        // add user
        $this->actingAs($recruiter)
            ->visit($new_user->path())
            ->click('Recruit for one project')
            ->click('Cancel')
            ->seePageIs($new_user->path())
            ->click('Recruit for one project')
            ->select($project->id, 'project')
            ->select($skill->id, 'skill')
            ->press('Invite')
            ->seePageIs($new_user->path())
            ;

        $collaboration = App\ProjectCollaborator::orderBy('id', 'desc')->first();

        // check invitation is there and then delete it
        $this->actingAs($new_user)
            ->visit($new_user->path())
            ->click('Invitations')
            ->see($project->name)
            ->press('delete'.$collaboration->id)
            ->seePageIs($new_user->path().'/invitations')
            ->dontSee($project->name)
            ;
    }

    public function testUserShouldAskAnInvitationThatHeCancel()
    {
        list($collab_recruiter, $recruiter, $project, $skill, $new_user) = $this->initValues();

        // add user
        $this->actingAs($new_user)
            ->visit($project->path())
            ->press('Join the project')
            ->click('Cancel')
            ->seePageIs($project->path())
            ->press('Join the project')
            ->select($skill->id, 'skill')
            ->press('Join')
            ->seePageIs($project->path())
            ->see('Invitation is pending...')
            ;

        $collaboration = App\ProjectCollaborator::orderBy('id', 'desc')->first();

        // check invitation is there and then delete it
        $this->visit($new_user->path())
            ->click('Invitations')
            ->see($project->name)
            ->press('delete'.$collaboration->id)
            ->seePageIs($new_user->path().'/invitations')
            ->dontSee($project->name)
            ;
    }

    public function testUserShouldAskAnInvitationThatTheRecruiterAccept()
    {
        list($collab_recruiter, $recruiter, $project, $skill, $new_user) = $this->initValues();

        // add user
        $this->actingAs($new_user)
            ->visit($project->path())
            ->press('Join the project')
            ->select($skill->id, 'skill')
            ->press('Join')
            ;

        $collaboration = App\ProjectCollaborator::orderBy('id', 'desc')->first();

        // check invitation is there and then delete it
        $this->actingAs($recruiter)
            ->visit($project->path().'/invitations')
            ->see($new_user->name)
            ->press('accept'.$collaboration->id)
            ->seePageIs($project->path().'/invitations')
            ->see('accepted '.$collaboration->accepted_date)
            ;
    }

    public function testUserShouldAskAnInvitationThatTheRecruiterDenied()
    {
        list($collab_recruiter, $recruiter, $project, $skill, $new_user) = $this->initValues();

        // add user
        $this->actingAs($new_user)
            ->visit($project->path())
            ->press('Join the project')
            ->select($skill->id, 'skill')
            ->press('Join')
            ;

        $collaboration = App\ProjectCollaborator::orderBy('id', 'desc')->first();

        // check invitation is there and then delete it
        $this->actingAs($recruiter)
            ->visit($project->path().'/invitations')
            ->see($new_user->name)
            ->press('delete'.$collaboration->id)
            ->seePageIs($project->path().'/invitations')
            ->dontSee($new_user->name)
            ;
    }

    // public function testVisitorShouldNotJoinProject()
    // {
    //     $this->assertTrue(true);
    // }

    // public function testUserShouldNotQuiteProjectsWhereHeDidntBelongs()
    // {
    //     $this->assertTrue(true);
    // }

    // public function testUserShouldNotDeleteInvitationOfOtherUsers()
    // {
    //     $this->assertTrue(true);
    // }

    // public function testUserShouldNotAcceptInvitationsOfOtherUsers()
    // {
    //     $this->assertTrue(true);
    // }
}
