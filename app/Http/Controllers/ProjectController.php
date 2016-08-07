<?php

namespace App\Http\Controllers;

use DB;
use App\Project;
use App\User;
use App\Language;
use App\GeneralSkill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
    $languages = Language::all();
    $general_skills = GeneralSkill::all();
    $all_users = User::all();
    return view('projects.create', compact('project', 'languages', 'general_skills', 'all_users'));
  }

  public function store(Request $request)
  {
    $project = new Project();
    $project->user_id = Auth::user()->id;
    $project->save();
    return $this->update($request, $project);
  }

  public function edit(Project $project)
  {
    $languages = Language::all();
    $general_skills = GeneralSkill::all();
    $all_users = User::all();
    return view('projects.edit', compact('project', 'languages', 'general_skills', 'all_users'));
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

    $project->update([
      'title' => $request->title,
      'short_description' => $request->short_description,
      'long_description' => $request->long_description,
    ]);
    // $project->update(request()->all());

    // managed the langauges
    $project->languages()->sync((array)request()->languages);

    // managed the collaborators
    //TODO maybe there is a better way
    DB::table('project_collaborators')->where('project_id', $project->id)->delete();
    foreach((array)request()->collaborators as $id){

      $collaboration = [
        'project_id' => $project->id,
        'user_id' => $id,
      ];

      DB::table('project_collaborators')->insert($collaboration);
    }


    //TODO maybe there is a better way
    $project->general_skills()->detach();
    foreach((array)request()->general_skills as $id => $count){
      // ignore relations with 0 skills
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
