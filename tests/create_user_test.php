<?php
use App\Traits\DatabaseRefreshMigrations;

class create_user_test extends TestCase
{
    use DatabaseRefreshMigrations;

    public function testLoginPageShouldBeAccessibleFromHomePage()
    {
        $this->visit('/')
            ->click('Login')
            ->see('Email')
            ->see('Remember Me')
            ;
    }

    public function testMessageErrorsWhenLoginWithoutCredentials(){
        $this->visit('/login')
            ->press('Login')
            ->see('The email field is required.')
            ->see('The password field is required.')
            ;
    }

    public function testPasswordResetingPageShouldExist(){
        $this->visit('/')
            ->click('Login')
            ->click('Forgot Your Password?')
            ;
    }

    public function testMessageErrorsWhenResetPasswordHasNoEmail(){
        $this->visit('/password/reset')
            ->press('Send Password')
            ->see('The email field is required.')
            ;
    }

    public function testSendResetEmailToWrongAdressShouldShowErrors(){
        $this->visit('/password/reset')
            ->type('1@1.com', 'email')
            ->press('Send Password')
            ->see("We can't find a user with that e-mail address.")
            ;
    }

    // TODO no mailer setup
    // public function sendResetEmailToCorrectAdressShould(){
    //     $this->visit('/password/reset')
    //         ->type('', 'email')
    //         ->press('Send Password')
    //         ;
    // }

    public function testRegisterPageShouldBeAccessibleFromHomePage(){
        $this->visit('/')
            ->click('Register')
            ->see('Name')
            ->see('E-Mail Address')
            ->see('Password')
            ->see('Confirm Password')
            ->see('Register')
            ;
    }

    public function testEmptyRegistrationShouldShowErrorMessages(){
        $this->visit('/register')
            ->press('Register')
            ->see('The name field is required.')
            ->see('The email field is required.')
            ->see('The password field is required.')
            ;
    }

    public function testRegistrationShouldShowNewTalent(){
        $this->visit('/register')
            ->type('Testi Testo', 'name')
            ->type('testitesto@test.com', 'email')
            ->type('testtest', 'password')
            ->type('testtest', 'password_confirmation')
            ->press('Register')
            ->see('Testi Testo')
            ;
    }

    public function testLoginShouldShowUsername(){
        $user = factory(App\User::class)->create();
        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('test', 'password')
            ->press('Login')
            ->see($user->name)
            ;
    }

    public function testLogoutShouldNoMoreShowUsername(){
        $user = factory(App\User::class)->create();
        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('test', 'password')
            ->press('Login')
            ->see($user->name)
            ->click('Logout')
            ->dontSee($user->name)
            ;
    }

    public function testMyProfileShouldDisplayUserInformations(){
        $general_skills = factory(App\GeneralSkill::class, 3)->create();
        $general_skills_not_used = factory(App\GeneralSkill::class, 3)->create();
        $languages = factory(App\Language::class, 3)->create();
        $languages_not_used = factory(App\Language::class, 3)->create();

        $user = factory(App\User::class)->create();
        $user->languages()->attach($languages);
        $user->general_skills()->attach($general_skills);

        $collab_owner = factory(App\ProjectCollaborator::class)->states('with_skill', 'with_project', 'owner')->make();
        $collab_owner->user()->associate($user);
        $collab_owner->save();
        $project = $collab_owner->project;

        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('test', 'password')
            ->press('Login')
            ->click($user->name)
            ->click('My profile')
            ->see($user->name)
            ->see($user->email)
            ->see($project->name)
            ;

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

    public function testMyProjectsShouldDisplayUserProjects(){
        $collab_owner = factory(App\ProjectCollaborator::class)->states('with_user', 'with_skill', 'with_project', 'owner')->create();
        $project = $collab_owner->project;
        $user = $collab_owner->user;

        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('test', 'password')
            ->press('Login')
            ->click($user->name)
            ->click('My projects')
            ->see($project->name)
            ->see($collab_owner->skill->name)
            ->see('Owner')
            ;
    }
}