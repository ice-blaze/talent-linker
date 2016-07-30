<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'last_name', 'first_name',
        'talent_description', 'website', 'github', 'stack_overflow',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function languages()
    {
        return $this->belongsToMany('App\Language');
    }

    public function path()
    {
      return '/talents/' . $this->id;
    }
}
