<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\ChatUser;
use Illuminate\Support\Facades\Auth;

class ChatUserController extends Controller
{
    //tried with the casting into the User class but didn't work
  public function index($reciever_id)
  {
      $user = User::find(Auth::user()->id);
      $reciever = User::find($reciever_id);
      $chats = $user->chats_with($reciever);

      return view('chats.index', compact('user', 'reciever', 'chats'));
  }

    public function store(Request $request, $reciever_id)
    {
        $this->validate($request, [
            'content' => 'required',
        ]);

        $chat = new ChatUser(request()->all());
        $chat->sender_id = Auth::user()->id;
        $chat->reciever_id = $reciever_id;
        $chat->seen = false;
        $chat->save();

        return back();
    }
}
