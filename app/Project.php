<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProjectComment;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{

  protected $fillable = ['title', 'short_description', 'long_description', 'github_link', 'siteweb_link', 'languages'];

  public function comments()
  {
    return $this->hasMany(ProjectComment::class);
  }

  public function owner()
  {
    return $this->belongsTo(User::class);
  }

  public function addComment(ProjectComment $comment)
  {
    return $this->comments()->save($comment);
  }

  public function general_skills()
  {
    return $this->belongsToMany('App\GeneralSkill', 'general_skill_project')->withPivot('count');
  }

  public function general_skill_count(GeneralSkill $skill)
  {
    $skill = $this->general_skills()->find($skill->id);
    if($skill){
      return $skill->pivot->count;
    }
    return null;
  }

  public function languages()
  {
      return $this->belongsToMany('App\Language');
  }

  public function path()
  {
    return '/projects/' . $this->id;
  }

  public function belongsToCurrentAuth()
  {
    if(!Auth::user()){
      return false;
    }
    return $this->user_id == Auth::user()->id;
  }
}
