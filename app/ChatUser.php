<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatUser extends Model
{
    protected $fillable = ['content'];

    public function isUserTheOwner(User $user)
    {
        return ($this->reciever_id == $user->id) || ($this->sender_id == $user->id);
    }
}
