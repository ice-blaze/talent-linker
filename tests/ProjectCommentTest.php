<?php

use App\Traits\DatabaseTransactionWorking;

use App\User;
use App\ProjectComment;
use App\ProjectCollaborator;

class ProjectCommentTest extends TestCase
{
    use DatabaseTransactionWorking;

    private function initValues()
    {
        $collab_owner = factory(ProjectCollaborator::class)->states('with_skill', 'with_project', 'with_user', 'owner')->create();
        $owner = $collab_owner->user;
        $project = $collab_owner->project;
        $skill = $collab_owner->skill;
        $user = factory(User::class)->create();

        return [$collab_owner, $owner, $project, $skill, $user];
    }

    public function testCollaboratorShouldCommentOnProject()
    {
        list($collab_owner, $owner, $project, $skill, $user) = $this->initValues();
        $comment_message = 'comment test';

        $this->actingAs($owner);
        $this->visit($project->path());
        $this->type($comment_message, 'content');
        $this->press('comment');
        $this->seePageIs($project->path());
        $this->see($comment_message);
    }

    public function testCollaboratorShouldCommentOnPrivateProjectChat()
    {
        list($collab_owner, $owner, $project, $skill, $user) = $this->initValues();
        $comment_message = 'comment private test';

        $this->actingAs($owner);
        $this->visit($project->path());
        $this->click('Private chat');
        $this->seePageIs($project->path().'/privateComments');
        $this->type($comment_message, 'content');
        $this->press('comment');
        $this->seePageIs($project->path().'/privateComments');
        $this->see($comment_message);
    }

    public function testUserShouldCommentOnProject()
    {
        list($collab_owner, $owner, $project, $skill, $user) = $this->initValues();
        $comment_message = 'comment test';

        $this->actingAs($user);
        $this->visit($project->path());
        $this->type($comment_message, 'content');
        $this->press('comment');
        $this->seePageIs($project->path());
        $this->see($comment_message);
    }

    public function testPrivateCommentFactory()
    {
        // Check private comment factory
        $comment_private = factory(ProjectComment::class)->states('with_project', 'with_user', 'private')->create();
        $user = $comment_private->user;
        $project = $comment_private->project;

        // Change user as collaborator
        $collab = factory(ProjectCollaborator::class)->states('with_skill', 'accepted', 'owner')->make();
        $collab->user()->associate($user);
        $collab->project()->associate($project);
        $collab->save();

        $this->actingAs($user);
        $this->visit($project->path().'/privateComments');
        $this->see($comment_private->content);
    }

    public function testPublicCommentFactory()
    {
        // Check public comment factory
        $comment_public = factory(ProjectComment::class)->states('with_project', 'with_user', 'public')->create();
        $user = $comment_public->user;
        $project = $comment_public->project;

        // Set owner, project without owner crash
        $collab = factory(ProjectCollaborator::class)->states('with_skill', 'accepted', 'with_user', 'owner')->make();
        $collab->project()->associate($project);
        $collab->save();

        $this->actingAs($user);
        $this->visit($project->path());
        $this->see($comment_public->content);
    }
}
