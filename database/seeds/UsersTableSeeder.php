<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $skill_prog_id = 1;
        $skill_gameengine_id = 2;
        $skill_web_id = 3;
        $skill_art_2d_id = 4;
        $skill_art_3d_id = 5;
        $skill_music_id = 6;
        $skill_marketing_id = 7;
        $lang_english_id = 1;
        $lang_french_id = 2;
        $lang_german_id = 3;
        $pos_neuchatel = ['lat' => 46.991363, 'lng' => 6.929970];
        $pos_paris = ['lat' => 48.802793, 'lng' => 2.427979];
        $pos_lausanne = ['lat' => 46.534067, 'lng' => 6.619263];
        $pos_berne = ['lat' => 46.918145, 'lng' => 7.443237];
        $pos_geneve = ['lat' => 46.192903, 'lng' => 6.157837];

        $talent_description = '<p style="text-align: center;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi non quis exercitationem culpa nesciunt nihil aut nostrum explicabo reprehenderit optio amet ab temporibus asperiores quasi cupiditate. Voluptatum ducimus voluptates voluptas?</p>';

        $user = User::create([
            'name' => 'James Test',
            'email' => 'test@test.com',
            'first_name' => 'James',
            'last_name' => 'Campbell',
            'talent_description' => $talent_description,
            'github_link' => 'http://example.com/my_github',
            'website' => 'http://example.com/my_project',
            'stack_overflow' => 'http://example.com/stack_overflow',
            'password' => bcrypt('test'),
            'image' => 'http://www.top13.net/wp-content/uploads/2015/10/perfectly-timed-funny-cat-pictures-5.jpg',
            'lat' => $pos_neuchatel['lat'],
            'lng' => $pos_neuchatel['lng'],
            'find_distance' => 20,
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
            'github_link' => 'http://example.com/my_github',
            'website' => 'http://example.com/my_project',
            'password' => bcrypt('test'),
            'image' => 'http://static.fjcdn.com/pictures/Nicholas+cage+as+a+cat+point+made+yup_b675de_3836732.jpeg',
            'lat' => $pos_lausanne['lat'],
            'lng' => $pos_lausanne['lng'],
            'find_distance' => 10,
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
            'lat' => $pos_paris['lat'],
            'lng' => $pos_paris['lng'],
            'find_distance' => 30,
        ]);

        DB::table('general_skill_user')->insert([
            'general_skill_id' => $skill_prog_id,
            'user_id' => $user->id,
        ]);

        DB::table('language_user')->insert([
            'language_id' => $lang_french_id,
            'user_id' => $user->id,
        ]);

        $user = User::create([
            'name' => 'Larry',
            'email' => 'larry@larry.com',
            'first_name' => 'Larry',
            'last_name' => 'Jensen',
            'talent_description' => $talent_description,
            'password' => bcrypt('test'),
            'github_link' => 'http://example.com/my_github',
            'website' => 'http://example.com/my_project',
            'stack_overflow' => 'http://example.com/stack_overflow',
            'image' => 'http://i.imgur.com/Tjkm1C0.jpg',
            'lat' => $pos_paris['lat'],
            'lng' => $pos_paris['lng'],
            'find_distance' => 50,
        ]);

        DB::table('general_skill_user')->insert([
            'general_skill_id' => $skill_prog_id,
            'user_id' => $user->id,
        ]);

        DB::table('language_user')->insert([
            'language_id' => $lang_french_id,
            'user_id' => $user->id,
        ]);

        $user = User::create([
            'name' => 'Franz',
            'email' => 'franz@franz.com',
            'first_name' => 'Franz',
            'last_name' => 'Goldstein',
            'talent_description' => $talent_description,
            'password' => bcrypt('test'),
            'github_link' => 'http://example.com/my_github',
            'website' => 'http://example.com/my_project',
            'stack_overflow' => 'http://example.com/stack_overflow',
            'image' => 'http://i.imgur.com/Pdfl0cO.png',
            'lat' => $pos_neuchatel['lat'],
            'lng' => $pos_neuchatel['lng'],
            'find_distance' => 5,
        ]);

        DB::table('general_skill_user')->insert([
            'general_skill_id' => $skill_web_id,
            'user_id' => $user->id,
        ]);

        DB::table('language_user')->insert([
            'language_id' => $lang_english_id,
            'user_id' => $user->id,
        ]);

        $user = User::create([
            'name' => 'Logan',
            'email' => 'logan@logan.com',
            'first_name' => 'Logan',
            'last_name' => 'Schmutz',
            'talent_description' => $talent_description,
            'password' => bcrypt('test'),
            'github_link' => 'http://example.com/my_github',
            'website' => 'http://example.com/my_project',
            'stack_overflow' => 'http://example.com/stack_overflow',
            'image' => 'http://i.imgur.com/dyBJMyY.jpg',
            'lat' => $pos_berne['lat'],
            'lng' => $pos_berne['lng'],
            'find_distance' => 20,
        ]);

        DB::table('general_skill_user')->insert([
            'general_skill_id' => $skill_art_2d_id,
            'user_id' => $user->id,
        ]);

        DB::table('language_user')->insert([
            'language_id' => $lang_german_id,
            'user_id' => $user->id,
        ]);

        $user = User::create([
            'name' => 'Steve',
            'email' => 'steve@steve.com',
            'first_name' => 'Steve',
            'last_name' => 'Vai',
            'talent_description' => $talent_description,
            'password' => bcrypt('test'),
            'github_link' => 'http://example.com/my_github',
            'website' => 'http://example.com/my_project',
            'stack_overflow' => 'http://example.com/stack_overflow',
            'image' => 'http://i.imgur.com/IPtPvxU.jpg?1',
            'lat' => $pos_neuchatel['lat'],
            'lng' => $pos_neuchatel['lng'],
            'find_distance' => 20,
        ]);

        DB::table('general_skill_user')->insert([
            'general_skill_id' => $skill_art_3d_id,
            'user_id' => $user->id,
        ]);

        DB::table('language_user')->insert([
            'language_id' => $lang_french_id,
            'user_id' => $user->id,
        ]);
        DB::table('language_user')->insert([
            'language_id' => $lang_german_id,
            'user_id' => $user->id,
        ]);

        $user = User::create([
            'name' => 'Bill',
            'email' => 'bill@bill.com',
            'first_name' => 'Bill',
            'last_name' => 'Hathaway',
            'talent_description' => $talent_description,
            'password' => bcrypt('test'),
            'github_link' => 'http://example.com/my_github',
            'website' => 'http://example.com/my_project',
            'stack_overflow' => 'http://example.com/stack_overflow',
            'image' => 'http://i.imgur.com/eFhCMYv.jpg',
            'lat' => $pos_neuchatel['lat'],
            'lng' => $pos_neuchatel['lng'],
            'find_distance' => 20,
        ]);

        DB::table('general_skill_user')->insert([
            'general_skill_id' => $skill_music_id,
            'user_id' => $user->id,
        ]);

        DB::table('language_user')->insert([
            'language_id' => $lang_french_id,
            'user_id' => $user->id,
        ]);

        $user = User::create([
            'name' => 'Mike',
            'email' => 'mike@mike.com',
            'first_name' => 'Mike',
            'last_name' => '',
            'talent_description' => $talent_description,
            'password' => bcrypt('test'),
            'github_link' => 'http://example.com/my_github',
            'website' => 'http://example.com/my_project',
            'stack_overflow' => 'http://example.com/stack_overflow',
            'image' => 'http://i.imgur.com/wDSw3m5.jpg',
            'lat' => $pos_neuchatel['lat'],
            'lng' => $pos_neuchatel['lng'],
            'find_distance' => 20,
        ]);

        DB::table('general_skill_user')->insert([
            'general_skill_id' => $skill_marketing_id,
            'user_id' => $user->id,
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
    }
}
