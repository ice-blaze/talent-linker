<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
  public function run()
  {

    $english_id = DB::table('languages')->insertGetId(['name' => 'English']);
    $french_id = DB::table('languages')->insertGetId(['name' => 'French']);
    DB::table('languages')->insert(['name' => 'German']);

    $user_id = DB::table('users')->insertGetId([
      'name' => 'test',
      'email' => 'test@test.com',
      'password' => bcrypt('test'),
    ]);

    DB::table('language_user')->insert([
      'language_id' => $french_id,
      'user_id' => $user_id,
    ]);
    DB::table('language_user')->insert([
      'language_id' => $english_id,
      'user_id' => $user_id,
    ]);
  }
}
