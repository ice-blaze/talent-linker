<?php

use Illuminate\Database\Seeder;
use App\Language;

class LanguagesTableSeeder extends Seeder
{
    public function run()
    {
        Language::create(['name' => 'English']);
        Language::create(['name' => 'French']);
        Language::create(['name' => 'German']);
    }
}
