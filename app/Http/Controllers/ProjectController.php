<?php

namespace App\Http\Controllers;

use App\User;
use App\Project;
use App\Language;
use App\GeneralSkill;
use App\ProjectCollaborator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $request->flash();
        $paginate = 30;

        $general_skills = GeneralSkill::all();

        if ($request->search) {
            $projects = Project::orderBy('created_at', 'asc')->like('name', $request->search)->paginate($paginate);
        } else {
            $projects = Project::orderBy('created_at', 'asc')->paginate($paginate);
        }

        if ($request->skills) {
            foreach ($request->skills as $skill_tech_name => $skill_id) {
                foreach ($projects as $project_key => $project) {
                    if (! $project->generalSkills->contains($skill_id)) {
                        unset($projects[$project_key]);
                    }
                }
            }
        }

        if ($request->near_by) {
            foreach ($projects as $project_key => $project) {
                if (! $project->isInSearchDistance(Auth::user())) {
                    unset($projects[$project_key]);
                }
            }
        }

        return view('projects.index', compact('projects', 'general_skills'));
    }

    public function show(Project $project)
    {
        $general_skills = $project->generalSkills;

        return view('projects.show', compact('project'));
    }

    /*
     *  Display Create Project form if user is logged
     */
    public function create()
    {
        $languages = Language::all();
        $general_skills = GeneralSkill::all();
        $all_users = User::all();

        return view('projects.create', compact('languages', 'general_skills', 'all_users'));
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
        $this->updategeneralSkills($request, $project);

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
        if (! $this->isProjectOwner($project)) {
            return redirect('/');
        }

        $languages = $project->languages;
        $general_skills = $project->generalSkills;

        return view('projects.edit', compact('project', 'languages', 'general_skills'));
    }

    public function updategeneralSkills($request, $project)
    {
        //TODO maybe there is a better way
        $project->generalSkills()->detach();
        foreach ($request->general_skills as $id => $count) {
            // ignore relations with 0 skills
            if ($count < 1) {
                continue;
            }

            $project->generalSkills()->attach(GeneralSkill::find($id), ['count' => $count]);
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
        $this->updategeneralSkills($request, $project);

        return view('projects.show', compact('project'));
    }

    public function delete(Project $project)
    {
        $project->delete();

        return redirect()->action('ProjectController@index');
    }

    public function isProjectOwner(Project $project)
    {
        return $project->owner->user_id == Auth::User()->id || Auth::User()->isAdmin();
    }
}
