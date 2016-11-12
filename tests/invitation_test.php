<?php

use App\Traits\DatabaseRefreshSeedMigrations;

class invitation_test extends TestCase
{
    use DatabaseRefreshSeedMigrations;

    // public function testVisitorShouldNotJoinProject()
    // {
    //     $this->assertTrue(true);
    // }

    public function testRecruiterShoulInviteUserWhoWantToAccept()
    {
        $collab_recruiter = factory(App\ProjectCollaborator::class)->states('with_skill', 'with_project', 'with_user', 'owner')->create();
        $recruiter = $collab_recruiter->user;
        $project = $collab_recruiter->project;
        $skill = $collab_recruiter->skill;
        $new_user = factory(App\User::class)->create();

        $this->actingAs($recruiter)
            ->visit($new_user->path())
            ->click('Recruit for one project')
            ->click('Cancel')
            ->seePageIs($new_user->path())
            ->click('Recruit for one project')
            ->select($project->name, 'project')
            ->select($skill->name, 'skill')
            ->press('Invite')
            ->seePageIs($new_user->path())
        // ->click($project->name)
        // ->click('role')
        // ->click($skill->name)
            ;
    }

    // public function testRecruiterShoulInviteUserWhoDontWantToAccept()
    // {
    //     $this->assertTrue(true);
    // }

    // public function testUserShouldAskAnInvitationThatTheRecruiterAccept()
    // {
    //     $this->assertTrue(true);
    // }

    // public function testUserShouldAskAnInvitationThatTheRecruiterDenied()
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
