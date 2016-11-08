<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProjectComment extends Model
{
    protected $fillable = ['content'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isCurrentAuthTheOwner()
    {
        if (! Auth::user()) {
            return false;
        }

        return $this->user_id == Auth::user()->id;
    }
}
