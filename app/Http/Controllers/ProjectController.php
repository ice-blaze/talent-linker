<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function index()
    {
      $projects = Project::all();
      return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
      return view('projects.show', compact('project'));
    }

    public function create()
    {
      return view('projects.create');
    }

    public function store()
    {
      $project = new Project(request()->all());
      $project->save();

      return redirect()->action('ProjectController@show', compact('project'));
    }

    public function edit(Project $project)
    {
      return view('projects.edit', compact('project'));
    }

    public function update(Project $project)
    {
      $project->update(request()->all());
      return back();
    }

    public function delete(Project $project)
    {
      $project->delete();
      return redirect()->action('ProjectController@index');
    }
}
