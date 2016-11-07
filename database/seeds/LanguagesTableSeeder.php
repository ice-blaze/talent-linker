<?php

use App\Language;
use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    public function run()
    {
        Language::create(['name' => 'English']);
        Language::create(['name' => 'French']);
        Language::create(['name' => 'German']);
    }
}
