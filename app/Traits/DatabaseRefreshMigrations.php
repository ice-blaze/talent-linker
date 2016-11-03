<?php

namespace App\Traits;

trait DatabaseRefreshMigrations
{
    /**
     * Define hooks to migrate the database before and after each test.
     *
     * @return void
     */
    public function runDatabaseRefreshMigrations()
    {
        $this->artisan('migrate:refresh');

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:refresh');
        });
    }
}
