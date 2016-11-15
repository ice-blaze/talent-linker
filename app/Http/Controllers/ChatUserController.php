<?php

namespace App\Http\Controllers;

use App\ChatUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatUserController extends Controller
{
    public function index($reciever_id)
    {
        $user = User::find(Auth::user()->id);
        $reciever = User::find($reciever_id);
        $chats = $user->chats_with($reciever);

        $chats->each(function ($chat) use ($user) {
            if ($chat->reciever == $user) {
                $chat->seen = true;
                $chat->save();
            }
        });

        return view('chats.index', compact('user', 'reciever', 'chats'));
    }

    public function store(Request $request, $reciever_id)
    {
        $this->validate($request, [
            'content' => 'required',
        ]);

        $chat = new ChatUser(request()->all());
        $chat->sender()->associate(Auth::user());
        $chat->reciever()->associate(User::find($reciever_id));
        $chat->seen = false;
        $chat->save();

        return back();
    }
}
