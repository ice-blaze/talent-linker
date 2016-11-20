<?php

use App\Traits\DatabaseTransactionWorking;

class UserTest extends TestCase
{
    use DatabaseTransactionWorking;

    public function testLoginPageShouldBeAccessibleFromHomePage()
    {
        $this->visit('/')
            ->click('Login')
            ->see('Email')
            ->see('Remember Me');
    }

    public function testMessageErrorsWhenLoginWithoutCredentials()
    {
        $this->visit('/login')
            ->press('Login')
            ->see('The email field is required.')
            ->see('The password field is required.');
    }

    public function testPasswordResetingPageShouldExist()
    {
        $this->visit('/')
            ->click('Login')
            ->click('Forgot Your Password?');
    }

    public function testMessageErrorsWhenResetPasswordHasNoEmail()
    {
        $this->visit('/password/reset')
            ->press('Send Password')
            ->see('The email field is required.');
    }

    public function testSendResetEmailToWrongAdressShouldShowErrors()
    {
        $this->visit('/password/reset')
            ->type('1@1.com', 'email')
            ->press('Send Password')
            ->see("We can't find a user with that e-mail address.");
    }

    public function testSendResetPassword()
    {
        $user = factory(App\User::class)->create();

        $this->visit('/password/reset')
            ->type('', 'email')
            ->press('Send Password')
            ->see('The email field is required.')
            ->seePageIs('/password/reset')
            ->type($user->email, 'email')
            ->press('Send Password')
            ->see('We have e-mailed your password reset link!');

        $password_reset = DB::table('password_resets')->where('email', '=', $user->email)->first();

        $new_password = 'iLikeTotoroAndAllHisFriends';
        $token_url = '/password/reset/'.$password_reset->token;
        $this->visit($token_url)
            ->press('Reset Password')
            ->seePageIs($token_url)
            ->see('The email field is required.')
            ->see('The password field is required.')
            ->type($user->email, 'email')
            ->type($new_password, 'password')
            ->type($new_password, 'password_confirmation')
            ->press('Reset Password')
            ->seePageIs('/')
            ->visit('/logout')
            ->visit('/login')
            ->type($user->email, 'email')
            ->type($new_password, 'password')
            ->press('login')
            ->see($user->name);
    }

    public function testRegisterPageShouldBeAccessibleFromHomePage()
    {
        $this->visit('/')
            ->click('Register')
            ->see('Name')
            ->see('E-Mail Address')
            ->see('Password')
            ->see('Confirm Password')
            ->see('Register');
    }

    public function testEmptyRegistrationShouldShowErrorMessages()
    {
        $this->visit('/register')
            ->press('Register')
            ->see('The name field is required.')
            ->see('The email field is required.')
            ->see('The password field is required.');
    }

    public function testRegistrationShouldShowNewTalent()
    {
        $this->visit('/register')
            ->type('Testi Testo', 'name')
            ->type('testitesto@test.com', 'email')
            ->type('testtest', 'password')
            ->type('testtest', 'password_confirmation')
            ->press('Register')
            ->see('Testi Testo');
    }

    public function testLoginShouldShowUsername()
    {
        $user = factory(App\User::class)->create();
        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('test', 'password')
            ->press('Login')
            ->see($user->name);
    }

    public function testLogoutShouldNoMoreShowUsername()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user)
            ->visit('/')
            ->see($user->name)
            ->click('Logout')
            ->dontSee($user->name);
    }

    public function testMyProfileShouldDisplayUserInformations()
    {
        $general_skills = factory(App\GeneralSkill::class, 3)->create();
        $general_skills_not_used = factory(App\GeneralSkill::class, 3)->create();
        $languages = factory(App\Language::class, 3)->create();
        $languages_not_used = factory(App\Language::class, 3)->create();

        $user = factory(App\User::class)->create();
        $user->languages()->attach($languages);
        $user->generalSkills()->attach($general_skills);

        $collab_owner = factory(App\ProjectCollaborator::class)->states('with_skill', 'with_project', 'owner')->make();
        $collab_owner->user()->associate($user);
        $collab_owner->save();
        $project = $collab_owner->project;

        $this->actingAs($user)
            ->visit('/')
            ->click($user->name)
            ->click('My profile')
            ->see($user->name)
            ->see($user->email)
            ->see($project->name);

        $that = $this;
        $languages->each(function ($language) use ($that) {
            $that->see($language->name);
        });
        $languages_not_used->each(function ($language) use ($that) {
            $that->dontSee($language->name);
        });
        $general_skills->each(function ($skill) use ($that) {
            $that->see($skill->name);
        });
        $general_skills_not_used->each(function ($skill) use ($that) {
            $that->dontSee($skill->name);
        });
    }

    public function testMyProjectsShouldDisplayUserProjects()
    {
        $collab_owner = factory(App\ProjectCollaborator::class)->states('with_user', 'with_skill', 'with_project', 'owner')->create();
        $project = $collab_owner->project;
        $user = $collab_owner->user;

        $this->actingAs($user)
            ->visit('/')
            ->click($user->name)
            ->click('My projects')
            ->see($project->name)
            ->see($collab_owner->skill->name)
            ->see('Owner');
    }

    public function testTalentSearch()
    {
        $user1 = factory(App\User::class)->create();
        $user2 = factory(App\User::class)->create();

        $this->visit('/talents');
        $this->see($user1->name);
        $this->see($user2->name);
        $this->type($user1->name, 'search');
        $this->press('search_button');
        $this->seePageIs('/talents');
        $this->see($user1->name);
        $this->dontSee($user2->name);
    }

    public function testTalentNearbySearch()
    {
        $heidi = factory(App\User::class)->states('geo_neuchatel')->create();
        $motoko = factory(App\User::class)->states('geo_osaka')->create();
        $batoo = factory(App\User::class)->states('geo_osaka')->create();

        $this->visit('/talents')
            ->dontSee('Near By')
            ->actingAs($motoko)
            ->visit('/talents')
            ->see('Near By')
            ->see('Near You')
            ->see('Not Near')
            ->see($heidi->name)
            ->see($batoo->name)
            ->check('near_by')
            ->press('search_button')
            ->seePageIs('/talents')
            ->see('Near You')
            ->dontSee('Not Near')
            ->dontSee($heidi->name)
            ->see($batoo->name);
    }

    public function testTalentSkillSearch()
    {
        $collab1 = factory(App\ProjectCollaborator::class)->states('with_user', 'with_skill', 'with_project', 'owner')->create();
        $user1 = $collab1->user;
        $skill1 = $collab1->skill;
        $user1->generalSkills()->attach($skill1);
        $collab2 = factory(App\ProjectCollaborator::class)->states('with_user', 'with_skill', 'with_project', 'owner')->create();
        $user2 = $collab2->user;
        $skill2 = $collab2->skill;
        $user2->generalSkills()->attach($skill2);

        $this->visit('/talents');
        $this->see($user1->name);
        $this->see($user2->name);
        $this->check('skills['.$skill1->technical_name.']');
        $this->press('search_button');
        $this->seePageIs('/talents');
        $this->see($user1->name);
        $this->dontSee($user2->name);
    }

    public function testGuestWantToEditTalentProfile()
    {
        $user1 = factory(App\User::class)->create();
        $this->visit('/talents');
        $this->see($user1->name);
        $this->visit($user1->path().'/edit');
        $this->seePageIs('/login');
    }

    public function testStrangerWantToEditTalentProfile()
    {
        $stallone = factory(App\User::class)->create();
        $stranger = factory(App\User::class)->create();
        $this->actingAs($stranger)
            ->visit('/about')
            ->visit($stallone->path().'/edit')
            ->seePageIs('/about')
            ->see('That was not your profile');
    }

    public function testTalentWantToEditandUpdateProfile()
    {
        $general_skills = factory(App\GeneralSkill::class, 3)->create();
        $general_skills_not_used = factory(App\GeneralSkill::class, 3)->create();
        $languages = factory(App\Language::class, 3)->create();
        $languages_not_used = factory(App\Language::class, 3)->create();

        $user1 = factory(App\User::class)->create();
        $user1->languages()->attach($languages);
        $user1->generalSkills()->attach($general_skills);

        $general_skills = factory(App\GeneralSkill::class, 3)->create();
        $general_skills_not_used = factory(App\GeneralSkill::class, 3)->create();
        $languages = factory(App\Language::class, 3)->create();
        $languages_not_used = factory(App\Language::class, 3)->create();

        $user2 = factory(App\User::class)->create();
        $user2->languages()->attach($languages);
        $user2->generalSkills()->attach($general_skills);


        $this->actingAs($user1)
            ->visit('/talents/'.$user1->id.'/edit')
            ->see($user1->name)
            ->see($user1->last_name)
            ->see($user1->first_name)
            ->see($user1->talent_description)
            ->see($user1->website)
            ->see($user1->github_link)
            ->see($user1->stack_overflow)
            ->see($user1->image);

        // Edit profile and set user 2 values for user 1
        $this->actingAs($user1)
            ->visit('/talents/'.$user1->id.'/edit')
            ->type($user2->name, 'name')
            ->type($user2->last_name, 'last_name')
            ->type($user2->first_name, 'first_name')
            ->type($user2->image, 'image')
            ->type($user2->website, 'website')
            ->type($user2->github_link, 'github_link')
            ->type($user2->stack_overflow, 'stack_overflow')
            ->type($user2->talent_description, 'talent_description')
            ->press('submit_user');
        $this->seePageIs('/talents/'.$user1->id);

        // Check if save correctly
        $this->actingAs($user1)
            ->visit('/talents/'.$user1->id.'/edit')
            ->see($user2->name)
            ->see($user2->last_name)
            ->see($user2->first_name)
            ->see($user2->talent_description)
            ->see($user2->website)
            ->see($user2->github_link)
            ->see($user2->stack_overflow)
            ->see($user2->image);
    }

    public function testTalentChangeEmailWithAlreadyRegisteredEmail()
    {
        $general_skills = factory(App\GeneralSkill::class, 3)->create();
        $general_skills_not_used = factory(App\GeneralSkill::class, 3)->create();
        $languages = factory(App\Language::class, 3)->create();
        $languages_not_used = factory(App\Language::class, 3)->create();

        $user1 = factory(App\User::class)->create();
        $user1->languages()->attach($languages);
        $user1->generalSkills()->attach($general_skills);

        $user2 = factory(App\User::class)->create();

        $this->actingAs($user1)
            ->visit('/talents/'.$user1->id.'/edit')
            ->see($user1->name)
            ->see($user1->email);

        // Set email from user2 for user1
        $this->actingAs($user1)
            ->visit('/talents/'.$user1->id.'/edit')
            ->type($user2->email, 'email')
            ->press('submit_user');

        // Check if email did not changed
        $this->actingAs($user1)
            ->visit('/talents/'.$user1->id.'/edit')
            ->see($user1->name)
            ->see($user1->email);
    }

    public function testTalentUpdateProfileWithEmptyFields()
    {
        $this->truncateDatabase();

        $general_skills = factory(App\GeneralSkill::class, 3)->create();
        $general_skills_not_used = factory(App\GeneralSkill::class, 3)->create();
        $languages = factory(App\Language::class, 3)->create();
        $languages_not_used = factory(App\Language::class, 3)->create();

        $user1 = factory(App\User::class)->create();
        $user1->languages()->attach($languages);
        $user1->generalSkills()->attach($general_skills);

        // Edit empty fields
        $this->actingAs($user1)
            ->visit('/talents/'.$user1->id.'/edit')
            ->type('', 'name')
            ->type('', 'last_name')
            ->type('', 'first_name')
            ->type('', 'email')
            ->type('', 'general_skills[1]')
            ->type('', 'general_skills[2]')
            ->type('', 'general_skills[3]')
            ->type('', 'general_skills[4]')
            ->type('', 'general_skills[5]')
            ->type('', 'general_skills[6]')
            ->select([], 'languages[]')
            ->press('submit_user');
        $this->seePageIs('/talents/'.$user1->id.'/edit')
            ->see('The name field is required.')
            ->see('The last name field is required.')
            ->see('The first name field is required.')
            ->see('The email field is required.')
            ->see('The languages field is required.');
    }
}
