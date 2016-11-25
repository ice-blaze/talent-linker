<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public static function lastCommunicationDate($id_1, $id_2)
    {
        return self::where(function ($query) use ($id_1, $id_2) {
            return $query->where('reciever_id', '=', $id_1)
                ->where('sender_id', '=', $id_2);
        }
        )->orWhere(function ($query) use ($id_1, $id_2) {
            return $query->where('reciever_id', '=', $id_2)
                ->where('sender_id', '=', $id_1);
        }
        )->orderBy('created_at', 'desc')
            ->first()->updated_at;
    }

    public static function hasPendingMessage($user_id)
    {
        if (self::where('reciever_id', '=', Auth::user()->id)->where('sender_id', '=', $user_id)->count()) {
            if (self::where('reciever_id', '=', Auth::user()->id)
                    ->where('sender_id', '=', $user_id)
                    ->orderBy('created_at', 'desc')->first()
                    ->seen == 0
            ) {
                return true;
            }
        }

        return false;
    }

    public function isEditable($id)
    {
        return $id == Auth::User()->id;
    }

    public static function getOrderedChat($id)
    {
        return self::where(function ($query) use ($id) {
            return $query->where('reciever_id', '=', $id)
                ->orWhere('sender_id', '=', $id);
        }
        )->where(function ($query) use ($id) {
            return $query->where('sender_id', '=', $id)
                ->orWhere('reciever_id', '=', $id);
        }
        )->orderBy('created_at', 'desc');
    }
}
