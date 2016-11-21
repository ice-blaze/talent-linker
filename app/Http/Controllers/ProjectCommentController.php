<?php

namespace App\Http\Controllers;

use App\Project;
use App\ProjectComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectCommentController extends Controller
{
    public function private_index(Request $request, Project $project)
    {
        return view('project_comments.private_index', compact('project'));
    }

    public function private_store(Request $request, Project $project)
    {
        $this->validate($request, [
            'content' => 'required',
            //TODO user_id
        ]);

        $comment = new ProjectComment(request()->all());
        $comment->user_id = Auth::user()->id;
        $comment->private = true;
        $project->addComment($comment);

        return back();
    }

    public function store(Request $request, Project $project)
    {
        $this->validate($request, [
            'content' => 'required',
            //TODO user_id
        ]);

        $comment = new ProjectComment(request()->all());
        $comment->user_id = Auth::user()->id;
        $comment->private = false;
        $project->addComment($comment);

        return back();
    }

    public function edit(ProjectComment $comment)
    {
        if (Auth::User()->id != $comment->user->id) {
            return redirect('/')->withErrors('You are not authorized to do this action!');
        }

        $route = 'comments';
        $object = 'message';
        $routeToDelete = '/comments/'.$comment->id;

        $item = $comment;

        return view('layouts.edit_text', compact('item', 'route', 'object', 'routeToDelete'));
    }

    public function update(Request $request, ProjectComment $comment)
    {
        if (Auth::User()->id != $comment->user->id) {
            return redirect('/')->withErrors('You are not authorized to do this action!');
        }

        $this->validate($request, [
            'content' => 'required',
        ]);
        $comment->update(request()->all());

        return redirect($comment->project->path());
    }

    public function delete(ProjectComment $comment)
    {
        if (Auth::User()->id != $comment->user->id) {
            return redirect('/')->withErrors('You are not authorized to do this action!');
        }

        $project = $comment->project;

        $comment->delete();

        return redirect($project->path());
    }
}
