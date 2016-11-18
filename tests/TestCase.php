<?php

use App\Traits\DatabaseRefreshMigrations;
use App\Traits\DatabaseRefreshSeedMigrations;
use App\Traits\DatabaseTransactionWorking;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function truncateDatabase()
    {
        // $this->artisan('migrate:refresh'); // learning purpose: second way to do the same call
        Artisan::call('migrate:refresh');
    }

    public function seedDatabase()
    {
        Artisan::call('db:seed');
    }

    // Override this function to add new traits for the testing phase
    protected function setUpTraits()
    {
        $uses = array_flip(class_uses_recursive(static::class));

        // Traits who migrate with a refresh + seed before and after tests
        if (isset($uses[DatabaseRefreshSeedMigrations::class])) {
            $this->runDatabaseRefreshSeedMigrations();
        }

        // Traits who migrate with a refresh before and after tests
        if (isset($uses[DatabaseRefreshMigrations::class])) {
            $this->runDatabaseRefreshMigrations();
        }

        if (isset($uses[DatabaseTransactionWorking::class])) {
            $this->runDatabaseTransactionWorking();
        }

        if (isset($uses[DatabaseMigrations::class])) {
            $this->runDatabaseMigrations();
        }

        if (isset($uses[DatabaseTransactions::class])) {
            $this->beginDatabaseTransaction();
        }

        if (isset($uses[WithoutMiddleware::class])) {
            $this->disableMiddlewareForAllTests();
        }

        if (isset($uses[WithoutEvents::class])) {
            $this->disableEventsForAllTests();
        }
    }
}
