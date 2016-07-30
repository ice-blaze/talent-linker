<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Language;
use App\Form;
use App\Http\Requests;

class UserController extends Controller
{
    public function index()
    {
      $users = User::all();
      return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
      $languages = Language::all();
      return view('users.show', compact('user', 'languages'));
    }

    public function edit(User $user)
    {
      $languages = Language::all();
      return view('users.edit', compact('user', 'languages'));
    }

    public function update(User $user)
    {
      $user->update(request()->all());

      // managed the langauges
      // TODO certainly another way to do that
      $user->languages()->detach();
      $languages = Language::find(request()->languages);
      if($languages){
        foreach($languages as $language){
          $user->languages()->save($language);
        }
      }
      
      return view('users.show', compact('user'));
    }
}
