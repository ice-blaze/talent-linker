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

  protected $fillable = [
    'title', 'short_description', 'long_description', 'github_link', 'siteweb_link', 'languages', 'skills', 'github_link',
    'stack_overflow_link', 'image',
  ];

  public  function scopeLike($query, $field, $value){
    return $query->where($field, 'LIKE', "%$value%");
  }

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
    return $this->hasOne('App\ProjectCollaborator')->where('is_project_owner', '=', true);
  }

  public function addComment(ProjectComment $comment)
  {
    return $this->comments()->save($comment);
  }

  public function current_skills()
  {
    return $this->belongsToMany('App\GeneralSkill', 'project_collaborators', 'project_id','skill_id');
  }

  public function general_skills()
  {
    return $this->belongsToMany('App\GeneralSkill', 'general_skill_project')->withPivot('count');
  }

  public function current_skill_and_wanted(){
    $wanted = $this->skill_have();
    foreach($this->general_skills as $skill){
      $wanted[$skill->id]['skill'] = $skill;
      $wanted[$skill->id]['wanted'] = $skill->pivot->count;
    }

    foreach($wanted as $skill){
      if(! array_key_exists('have', $wanted[$skill['skill']->id])){
        $wanted[$skill['skill']->id]['have'] = 0;
      }
      if(! array_key_exists('wanted', $wanted[$skill['skill']->id])){
        $wanted[$skill['skill']->id]['wanted'] = 0;
      }
    }
    return $wanted;
  }

  public function skill_have(){
    $res = array();
    foreach($this->current_skills->groupBy('id') as $value ){
      $res[$value[0]->id] = ['skill' => $value[0], 'have' => count($value)];
    }
    return $res;
    // dd($this->collaborators->first()->skill_id);
    // $skill_extractor = function ($x) {
    //   return [
    //     'id' => $x->id,
    //     'name' => $x->name,
    //     'current_count' => $this->general_skill_count($x),
    //     'count' => $this->general_skill_count($x),
    //   ];
    // };
    // $skills = array_map($skill_extractor, $this->general_skills->all());
    // dd($skills);
    // return $skills;
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

  public function all_collaborators(){
    return $this->hasMany('App\ProjectCollaborator');
  }

  public function collaborators(){
    return $this->all_collaborators()->where('accepted', '=', true);
  }

  public function isPendingUser(User $user){
    return $this->pending_collaborators->contains('user.id', $user->id);
  }

  public function pending_collaborators()
  {
    return $this->all_collaborators()->where('accepted', '=', false);
  }

  public function isUserTheOwner(User $user)
  {
    return $this->owner->user->id == $user->id;
  }

  public function isUserACollaborator(User $user)
  {
    return $this->all_collaborators->contains('user.id', '=', $user->id);
  }
}
