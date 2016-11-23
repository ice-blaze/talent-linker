<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // WARNING THOSE SEEDS NEED TO BE DONE ON AN EMPTY BASE
        $this->call(GeneralSkillTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
        $this->call(CollaboratorTableSeeder::class);
        $this->call(ChatUsersTableSeeder::class);
        $this->call(ProjectCommentsTableSeeder::class);
    }
}
