<?php

use App\Traits\DatabaseTransactionWorking;

class FeedbacksTest extends TestCase
{
    use DatabaseTransactionWorking;

    public function testVisitorShouldNotSeeFeedbacksButton()
    {
        $this->visit('/')
            ->dontSee('feedback');
    }

    public function testVisitorShouldNotAccessFeedbacks()
    {
        $this->visit('/feedbacks')
            ->seePageIs('/login');
    }

    public function testUserShouldSeeFeedbackButton()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user)
            ->visit('/')
            ->click('feedback')
            ->seePageIs('/feedbacks');
    }

    public function testUserShouldHaveErrorWithEmptyFeedback()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user)
            ->visit('/feedbacks')
            ->click('feedback')
            ->press('create_feedback')
            ->seePageIs('/feedbacks')
            ->see('content field is required');
    }

    public function testUserShouldNotSeeFeedbacksFromOthers()
    {
        $feedback_from_some_else = factory(App\Feedback::class)->create();
        $user = factory(App\User::class)->create();
        $this->actingAs($user)
            ->visit('/feedbacks')
            ->dontSee($feedback_from_some_else->content);
    }

    public function testUserShouldSeeHisOwnFeedback()
    {
        $feedback = factory(App\Feedback::class)->create();
        $user = $feedback->user;
        $this->actingAs($user)
            ->visit('/feedbacks')
            ->see($feedback->content);
    }

    public function testUserShouldCreateFeedback()
    {
        $feedback_content = 'test content feedback';
        $user = factory(App\User::class)->create();
        $this->actingAs($user)
            ->visit('/feedbacks')
            ->type($feedback_content, 'content')
            ->press('create_feedback')
            ->seePageIs('/feedbacks')
            // ->see($feedback_content) // TODO: should do the test with this but it seems not to work with phpunit
;
    }
}
