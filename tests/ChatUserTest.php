<?php

use App\Traits\DatabaseRefreshMigrations;

class ChatUserTest extends TestCase
{
    use DatabaseRefreshMigrations;

    public function testAliceShouldChatWithBob()
    {
        $message = 'Hey sponge Bob !';
        $alice = factory(App\User::class)->create();
        $bob = factory(App\User::class)->create();
        $this->actingAs($alice);
        $this->visit($bob->path());
        $this->click('Chat with this talent');
        $this->type($message, 'content');
        $this->press('send');
        $this->seePageIs($bob->path().'/chat');
        $this->see($message);
    }

    public function testAliceShouldSeeThatBobHasSeenTheMessage()
    {
        $message = 'Hey Alice Cooper !';
        $alice = factory(App\User::class)->create();
        $bob = factory(App\User::class)->create();
        $this->actingAs($alice);
        $this->visit($bob->path().'/chat');
        $this->type($message, 'content');
        $this->press('send');
        $this->see(' unseen');

        $this->actingAs($bob);
        $this->visit($alice->path().'/chat');

        $this->actingAs($alice);
        $this->visit($bob->path().'/chat');
        $this->see(' seen'); // space is important otherwise 'seen' fit with 'seen' and 'unseen'
    }

    public function testChatUserMethodes()
    {
        $user1 = factory(App\User::class)->create();
        $user2 = factory(App\User::class)->create();
        $chat = factory(App\ChatUser::class, 'no_users')->states('seen')->make();
        $chat->sender()->associate($user1);
        $chat->reciever()->associate($user2);
        $chat->save();

        // is reciever/sender/isUserTheOwner already check ?
        // $this->assertTrue($chat->sender == $user1);
        // $this->assertTrue($chat->reciever == $user2);
        // $this->assertTrue($chat->isUserTheOwner($user1));
        // $this->assertTrue($chat->isUserTheOwner($user2));
    }
}
