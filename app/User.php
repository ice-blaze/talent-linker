<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $casts = [
        'is_admin' => 'boolean',
    ];

    protected $fillable = [
        'name', 'email', 'password', 'last_name', 'first_name',
        'talent_description', 'website', 'github_link', 'stack_overflow',
        'image', 'lat', 'lng', 'find_distance',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function is_in_search_distance(User $user)
    {
        $lat1 = $this->lat;
        $lng1 = $this->lng;
        $lat2 = $user->lat;
        $lng2 = $user->lng;
        $p = 0.017453292519943295;    // Math.PI / 180
        $a = 0.5 - cos(($lat2 - $lat1) * $p) / 2.0 +
            cos($lat1 * $p) * cos($lat2 * $p) *
            (1.0 - cos(($lng2 - $lng1) * $p)) / 2.0;
        $result = 12742.0 * asin(sqrt($a)); // 2 * R; R = 6371 km

        return $result < $user->find_distance;
        // return false;
    }

    public function scopeLike($query, $field, $value)
    {
        return $query->where($field, 'LIKE', "%$value%");
    }

    public function feedbacks()
    {
        return $this->hasMany('App\Feedback');
    }

    public function languages()
    {
        return $this->belongsToMany('App\Language');
    }

    public function general_skills()
    {
        return $this->belongsToMany('App\GeneralSkill');
    }

    public function path()
    {
        return '/talents/'.$this->id;
    }

    public function projects()
    {
        return $this->belongsToMany('App\Project', 'project_collaborators', 'user_id', 'project_id')
                    ->where('is_project_owner', '=', true);
    }

    public function projectsAsCollaborator()
    {
        return $this->belongsToMany('App\Project', 'project_collaborators', 'user_id', 'project_id');
    }

    public function collaborations()
    {
        return $this->hasMany('App\ProjectCollaborator')->where('accepted', '=', true);
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function chats_with($another_user)
    {
        return ChatUser::all()->whereIn('sender_id', [$another_user->id, $this->id])
                            ->whereIn('reciever_id', [$another_user->id, $this->id]);
    }

    public function isCurrentAuth()
    {
        if (!Auth::user()) {
            return false;
        }

        return $this->id == Auth::user()->id;
    }
}
