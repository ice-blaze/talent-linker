<?php

namespace App\Http\Controllers;

use App\GeneralSkill;
use App\Language;
use App\Project;
use App\ProjectCollaborator;
use App\User;
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
                    if (! $project->general_skills->contains($skill_id)) {
                        unset($projects[$project_key]);
                    }
                }
            }
        }

        if ($request->near_by) {
            foreach ($projects as $project_key => $project) {
                if (! $project->is_in_search_distance(Auth::user())) {
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

    /*
     *  Display Create Project form if user is logged
     */
    public function create()
    {
        if (Auth::check()) {
            $languages = Language::all();
            $general_skills = GeneralSkill::all();
            $all_users = User::all();

            return view('projects.create', compact('project', 'languages', 'general_skills', 'all_users'));
        } else {
            return redirect('/');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'languages' => 'required',
            ]);

        // project creation
        $project = new Project;
        $project->name = $request->name;
        $project->short_description = $request->short_description;
        $project->long_description = $request->long_description;
        $project->image = $request->image;
        $project->github_link = $request->github_link;
        $project->website_link = $request->website_link;
        $project->save();

        $project->languages()->sync($request->languages);
        $this->updateGeneralSkills($request, $project);

        // owner collaborator creation
        $collaborator = new ProjectCollaborator();
        $collaborator->project_id = $project->id;
        $collaborator->user_id = Auth::user()->id;
        $collaborator->is_project_owner = true;
        $collaborator->from_collaborator = false;
        $collaborator->accepted = true;
        $collaborator->skill_id = $request->skill;
        $collaborator->save();

        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        $languages = $project->languages;
        
        $general_skills = $project->general_skills;
        return view('projects.edit', compact('project', 'languages', 'general_skills'));
    }

    public function updateGeneralSkills($request, $project)
    {

        //TODO maybe there is a better way
        $project->general_skills()->detach();
        foreach ($request->general_skills as $id => $count) {
            // ignore relations with 0 skills
            if ($count < 1) {
                continue;
            }

            $project->general_skills()->attach(GeneralSkill::find($id), ['count' => $count]);
        }
    }

    public function update(Request $request, Project $project)
    {
        $this->validate($request, [
            'name' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'languages' => 'required',
            ]);

        $project->update([
            'name' => $request->name,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'github_link' => $request->github_link,
            'website_link' => $request->website_link,
            'image' => $request->image,
        ]);

        // managed the langauges
        $project->languages()->sync($request->languages);

        // managed the skills
        $this->updateGeneralSkills($request, $project);

        return view('projects.show', compact('project'));
    }

    public function delete(Project $project)
    {
        $project->delete();

        return redirect()->action('ProjectController@index');
    }
}
