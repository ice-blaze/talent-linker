<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
  public function run()
  {
    $skill_prog_id = 1;
    $skill_gameengine_id = 2;
    $skill_art_2d_id = 4;
    $skill_art_3d_id = 5;
    $lang_english_id = 1;
    $lang_french_id = 2;
    $lang_german_id = 2;

    $talent_description = '<p style="text-align: center;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi non quis exercitationem culpa nesciunt nihil aut nostrum explicabo reprehenderit optio amet ab temporibus asperiores quasi cupiditate. Voluptatum ducimus voluptates voluptas?</p>';

    $user = User::create([
      'name' => 'James Test',
      'email' => 'test@test.com',
      'first_name' => 'James',
      'last_name' => 'Campbell',
      'talent_description' => $talent_description,
      'github' => 'http://example.com/my_github',
      'website' => 'http://example.com/my_project',
      'stack_overflow' => 'http://example.com/stack_overflow',
      'password' => bcrypt('test'),
      'image' => 'http://www.top13.net/wp-content/uploads/2015/10/perfectly-timed-funny-cat-pictures-5.jpg',
    ]);

    DB::table('language_user')->insert([
      'language_id' => $lang_french_id,
      'user_id' => $user->id,
    ]);
    DB::table('language_user')->insert([
      'language_id' => $lang_english_id,
      'user_id' => $user->id,
    ]);
    DB::table('language_user')->insert([
      'language_id' => $lang_german_id,
      'user_id' => $user->id,
    ]);

    DB::table('general_skill_user')->insert([
      'general_skill_id' => $skill_prog_id,
      'user_id' => $user->id,
    ]);
    DB::table('general_skill_user')->insert([
      'general_skill_id' => $skill_gameengine_id,
      'user_id' => $user->id,
    ]);
    DB::table('general_skill_user')->insert([
      'general_skill_id' => $skill_art_2d_id,
      'user_id' => $user->id,
    ]);
    DB::table('general_skill_user')->insert([
      'general_skill_id' => $skill_art_3d_id,
      'user_id' => $user->id,
    ]);

    $user = User::create([
      'name' => 'Nicolas',
      'email' => 'nicolas@nicolas.com',
      'first_name' => 'Nicolas',
      'last_name' => 'Cage',
      'talent_description' => $talent_description,
      'github' => 'http://example.com/my_github',
      'website' => 'http://example.com/my_project',
      'password' => bcrypt('test'),
      'image' => 'http://static.fjcdn.com/pictures/Nicholas+cage+as+a+cat+point+made+yup_b675de_3836732.jpeg',
    ]);

    DB::table('language_user')->insert([
      'language_id' => $lang_french_id,
      'user_id' => $user->id,
    ]);
    DB::table('language_user')->insert([
      'language_id' => $lang_english_id,
      'user_id' => $user->id,
    ]);

    DB::table('general_skill_user')->insert([
      'general_skill_id' => $skill_prog_id,
      'user_id' => $user->id,
    ]);
    DB::table('general_skill_user')->insert([
      'general_skill_id' => $skill_gameengine_id,
      'user_id' => $user->id,
    ]);

    $user = User::create([
      'name' => 'Richard',
      'email' => 'richard@richard.com',
      'first_name' => 'Richard',
      'last_name' => 'Croft',
      'talent_description' => $talent_description,
      'password' => bcrypt('test'),
      'image' => 'https://s-media-cache-ak0.pinimg.com/236x/bf/f5/d0/bff5d074d399bdfec6071e9168398406.jpg',
    ]);

    DB::table('language_user')->insert([
      'language_id' => $lang_french_id,
      'user_id' => $user->id,
    ]);
  }
}
