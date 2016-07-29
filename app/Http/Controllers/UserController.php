<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

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
      return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
      return view('users.edit', compact('user'));
    }

    public function update(User $user)
    {
      $user->update(request()->all());
      return view('users.show', compact('user'));
    }
}
