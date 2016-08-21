<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Project;
use App\User;
use App\ProjectCollaborator;
use App\Http\Requests;

class ProjectCollaboratorController extends Controller
{
  // pendings
  public function project_index(Request $request, Project $project){
    $pendings = ProjectCollaborator::where('project_id', '=', $project->id)->where('accepted', '=', false)->get();

    return view('invitations.index_project', compact('project', 'pendings'));
  }


  public function user_index(Request $request, User $user){
    $invitations = ProjectCollaborator::where('user_id', '=', $user->id)->get();
    return view('invitations.index_user', compact('user', 'invitations'));
  }

  public function recruit(Request $request, User $user){
    // $invitations = Invitation::where('project_id', '=', $project->id);
    $projects = Project::where('user_id', '=', Auth::user()->id)->get();
    $projects_with_pending_invitation = ProjectCollaborator::where('accepted', '=', false)
      ->where('user_id', '=', $user->id)->get()
      ->map(function ($invitation) {
        return $invitation->project;
      }
    );
    $projects = $projects->diff($user->projectsAsCollaborator);
    $projects = $projects->diff($projects_with_pending_invitation);
    if(count($projects)<1){
      $request->session()->flash('error', "Can't recruit, the talent is already on all of your projects!");
      return back();
    }
    return view('invitations.recruit', compact('user', 'projects'));
  }

  public function project_store(Request $request, Project $project){

    $invitation = new ProjectCollaborator();
    $invitation->user_id = Auth::user()->id;
    $invitation->project_id = $project->id;
    $invitation->from_collaborator = true;
    $invitation->accepted = false;
    $invitation->save();

    return back();
  }

  public function accept(Request $request, Project $project, User $user){
    //TODO add message, don't have permission
    // if(Auth::user()->id != $project->owner->id){ return back();}

    $invitation = ProjectCollaborator::where('project_id', '=', $project->id)->where('user_id', '=', $user->id);
    $invitation->update([
      'accepted' => true,
      'accepted_date' => new \DateTime(),
    ]);

    return back();
  }

  public function user_store(Request $request, User $user){

    $invitation = new ProjectCollaborator();
    $invitation->user_id = $user->id;
    $invitation->project_id = request()->project;
    $invitation->from_collaborator = false;
    $invitation->save();

    return redirect($user->path())->with('status', $user->name . ' invited to ' . Project::find(request()->project)->title);
  }

  public function delete(Request $request, Project $project, User $user, ProjectCollaborator $invitation){
    if(Auth::user()->id != $project->owner->id && Auth::user()->id != $invitation->user_id){
      $request->session()->flash('error', "Don't have the permission to delete the invitation!");
      return back();
    }

    ProjectCollaborator::where('project_id', '=', $project->id)->where('user_id', '=', $user->id)->delete();

    return back();
  }

}
