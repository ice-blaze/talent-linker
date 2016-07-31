<?php

use Illuminate\Database\Seeder;

class GeneralSkillTableSeeder extends Seeder
{
  public function run()
  {
    $prog_id = DB::table('general_skills')->insertGetId(['name' => 'Programming']);
    $gameengine_id = DB::table('general_skills')->insertGetId(['name' => 'Game Engine']);
    DB::table('general_skills')->insertGetId(['name' => 'Web']);
    DB::table('general_skills')->insertGetId(['name' => 'Art 2D']);
    DB::table('general_skills')->insertGetId(['name' => 'Art 3D']);
    DB::table('general_skills')->insertGetId(['name' => 'Music']);
    DB::table('general_skills')->insertGetId(['name' => 'Marketing']);

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
