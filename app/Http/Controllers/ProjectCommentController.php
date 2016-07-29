<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ProjectComment;
use App\Project;

class ProjectCommentController extends Controller
{
    public function store(Project $project){
      $project->addComment(
        new ProjectComment(request()->all())
      );

      return back();
    }

    public function edit(ProjectComment $comment){
      return view('project_comments.edit', compact('comment'));
    }

    public function update(ProjectComment $comment){
      $comment->update(request()->all());
      return back();
    }
}
