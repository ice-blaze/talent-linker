<?php

use App\User;
use App\ChatUser;
use Illuminate\Database\Seeder;

class ChatUsersTableSeeder extends Seeder
{
    public function run()
    {
        $james = User::find(1);
        $nicolas = User::find(2);

        ChatUser::create([
            'content'     => 'Hello my friend nic :)',
            'reciever_id' => $nicolas->id,
            'sender_id' => $james->id,
            'seen' => true,
        ]);

        ChatUser::create([
            'content'     => 'Hi!',
            'reciever_id' => $james->id,
            'sender_id' => $nicolas->id,
            'seen' => false,
        ]);

        ChatUser::create([
            'content'     => 'How are you ?',
            'reciever_id' => $nicolas->id,
            'sender_id' => $james->id,
            'seen' => false,
        ]);
    }
}
