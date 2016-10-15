<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
      'name',
  ];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function projects()
    {
        return $this->belongsToMany('App\Project');
    }
}
