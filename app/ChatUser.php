<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatUser extends Model
{
    protected $fillable = ['content'];

    public function reciever()
    {
        return $this->belongsTo(User::class, 'reciever_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function isUserTheOwner(User $user)
    {
        return ($this->reciever_id == $user->id) || ($this->sender_id == $user->id);
    }
}
