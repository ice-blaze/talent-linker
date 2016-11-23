<?php

use App\Traits\DatabaseTransactionWorking;

class ChatUserTest extends TestCase
{
    use DatabaseTransactionWorking;

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
        $this->see(' seen'); // space is important otherwise 'seen' fit with 'seen' and 'unseen'

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
    }

    public function testChatCreateAndEditAMessage()
    {
        $message = 'Hey sponge Bob !';
        $messageEdited = $message.' Edited';
        $alice = factory(App\User::class)->create();
        $bob = factory(App\User::class)->create();
        $this->actingAs($alice);
        $this->visit($bob->path());
        $this->click('Chat with this talent');
        $this->type($message, 'content');
        $this->press('send');
        $this->seePageIs($bob->path().'/chat');
        $this->see($message);

        $this->click('Edit');
        $this->type($messageEdited, 'content');
        $this->press('update_comment');
        $this->seePageIs($bob->path().'/chat');
        $this->see($messageEdited);
    }

    public function testChatCreateAndDeleteAMessage()
    {
        $message = 'Hey pirate Bob !';
        $alice = factory(App\User::class)->create();
        $bob = factory(App\User::class)->create();
        $this->actingAs($alice);
        $this->visit($bob->path());
        $this->click('Chat with this talent');
        $this->type($message, 'content');
        $this->press('send');
        $this->seePageIs($bob->path().'/chat');
        $this->see($message);

        $this->click('Edit');
        $this->press('delete_comment');
        $this->visit($bob->path().'/chat');
        $this->dontSee($message);
    }

    public function testChatWrongPageAccess()
    {
        $message = 'Hey pirate Bob !';
        $alice = factory(App\User::class)->create();
        $bob = factory(App\User::class)->create();
        $this->actingAs($alice);
        $this->visit($bob->path());
        $this->click('Chat with this talent');
        $this->type($message, 'content');
        $this->press('send');
        $this->seePageIs($bob->path().'/chat');
        $this->see($message);

        $chat_message = App\ChatUser::orderBy('id', 'desc')->first();

        $robert = factory(App\User::class)->create();
        $this->actingAs($robert);
        $this->visit('/chat/'.$chat_message->id.'/edit');
        $this->see("You're not authorized to access this page!");
    }
}
