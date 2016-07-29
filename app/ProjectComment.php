<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectComment extends Model
{
  protected $fillable = ['content'];

  public function project(){
    return $this->belongsTo(Project::class);
  }
}
