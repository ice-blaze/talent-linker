<?php

namespace App\Http\Controllers;

use App\GeneralSkill;
use App\Language;
use App\Project;
use App\ProjectCollaborator;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $request->flash();

        $general_skills = GeneralSkill::all();

        if ($request->search) {
            $projects = Project::like('name', $request->search)->get();
        } else {
            $projects = Project::all();
        }

        if ($request->skills) {
            foreach ($request->skills as $skill_tech_name => $skill_id) {
                foreach ($projects as $project_key => $project) {
                    if (!$project->general_skills->contains($skill_id)) {
                        unset($projects[$project_key]);
                    }
                }
            }
        }

        if ($request->near_by) {
            foreach ($projects as $project_key => $project) {
                if (!$project->is_in_search_distance(Auth::user())) {
                    unset($projects[$project_key]);
                }
            }
        }

        return view('projects.index', compact('projects', 'general_skills'));
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
        $this->validate($request, [
            'name'              => 'required',
            'short_description' => 'required',
            'long_description'  => 'required',
            'languages'         => 'required',
        ]);

        // project creation
        $project = new Project();
        // $project->user_id = Auth::user()->id;
        $project->save();
        $this->update($request, $project);

        // owner collaborator creation
        $collaborator = new ProjectCollaborator();
        $collaborator->project_id = $project->id;
        $collaborator->user_id = Auth::user()->id;
        $collaborator->is_project_owner = true;
        $collaborator->from_collaborator = false;
        $collaborator->accepted = true;
        $collaborator->skill_id = request()->skill;
        $collaborator->save();

        return redirect($project->path());
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
        $project->update([
            'name'              => $request->name,
            'short_description' => $request->short_description,
            'long_description'  => $request->long_description,
            'github_link'       => $request->github_link,
            'website_link'      => $request->website_link,
            'image'             => $request->image,
        ]);
        // $project->update(request()->all());

        // managed the langauges
        $project->languages()->sync((array) request()->languages);

        //TODO maybe there is a better way
        $project->general_skills()->detach();
        foreach ((array) request()->general_skills as $id => $count) {
            // ignore relations with 0 skills
            if ($count < 1) {
                continue;
            }

            $skill = [
                'general_skill_id' => $id,
                'project_id'       => $project->id,
                'count'            => $count,
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
