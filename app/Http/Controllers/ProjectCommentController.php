<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ProjectComment;
use App\Project;
use Illuminate\Support\Facades\Auth;

class ProjectCommentController extends Controller
{
  public function store(Request $request, Project $project){
    $this->validate($request, [
      'content' => 'required',
      //TODO user_id
    ]);

    $comment = new ProjectComment(request()->all());
    $comment->user_id = Auth::user()->id;
    $project->addComment($comment);

    return back();
  }

  public function edit(ProjectComment $comment){
    return view('project_comments.edit', compact('comment'));
  }

  public function update(ProjectComment $comment){
    $this->validate($request, [
      'content' => 'required',
      //TODO user_id
    ]);
    $comment->update(request()->all());
    return back();
  }
}
