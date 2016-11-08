<?php

use App\Traits\DatabaseRefreshMigrations;

class create_project_test extends TestCase
{
	use DatabaseRefreshMigrations;

	/**
	 * Login method
	 */
	public function login(){
		$user = factory(App\User::class)->create();
		$this->visit('/login')
		->type($user->email, 'email')
		->type('test', 'password')
		->press('Login')
		->see($user->name);
	}

	/**
	 * Guest user should not have access to create project page
	 */
	public function testGuestShouldNotHaveAccessToCreateProjectPage()
	{
		/*$this->visit('/');
		$this->visit('/projects/create');
		$this->seePageIs('/projects/create');*/
	}

	/**
	 * User must be logged. Test if creation page is display when the user call it
	 */
	public function testProjectShouldAccessToCreateProjectPage()
	{
		$this->login();
		$this->visit('/');
		$this->visit('/talents/1/projects');
		$this->visit('/projects/create');
		$this->seePageIs('/projects/create');
	}

	/**
	 * User must be logged. Test if field Title is empty, return an error
	 */
	public function testCreateProjectDisplayErrorWhenTitleIsMissing()
	{
		$this->login();
		$this->visit('/');
		$this->visit('/talents/1/projects');
		$this->visit('/projects/create');
		$this->press('submit_project');
		$this->seePageIs('/projects/create');
		$this->see('The name field is required.');
	}

	/**
	 * User must be logged. Test if field Short Description is empty, return an error
	 */
	public function testCreateProjectDisplayErrorWhenShortDescriptionIsMissing()
	{
		$this->login();
		$this->visit('/');
		$this->visit('/talents/1/projects');
		$this->visit('/projects/create');
		$this->press('submit_project');
		$this->seePageIs('/projects/create');
		$this->see('The short description field is required.');
	}

	/**
	 * User must be logged. Test if field Long Description is empty, return an error
	 */
	public function testCreateProjectDisplayErrorWhenLongDescriptionIsMissing()
	{
		$this->login();
		$this->visit('/');
		$this->visit('/talents/1/projects');
		$this->visit('/projects/create');
		$this->press('submit_project');
		$this->seePageIs('/projects/create');
		$this->see('The long description field is required.');
	}

	/**
	 * User must be logged. Test if field Language is empty, return an error
	 */
	public function testCreateProjectDisplayErrorWhenLanguageIsMissing()
	{
		$this->login();
		$this->visit('/');
		$this->visit('/talents/1/projects');
		$this->visit('/projects/create');
		$this->press('submit_project');
		$this->seePageIs('/projects/create');
		$this->see('The languages field is required.');
	}


}
?>