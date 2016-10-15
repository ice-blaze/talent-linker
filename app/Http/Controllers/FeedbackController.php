<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feedback;
use App\User;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $feedbacks = $user->feedbacks;

        return view('feedbacks.index', compact('feedbacks'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user == null) {
            return $this->index();
        }
        $this->validate($request, [
            'content' => 'required',
        ]);

        $feedback = new Feedback(request()->all());
        $feedback->user_id = $user->id;
        $feedback->save();

        return $this->index();
    }
}
