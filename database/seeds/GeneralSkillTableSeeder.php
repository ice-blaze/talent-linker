<?php

use Illuminate\Database\Seeder;

class GeneralSkillTableSeeder extends Seeder
{
  public function run()
  {
    $prog_id = DB::table('general_skills')->insertGetId(['name' => 'Programming', 'technical_name' => 'programming']);
    $gameengine_id = DB::table('general_skills')->insertGetId(['name' => 'Game Engine', 'technical_name' => 'game_engine']);
    DB::table('general_skills')->insertGetId(['name' => 'Web', 'technical_name' => 'web']);
    DB::table('general_skills')->insertGetId(['name' => 'Art 2D', 'technical_name' => 'art_2d']);
    DB::table('general_skills')->insertGetId(['name' => 'Art 3D', 'technical_name' => 'art_3d']);
    DB::table('general_skills')->insertGetId(['name' => 'Music', 'technical_name' => 'music']);
    DB::table('general_skills')->insertGetId(['name' => 'Marketing', 'technical_name' => 'marketing']);

    $user_id = DB::table('users')->insertGetId([
      'name' => 'skill_test',
      'email' => 'skill_test@test.com',
      'password' => bcrypt('test'),
    ]);

    DB::table('general_skill_user')->insert([
      'general_skill_id' => $prog_id,
      'user_id' => $user_id,
    ]);
    DB::table('general_skill_user')->insert([
      'general_skill_id' => $gameengine_id,
      'user_id' => $user_id,
    ]);

    $project_id = DB::table('projects')->insertGetId([
      'title' => 'skill_test_project',
    ]);

    DB::table('general_skill_project')->insert([
      'general_skill_id' => $gameengine_id,
      'project_id' => $project_id,
      'count' => 1,
    ]);

    DB::table('general_skill_project')->insert([
      'general_skill_id' => $prog_id,
      'project_id' => $project_id,
      'count' => 3,
    ]);
  }
}
