<?php

namespace App\Http\Controllers;

use App\User;
use App\ChatUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ChatUserController extends Controller
{
    public function index($reciever_id)
    {
        $user = User::find(Auth::user()->id);
        $reciever = User::find($reciever_id);
        $chats = $user->chatsWith($reciever);

        $chats->each(function ($chat) use ($user) {
            if ($chat->reciever == $user) {
                $chat->seen = true;
                $chat->save();
            }
        });

        return view('chats.index', compact('user', 'reciever', 'chats'));
    }

    public function inbox()
    {
        $user = User::find(Auth::user()->id);
        $id = $user->id;

        $chats = ChatUser::getOrderedChat($id)->get();

        $ids = [];

        foreach ($chats as $c) {
            if (! in_array($c->sender_id, $ids)) {
                array_push($ids, $c->sender_id);
            }

            if (! in_array($c->reciever_id, $ids)) {
                array_push($ids, $c->reciever_id);
            }
        }

        $ids = array_diff($ids, [$user->id]);

        return view('chats.inbox', compact('user', 'ids'));
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

    public function edit(ChatUser $chat)
    {
        if (Auth::User()->id != $chat->sender_id) {
            return redirect('/')->withErrors('You\'re not authorized to access this page!');
        }

        return view('layouts.edit_text')->with([
            'item' => $chat,
            'route' => 'chat',
            'object' => 'comment',
            'routeToDelete' => '/chat/'.$chat->id.'/delete',
        ]);
    }

    public function update(Request $request, ChatUser $chat)
    {
        $this->validate($request, [
            'content' => 'required',
        ]);

        $chat->update([
            'content' => $request->content,
        ]);

        return redirect('talents/'.$chat->reciever_id.'/chat');
    }

    public function deleteMessage(ChatUser $chat)
    {
        $chat->delete();

        return redirect('talents/'.$chat->reciever_id.'/chat');
    }

    public function delete(Request $request, $id)
    {
        $chats = ChatUser::getOrderedChat($id)->delete();

        return redirect('chat/inbox/');
    }
}
