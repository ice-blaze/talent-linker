<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralSkill extends Model
{
    protected $fillable = [
        'name', 'count',
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
