<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\ChatUser;

class User extends Authenticatable
{
  protected $casts = [
    'is_admin' => 'boolean',
  ];

  protected $fillable = [
    'name', 'email', 'password', 'last_name', 'first_name',
    'talent_description', 'website', 'github', 'stack_overflow',
  ];

  protected $hidden = [
      'password', 'remember_token',
  ];

  public function feedbacks()
  {
      return $this->hasMany('App\Feedback');
  }

  public function languages()
  {
      return $this->belongsToMany('App\Language');
  }

  public function general_skills()
  {
    return $this->belongsToMany('App\GeneralSkill');
  }

  public function path()
  {
    return '/talents/' . $this->id;
  }

  public function projectsAsCollaborator(){
    return $this->belongsToMany('App\Project', 'project_collaborators', 'user_id', 'project_id');
  }

  public function isAdmin()
  {
    return $this->is_admin;
  }

  public function chats_with($another_user){
    return ChatUser::all()->whereIn('sender_id', [$another_user->id, $this->id]
      )->whereIn('reciever_id', [$another_user->id, $this->id]);
  }

  public function isCurrentAuth()
  {
    if(!Auth::user()){
      return false;
    }
    return $this->id == Auth::user()->id;
  }
}
