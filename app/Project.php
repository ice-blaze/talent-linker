<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProjectComment;
use App\ProjectCollaborator;
use App\User;
use Illuminate\Support\Facades\Auth;
use DB;

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

  public function collaborators()
  {
    $proj_collabs = ProjectCollaborator::all()->where('project_id', $this->id);
    $collab = array();
    foreach($proj_collabs as $proj_collab){
      array_push($collab, $proj_collab->user_id);
    }
    return User::all()->whereIn('id', $collab);
    // return $this->belongsToMany('App\ProjectCollaborator', 'project_collaborators', 'user_id', 'project_id');
  }

  public function belongsToCurrentAuth()
  {
    if(!Auth::user()){
      return false;
    }
    return $this->user_id == Auth::user()->id;
  }
}
