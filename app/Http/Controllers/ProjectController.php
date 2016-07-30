<?php

namespace App\Http\Controllers;

use App\Project;
use App\Language;
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
      $languages = Language::all();
      return view('projects.edit', compact('project', 'languages'));
    }

    public function update(Project $project)
    {
      $project->update(request()->all());

      // managed the langauges
      // TODO certainly another way to do that
      $project->languages()->detach();
      $languages = Language::find(request()->languages);
      if($languages){
        foreach($languages as $language){
          $project->languages()->save($language);
        }
      }

      return view('projects.show', compact('project'));
    }

    public function delete(Project $project)
    {
      $project->delete();
      return redirect()->action('ProjectController@index');
    }
}
