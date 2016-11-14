<?php

namespace App\Http\Controllers;

use App\GeneralSkill;
use App\Project;
use App\ProjectCollaborator;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectCollaboratorController extends Controller
{
    // pendings
    public function projectIndex(Request $request, Project $project)
    {
        $collabs_id = array_map(function ($c) {
            return $c['user_id'];
        }, $project->collaborators->toArray());

        if (Auth::check() && in_array(Auth::id(), $collabs_id)) {
            $pendings = ProjectCollaborator::where('project_id', '=', $project->id)
            ->where('is_project_owner', '=', false)->get();

            return view('invitations.index_project', compact('project', 'pendings'));
        } else {
            session()->flash('error', 'That was not your project');

            return redirect()->back();
        }
    }

    public function userIndex(Request $request, User $user)
    {
        if (Auth::check() && Auth::id() == $user->id) {
            $invitations = ProjectCollaborator::where('user_id', '=', $user->id)->get();

            return view('invitations.index_user', compact('user', 'invitations'));
        } else {
            session()->flash('error', 'That was not your project');

            return redirect()->back();
        }
    }

    public function recruit(Request $request, User $user)
    {
        $projects = Auth::user()->projects;
        $projects_with_pending_invitation = ProjectCollaborator::where('accepted', '=', false)
        ->where('user_id', '=', $user->id)->get()->map(function ($invitation) {
            return $invitation->project;
        });

        $projects = $projects->diff($user->projectsAsCollaborator);
        $projects = $projects->diff($projects_with_pending_invitation);

        if (count($projects) < 1) {
            if (count(Auth::user()->projects) == 0) {
                $request->session()->flash('error', "Can't recruit, you have no projects!");
            } else {
                $request->session()->flash('error', "Can't recruit, the talent is already on all of your projects!");
            }

            return back();
        }

        $general_skills = GeneralSkill::all();

        return view('invitations.recruit', compact('user', 'projects', 'general_skills'));
    }

    public function join(Request $request, Project $project)
    {
        $general_skills = GeneralSkill::all();

        return view('invitations.join', compact('user', 'project', 'general_skills'));
    }

    public function projectStore(Request $request, Project $project)
    {
        $invitation = new ProjectCollaborator();
        $invitation->user_id = Auth::user()->id;
        $invitation->project_id = $project->id;
        $invitation->is_project_owner = false;
        $invitation->from_collaborator = true;
        $invitation->accepted = false;
        $invitation->skill_id = request()->skill;
        //TODO add comment
        // $invitation->invitation_message = request()->;
        $invitation->save();

        return redirect($project->path());
    }

    public function userStore(Request $request, User $user)
    {
        $invitation = new ProjectCollaborator();
        $invitation->user_id = $user->id;
        $invitation->project_id = request()->project;
        $invitation->is_project_owner = false;
        $invitation->from_collaborator = false;
        $invitation->accepted = false;
        $invitation->skill_id = request()->skill;
        //TODO add comment
        // $invitation->invitation_message = request()->;
        $invitation->save();

        return redirect($user->path())
        ->with('status', $user->name.' invited to '.Project::find(request()->project)->name);
    }

    public function accept(Request $request, Project $project, User $user)
    {
        // Get user invitation in DB
        $invitation = ProjectCollaborator::where('project_id', '=', $project->id)->where('user_id', '=', $user->id);

        // User is not project admin or did not received an invitation
        if (Auth::user()->id != $project->owner->user->id && count($invitation) == 0) {
            $request->session()->flash('error', "You don't have the permission");
        } else {
            $invitation->update(['accepted' => true, 'accepted_date' => new \DateTime()]);
        }

        return back();
    }

    public function delete(Request $request, Project $project, User $user, ProjectCollaborator $invitation)
    {
        if (Auth::user()->id != $project->owner->user->id && Auth::user()->id != $invitation->user_id) {
            $request->session()->flash('error', "Don't have the permission to delete the invitation!");

            return back();
        }

        // If owner leave, then delete every thing related to the project
        if($project->owner->user_id == $user->id) {
            ProjectCollaborator::where('project_id', '=', $project->id)->delete();
            $project->delete();
        // Elsewhere if it's only a collaborator, remove the link
        } else {
            ProjectCollaborator::where('project_id', '=', $project->id)->where('user_id', '=', $user->id)->delete();
        }

        return back();
    }
}
