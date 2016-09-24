<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Language;
use App\GeneralSkill;
use App\Form;
use App\Http\Requests;

class UserController extends Controller
{
  public function index(Request $request)
  {
    $request->flash(); // to have the old functionality (don't understand why it's necessary here)

    $users = User::all();
    if($request->search){
      $users = User::like('name', $request->search)->get();
    } else {
      $users = User::all();
    }

    $general_skills = GeneralSkill::all();

    // maybe could be better
    if($request->skills){
      foreach ($request->skills as $skill_tech_name => $skill_id) {
        foreach ($users as $user_key => $user) {
          if( !$user->general_skills->contains($skill_id) ) {
            unset($users[$user_key]);
          }
        }
      }
    }

    return view('users.index', compact('users', 'general_skills'));
  }

  public function show(User $user)
  {
    return view('users.show', compact('user'));
  }

  public function edit(User $user)
  {
    $languages = Language::all();
    $general_skills = GeneralSkill::all();
    return view('users.edit', compact('user', 'languages', 'general_skills'));
  }

  public function update(Request $request, User $user)
  {
    $this->validate($request, [
      //TODO HAVE AT LEAST ONE LANGUAGE
    ]);


    $user->update(request()->all());

    // managed the langauges
    $user->languages()->sync((array)request()->languages);

    $user->general_skills()->detach();
    $general_skills = GeneralSkill::find(request()->general_skills);
    if($general_skills){
      foreach((array)$general_skills as $skill){
        // $user->general_skills()->save($skill);
      }
    }

    return view('users.show', compact('user'));
  }
}
