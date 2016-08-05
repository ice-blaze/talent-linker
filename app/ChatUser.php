<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatUser extends Model
{
  protected $fillable = ['content'];

  public function belongsToCurrentAuth()
  {
    return ($this->reciever_id == Auth::user()->id) || ($this->sender_id == Auth::user()->id);
  }
}
