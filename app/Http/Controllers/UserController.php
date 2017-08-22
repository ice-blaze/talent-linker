<?php

namespace App\Http\Controllers;

use App\User;
use App\Language;
use App\GeneralSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $request->flash(); // to have the old functionality (don't understand why it's necessary here)

        $paginate = 30;

        if ($request->search) {
            $users = User::orderBy('created_at', 'asc')->like('name', $request->search)->paginate($paginate);
        } else {
            $users = User::orderBy('created_at', 'asc')->paginate($paginate);
        }

        $general_skills = GeneralSkill::all();

        // maybe could be better
        if ($request->skills) {
            foreach ($request->skills as $skill_tech_name => $skill_id) {
                foreach ($users as $user_key => $user) {
                    if (! $user->generalSkills->contains($skill_id)) {
                        unset($users[$user_key]);
                    }
                }
            }
        }

        if ($request->near_by) {
            foreach ($users as $user_key => $user) {
                if (! $user->isInSearchDistance(Auth::user())) {
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
        if (! Auth::check() || Auth::id() != $user->id) {
            session()->flash('error', 'That was not your profile');

            return redirect()->back();
        }

        $languages = Language::all();
        $general_skills = GeneralSkill::all();

        return view('users.edit', compact('user', 'languages', 'general_skills'));
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
            'find_distance' => 'required|numeric',
        ]);

        $user->update(request()->all());

        // managed the languages
        $user->languages()->sync((array) request()->languages);

        $user->generalSkills()->detach();
        $general_skills = GeneralSkill::find(request()->general_skills);
        if ($general_skills) {
            foreach ($general_skills as $skill) {
                $user->generalSkills()->save($skill);
            }
        }

        return view('users.show', compact('user'));
    }
}
