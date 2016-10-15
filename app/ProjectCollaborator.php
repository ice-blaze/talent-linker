<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectCollaborator extends Model
{
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function skill()
    {
        return $this->belongsTo(GeneralSkill::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
