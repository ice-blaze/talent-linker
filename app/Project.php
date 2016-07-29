<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProjectComment;

class Project extends Model
{

  protected $fillable = ['title', 'short_description', 'long_description', 'github_link', 'siteweb_link'];

  public function comments()
  {
    return $this->hasMany(ProjectComment::class);
  }

  public function addComment(ProjectComment $comment)
  {
    return $this->comments()->save($comment);
  }

  public function path()
  {
    return '/projects/' . $this->id;
  }
}
