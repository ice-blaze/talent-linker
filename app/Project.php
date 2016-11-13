<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
    'name', 'short_description', 'long_description', 'github_link', 'website_link',
    'languages', 'skills', 'github_link', 'image',
    ];

    public function scopeLike($query, $field, $value)
    {
        return $query->where($field, 'LIKE', "%$value%");
    }

    public function comments()
    {
        return $this->hasMany(ProjectComment::class)->where('private', '=', false);
    }

    public function privateComments()
    {
        return $this->hasMany(ProjectComment::class)->where('private', '=', true);
    }

    public function owner()
    {
        return $this->hasOne('App\ProjectCollaborator')->where('is_project_owner', '=', true);
    }

    public function addComment(ProjectComment $comment)
    {
        return $this->comments()->save($comment);
    }

    public function currentSkills()
    {
        return $this->belongsToMany('App\GeneralSkill', 'project_collaborators', 'project_id', 'skill_id');
    }

    public function generalSkills()
    {
        return $this->belongsToMany('App\GeneralSkill', 'general_skill_project')->withPivot('count')->withTimestamps();
    }

  // TODO same function in user, maybe could generalize the code
    public function isInSearchDistance(User $user)
    {
        $lat1 = $this->owner->user->lat;
        $lng1 = $this->owner->user->lng;
        $lat2 = $user->lat;
        $lng2 = $user->lng;
        $p = 0.017453292519943295;    // Math.PI / 180
        $a = 0.5 - cos(($lat2 - $lat1) * $p) / 2.0 +
        cos($lat1 * $p) * cos($lat2 * $p) *
        (1.0 - cos(($lng2 - $lng1) * $p)) / 2.0;
        $result = 12742.0 * asin(sqrt($a)); // 2 * R; R = 6371 km

        return $result < $user->find_distance;
    }

    public function currentSkillAndWanted()
    {
        $wanted = $this->getCollaboratorsSkill();
        foreach ($this->generalSkills as $skill) {
            $wanted[$skill->id]['skill'] = $skill;
            $wanted[$skill->id]['wanted'] = $skill->pivot->count;
        }

        foreach ($wanted as $skill) {
            if (! array_key_exists('have', $wanted[$skill['skill']->id])) {
                $wanted[$skill['skill']->id]['have'] = 0;
            }
            if (! array_key_exists('wanted', $wanted[$skill['skill']->id])) {
                $wanted[$skill['skill']->id]['wanted'] = 0;
            }
        }

        return $wanted;
    }

    public function getCollaboratorsSkill()
    {
        $res = [];
        foreach ($this->currentSkills->groupBy('id') as $value) {
            $res[$value[0]->id] = ['skill' => $value[0], 'have' => count($value)];
        }

        return $res;
    // dd($this->collaborators->first()->skill_id);
    // $skill_extractor = function ($x) {
    //   return [
    //     'id' => $x->id,
    //     'name' => $x->name,
    //     'current_count' => $this->generalSkillCount($x),
    //     'count' => $this->generalSkillCount($x),
    //   ];
    // };
    // $skills = array_map($skill_extractor, $this->general_skills->all());
    // dd($skills);
    // return $skills;
    }

    public function generalSkillCount(GeneralSkill $skill)
    {
        $skill = $this->generalSkills()->find($skill->id);
        if ($skill) {
            return $skill->pivot->count;
        }
    }

    public function languages()
    {
        return $this->belongsToMany('App\Language')->withTimestamps();
    }

    public function path()
    {
        return '/projects/'.$this->id;
    }

    public function allCollaborators()
    {
        return $this->hasMany('App\ProjectCollaborator');
    }

    public function collaborators()
    {
        return $this->allCollaborators()->where('accepted', '=', true);
    }

    public function isPendingUser(User $user)
    {
        return $this->pendingCollaborators->contains('user.id', $user->id);
    }

    public function pendingCollaborators()
    {
        return $this->allCollaborators()->where('accepted', '=', false);
    }

    public function isUserTheOwner(User $user)
    {
        return $this->owner->user->id == $user->id;
    }

    public function isUserACollaborator(User $user)
    {
        return $this->allCollaborators->contains('user.id', '=', $user->id);
    }
}
