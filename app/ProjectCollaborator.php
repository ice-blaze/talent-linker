<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;
use App\User;
use App\GeneralSkill;

class ProjectCollaborator extends Model
{
  public function project(){
    return $this->belongsTo(Project::class);
  }

  public function skill(){
    return $this->belongsTo(GeneralSkill::class);
  }

  public function user(){
    return $this->belongsTo(User::class);
  }
}
