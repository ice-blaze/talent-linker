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

    // TODO continue when hotfix created
    // public function testRegistrationShouldShowNewTalent(){
    //     $this->visit('/register')
    //         ->type('Testi Testo', 'name')
    //         ->type('testitesto@test.com', 'email')
    //         ->type('testtest', 'password')
    //         ->type('testtest', 'password_confirmation')
    //         ;
    // }
}