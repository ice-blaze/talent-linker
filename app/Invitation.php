<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
  protected $attributes = ['accepted' => false];

  public function project(){
    return $this->belongsTo(Project::class, 'project_id');
  }

  public function guest(){
    return $this->belongsTo(User::class, 'guest_id');
  }
}
