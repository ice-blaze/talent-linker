<?php
use App\Traits\DatabaseRefreshSeedMigrations;

class create_user_test extends TestCase
{
    use DatabaseRefreshSeedMigrations;

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
        $this->visit('/login')
            ->type('test@test.com', 'email')
            ->type('test', 'password')
            ->press('Login')
            ->click('James Test')
            ->click('Logout')
            ->dontSee('James Test')
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
        // TODO: create projects for the user(factory)

        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('test', 'password')
            ->press('Login')
            ->click($user->name)
            ->click('My profile')
            ->see($user->name)
            ->see($user->email)
            ->see($languages[0]->name)
            // ->see('Cool Cats')
            // ->see('Cat Blender')
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

    // THOUGHTS: Really seed related
    public function testMyProjectsShouldDisplayUserProjects(){
        $this->visit('/login')
            ->type('test@test.com', 'email')
            ->type('test', 'password')
            ->press('Login')
            ->click('James Test')
            ->click('My projects')
            ->see('Cool Cats')
            ->see('Programming')
            ->see('Owner')
            ->see('Cat Blender')
            ->see('Art 2D')
            ;
    }

}