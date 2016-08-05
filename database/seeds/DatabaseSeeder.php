<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  public function run()
  {
    $this->call(UsersTableSeeder::class);
    $this->call(GeneralSkillTableSeeder::class);
    $this->call(CollaboratorTableSeeder::class); // can-t  be executed without the to above seeder
  }
}
