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
    return $this->hasMany(ProjectComment::class)->where('private', '=',  false);
  }

  public function private_comments()
  {
    return $this->hasMany(ProjectComment::class)->where('private', '=',  true);
  }

  public function owner()
  {
    return $this->belongsTo(User::class, 'user_id');
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

  private function collab(){
    return $this->belongsToMany('App\User', 'project_collaborators', 'project_id', 'user_id');
  }

  public function collaborators()
  {
    // $proj_collabs = ProjectCollaborator::all()->where('project_id', $this->id);
    // $collab = array();
    // foreach($proj_collabs as $proj_collab){
    //   array_push($collab, $proj_collab->user_id);
    // }
    // return User::all()->whereIn('id', $collab);
    return $this->collab()->where('accepted', '=', true);
  }

  public function isCurrentAuthTheOwner()
  {
    if(!Auth::user()){
      return false;
    }
    return $this->user_id == Auth::user()->id;
  }

  public function isCurrentAuthACollaborator()
  {
    if(!Auth::user()){
      return false;
    }
    $collaborators = $this->belongsToMany('App\User', 'project_collaborators', 'project_id', 'user_id');
    return count($collaborators->where('user_id', '=', Auth::user()->id)->get());
  }
}
