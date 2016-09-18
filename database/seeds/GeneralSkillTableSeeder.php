<?php

use Illuminate\Database\Seeder;
use App\GeneralSkill;

class GeneralSkillTableSeeder extends Seeder
{
  public function run()
  {
    GeneralSkill::create(['name' => 'Programming','technical_name' => 'programming']);
    GeneralSkill::create(['name' => 'Game Engine', 'technical_name' => 'game_engine']);
    GeneralSkill::create(['name' => 'Web', 'technical_name' => 'web']);
    GeneralSkill::create(['name' => 'Art 2D', 'technical_name' => 'art_2d']);
    GeneralSkill::create(['name' => 'Art 3D', 'technical_name' => 'art_3d']);
    GeneralSkill::create(['name' => 'Music', 'technical_name' => 'music']);
    GeneralSkill::create(['name' => 'Marketing', 'technical_name' => 'marketing']);
  }
}
