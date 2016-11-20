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

    public function testUserShouldEditHisComment()
    {
        $collab = factory(App\ProjectCollaborator::class)->states('with_skill', 'with_project', 'with_user', 'owner')->create();
        $user = $collab->user;
        $project = $collab->project;
        $comment = factory(ProjectComment::class)->states('public')->make();
        $comment->user()->associate($user);
        $comment->project()->associate($project);
        $comment->save();

        $new_message = 'my new comment message';

        $this->actingAs($user)
            ->visit($project->path())
            ->click('comment_edit'.$comment->id)
            ->seePageIs($comment->path())
            ->type($new_message, 'content')
            ->press('update_comment')
            ->seePageIs($project->path())
            ->see($new_message);
    }

    public function testUserShouldDeleteHisComment()
    {
        $collab = factory(App\ProjectCollaborator::class)->states('with_skill', 'with_project', 'with_user', 'owner')->create();
        $user = $collab->user;
        $project = $collab->project;
        $comment = factory(ProjectComment::class)->states('public')->make();
        $comment->user()->associate($user);
        $comment->project()->associate($project);
        $comment->save();

        $old_message = $comment->content;

        $this->actingAs($user)
            ->visit($project->path())
            ->click('comment_edit'.$comment->id)
            ->seePageIs($comment->path())
            ->press('delete_comment')
            ->seePageIs($project->path())
            ->dontSee($old_message);
    }

    public function testStrangerShouldNotEditOthersComment()
    {
        $comment = factory(ProjectComment::class)->states('with_project', 'with_user', 'public')->create();
        $project = $comment->project;

        $stranger = factory(User::class)->create();

        $this->actingAs($stranger)
            ->visit('/about')
            ->visit($comment->path())
            ->seePageIs('/')
            ->see('You are not authorized to do this action!');
    }

    public function testStrangerShouldNotDeleteOthersComment()
    {
        $comment = factory(ProjectComment::class)->states('with_project', 'with_user', 'public')->create();
        $project = $comment->project;

        $stranger = factory(User::class)->create();

        $this->actingAs($stranger)
            ->visit('/about');

        $this->call('DELETE', 'comments/'.$comment->id);
        $this->followRedirects();

        $this->seePageIs('/')
            ->see('You are not authorized to do this action!');
    }
}
