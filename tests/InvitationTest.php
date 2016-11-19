<?php

use App\Traits\DatabaseTransactionWorking;

class InvitationTest extends TestCase
{
    use DatabaseTransactionWorking;

    private function initValues()
    {
        $collab_recruiter = factory(App\ProjectCollaborator::class)->states('with_skill', 'with_project', 'with_user', 'owner')->create();
        $recruiter = $collab_recruiter->user;
        $project = $collab_recruiter->project;
        $skill = $collab_recruiter->skill;
        $new_user = factory(App\User::class)->create();

        return [$collab_recruiter, $recruiter, $project, $skill, $new_user];
    }

    public function testRecruiterShoulInviteUserAndCancelRequest()
    {
        list($collab_recruiter, $recruiter, $project, $skill, $new_user) = $this->initValues();

        // add user
        $this->actingAs($recruiter);
        $this->visit($new_user->path());
        $this->click('Recruit for one project');
        $this->click('Cancel');
        $this->seePageIs($new_user->path());
        $this->click('Recruit for one project');
        $this->select($project->id, 'project');
        $this->select($skill->id, 'skill');
        $this->press('Invite');
        $this->seePageIs($new_user->path());

        $collaboration = App\ProjectCollaborator::orderBy('id', 'desc')->first();

        // check invitation is there and then delete it
        $this->visit($project->path());
        $this->click('See pendings');
        $this->see($new_user->name);
        $this->press('delete'.$collaboration->id);
        $this->seePageIs($project->path().'/invitations');
        $this->dontSee($new_user->name);
    }

    public function testRecruiterShoulInviteUserWhoWantToAccept()
    {
        list($collab_recruiter, $recruiter, $project, $skill, $new_user) = $this->initValues();

        // add user
        $this->actingAs($recruiter);
        $this->visit($new_user->path());
        $this->click('Recruit for one project');
        $this->click('Cancel');
        $this->seePageIs($new_user->path());
        $this->click('Recruit for one project');
        $this->select($project->id, 'project');
        $this->select($skill->id, 'skill');
        $this->press('Invite');
        $this->seePageIs($new_user->path());

        $collaboration = App\ProjectCollaborator::orderBy('id', 'desc')->first();

        // check invitation is there and then delete it
        $this->actingAs($new_user);
        $this->visit($new_user->path());
        $this->click('Invitations');
        $this->see($project->name);
        $this->press('accept'.$collaboration->id);
        $this->seePageIs($new_user->path().'/invitations');
        $this->see('accepted '.$collaboration->accepted_date);
    }

    public function testRecruiterShoulInviteUserWhoDontWantToAccept()
    {
        list($collab_recruiter, $recruiter, $project, $skill, $new_user) = $this->initValues();

        // add user
        $this->actingAs($recruiter);
        $this->visit($new_user->path());
        $this->click('Recruit for one project');
        $this->click('Cancel');
        $this->seePageIs($new_user->path());
        $this->click('Recruit for one project');
        $this->select($project->id, 'project');
        $this->select($skill->id, 'skill');
        $this->press('Invite');
        $this->seePageIs($new_user->path());

        $collaboration = App\ProjectCollaborator::orderBy('id', 'desc')->first();

        // check invitation is there and then delete it
        $this->actingAs($new_user);
        $this->visit($new_user->path());
        $this->click('Invitations');
        $this->see($project->name);
        $this->press('delete'.$collaboration->id);
        $this->seePageIs($new_user->path().'/invitations');
        $this->dontSee($project->name);
    }

    public function testUserShouldAskAnInvitationThatHeCancel()
    {
        list($collab_recruiter, $recruiter, $project, $skill, $new_user) = $this->initValues();

        // add user
        $this->actingAs($new_user);
        $this->visit($project->path());
        $this->press('Join the project');
        $this->click('Cancel');
        $this->seePageIs($project->path());
        $this->press('Join the project');
        $this->select($skill->id, 'skill');
        $this->press('Join');
        $this->seePageIs($project->path());
        $this->see('Invitation is pending...');

        $collaboration = App\ProjectCollaborator::orderBy('id', 'desc')->first();

        // check invitation is there and then delete it
        $this->visit($new_user->path());
        $this->click('Invitations');
        $this->see($project->name);
        $this->press('delete'.$collaboration->id);
        $this->seePageIs($new_user->path().'/invitations');
        $this->dontSee($project->name);
    }

    public function testUserShouldAskAnInvitationThatTheRecruiterAccept()
    {
        list($collab_recruiter, $recruiter, $project, $skill, $new_user) = $this->initValues();

        // add user
        $this->actingAs($new_user);
        $this->visit($project->path());
        $this->press('Join the project');
        $this->select($skill->id, 'skill');
        $this->press('Join');

        $collaboration = App\ProjectCollaborator::orderBy('id', 'desc')->first();

        // check invitation is there and then delete it
        $this->actingAs($recruiter);
        $this->visit($project->path().'/invitations');
        $this->see($new_user->name);
        $this->press('accept'.$collaboration->id);
        $this->seePageIs($project->path().'/invitations');
        $this->see('accepted '.$collaboration->accepted_date);
    }

    public function testUserShouldAskAnInvitationThatTheRecruiterDenied()
    {
        list($collab_recruiter, $recruiter, $project, $skill, $new_user) = $this->initValues();

        // add user
        $this->actingAs($new_user);
        $this->visit($project->path());
        $this->press('Join the project');
        $this->select($skill->id, 'skill');
        $this->press('Join');

        $collaboration = App\ProjectCollaborator::orderBy('id', 'desc')->first();

        // check invitation is there and then delete it
        $this->actingAs($recruiter);
        $this->visit($project->path().'/invitations');
        $this->see($new_user->name);
        $this->press('delete'.$collaboration->id);
        $this->seePageIs($project->path().'/invitations');
        $this->dontSee($new_user->name);
    }

    public function testUserShouldQuitProject()
    {
        list($collab_recruiter, $user, $project, $skill, $new_user) = $this->initValues();

        $project_name = $project->name;

        $this->actingAs($user);

        // Check project exist on the main page
        $this->visit('/projects');
        $this->see($project_name);

        // Quite project
        $this->visit($user->path().'/invitations');
        $this->press('Quit Project');
        $this->seePageIs($user->path().'/invitations');

        // Check project don't exist anymore
        $this->visit('/projects');
        $this->dontSee($project_name);
    }

    public function testStrangerShouldNotAccesToInvitationIndexOfPorjectsHeDontParticipate()
    {
        list($collab_recruiter, $recruiter, $project, $skill, $stranger) = $this->initValues();

        $this->actingAs($stranger)
            ->visit('/')
            ->visit($project->path().'/invitations')
            ->seePageIs('/')
            ->see('That was not your project');
    }

    public function testStrangerShouldNotAccesToInvitationIndexOfOtherUsers()
    {
        list($collab_recruiter, $recruiter, $project, $skill, $stranger) = $this->initValues();

        $this->actingAs($stranger)
            ->visit('/')
            ->visit($recruiter->path().'/invitations')
            ->seePageIs('/')
            ->see("You can't access to other users invitation page");
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
