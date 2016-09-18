<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
  public function run()
  {
    $prog_id = 1;
    $gameengine_id = 2;
    $art_2d_id = 4;
    $art_3d_id = 5;
    $english_id = 1;
    $french_id = 2;

    $user_test = User::create([
      'name' => 'James Test',
      'email' => 'test@test.com',
      'password' => bcrypt('test'),
      'image' => 'http://www.top13.net/wp-content/uploads/2015/10/perfectly-timed-funny-cat-pictures-5.jpg',
    ]);

    DB::table('language_user')->insert([
      'language_id' => $french_id,
      'user_id' => $user_test->id,
    ]);
    DB::table('language_user')->insert([
      'language_id' => $english_id,
      'user_id' => $user_test->id,
    ]);

    $user_james = User::create([
      'name' => 'Nicolas',
      'email' => 'nicolas@nicolas.com',
      'password' => bcrypt('test'),
      'image' => 'http://static.fjcdn.com/pictures/Nicholas+cage+as+a+cat+point+made+yup_b675de_3836732.jpeg',
    ]);

    DB::table('general_skill_user')->insert([
      'general_skill_id' => $prog_id,
      'user_id' => $user_james->id,
    ]);
    DB::table('general_skill_user')->insert([
      'general_skill_id' => $gameengine_id,
      'user_id' => $user_james->id,
    ]);

    $user_richard_id = User::create([
      'name' => 'Richard',
      'email' => 'richard@richard.com',
      'password' => bcrypt('test'),
      'image' => 'https://s-media-cache-ak0.pinimg.com/236x/bf/f5/d0/bff5d074d399bdfec6071e9168398406.jpg',
    ]);

    DB::table('general_skill_user')->insert([
      'general_skill_id' => $art_2d_id,
      'user_id' => $user_richard_id,
    ]);
    DB::table('general_skill_user')->insert([
      'general_skill_id' => $art_3d_id,
      'user_id' => $user_richard_id,
    ]);
  }
}
