<?php

namespace App\Http\Controllers;

use App\GeneralSkill;
use App\Language;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $request->flash(); // to have the old functionality (don't understand why it's necessary here)

        $users = User::all();

        if ($request->search) {
            $users = User::like('name', $request->search)->get();
        } else {
            $users = User::all();
        }

        $general_skills = GeneralSkill::all();

        // maybe could be better
        if ($request->skills) {
            foreach ($request->skills as $skill_tech_name => $skill_id) {
                foreach ($users as $user_key => $user) {
                    if (!$user->general_skills->contains($skill_id)) {
                        unset($users[$user_key]);
                    }
                }
            }
        }

        if ($request->near_by) {
            foreach ($users as $user_key => $user) {
                if (!$user->is_in_search_distance(Auth::user())) {
                    unset($users[$user_key]);
                }
            }
        }

        return view('users.index', compact('users', 'general_skills'));
    }

    public function projects(User $user)
    {
        return view('users.project', compact('user'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (Auth::check() && Auth::id() == $user->id) {
            $languages = Language::all();
            $general_skills = GeneralSkill::all();

            return view('users.edit', compact('user', 'languages', 'general_skills'));
        } else {
            session()->flash('error', 'That was not your profile');

            return redirect()->back();
        }
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|unique:users,email,'.$user->id,
            'last_name' => 'required|max:255',
            'first_name' => 'required|max:255',
            'languages' => 'required',
            'general_skills' => 'required',
            ]);

        $user->update(request()->all());

        // managed the langauges
        $user->languages()->sync((array) request()->languages);

        $user->general_skills()->detach();
        $general_skills = GeneralSkill::find(request()->general_skills);
        if ($general_skills) {
            foreach ($general_skills as $skill) {
                $user->general_skills()->save($skill);
            }
        }

        return view('users.show', compact('user'));
    }
}
