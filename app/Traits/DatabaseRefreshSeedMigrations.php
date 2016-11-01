<?php

namespace App\Traits;

trait DatabaseRefreshSeedMigrations
{
    /**
     * Define hooks to migrate the database before and after each test.
     *
     * @return void
     */
    public function runDatabaseRefreshSeedMigrations()
    {
        $this->artisan('migrate:refresh');
        $this->artisan('db:seed');

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:refresh');
            $this->artisan('db:seed');
        });
    }
}
