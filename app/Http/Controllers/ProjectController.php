<?php

namespace App\Http\Controllers;

use DB;
use App\Project;
use App\Language;
use App\GeneralSkill;
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
    $general_skills = $project->general_skills;
    return view('projects.show', compact('project'));
  }

  public function create()
  {
    return view('projects.create');
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      'title' => 'required',
      'short_description' => 'required',
      'long_description' => 'required',
      //TODO HAVE AT LEAST ONE LANGUAGE
    ]);

    $project = new Project(request()->all());
    $project->save();

    return redirect()->action('ProjectController@show', compact('project'));
  }

  public function edit(Project $project)
  {
    $languages = Language::all();
    $general_skills = GeneralSkill::all();
    return view('projects.edit', compact('project', 'languages', 'general_skills'));
  }

  public function update(Request $request, Project $project)
  {
    // TODO maybe create a function to avoid the duplicate validation
    $this->validate($request, [
      'title' => 'required',
      'short_description' => 'required',
      'long_description' => 'required',
      //TODO HAVE AT LEAST ONE LANGUAGE
    ]);

    $project->update(request()->all());

    // managed the langauges
    $project->languages()->sync((array)request()->languages);

    //TODO maybe there is a better way
    $project->general_skills()->detach();
    foreach(request()->general_skills as $id => $count){
      if($count < 1){ continue; }

      $skill = [
        'general_skill_id' => $id,
        'project_id' => $project->id,
        'count' => $count,
      ];

      DB::table('general_skill_project')->insert($skill);
    }

    return view('projects.show', compact('project'));
  }

  public function delete(Project $project)
  {
    $project->delete();
    return redirect()->action('ProjectController@index');
  }
}
