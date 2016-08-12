<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Project;
use App\User;
use App\Invitation;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
  public function project_index(Request $request, Project $project){
    $invitations = Invitation::where('project_id', '=', $project->id)->get();

    return view('invitations.index', compact('project', 'invitations'));
  }

  public function user_index(Request $request, User $user){
    $invitations = Invitation::where('guest_id', '=', $user->id)->get();
    return view('invitations.index_user', compact('user', 'invitations'));
  }

  public function recruit(Request $request, User $user){
    // $invitations = Invitation::where('project_id', '=', $project->id);
    $projects = Project::where('user_id', '=', Auth::user()->id)->get();
    $projects_with_pending_invitation = Invitation::where('accepted', '=', false)
      ->where('guest_id', '=', $user->id)->get()
      ->map(function ($invitation) {
        return $invitation->project;
      }
    );
    $projects = $projects->diff($user->projectsAsCollaborator);
    $projects = $projects->diff($projects_with_pending_invitation);
    return view('invitations.recruit', compact('user', 'projects'));
  }

  public function project_store(Request $request, Project $project){

    $invitation = new Invitation();
    $invitation->guest_id = Auth::user()->id;
    $invitation->project_id = $project->id;
    $invitation->from_guest = true;
    $invitation->save();

    return back();
  }

  public function accept(Request $request, Project $project, User $user){
    //TODO add message, don't have permission
    // if(Auth::user()->id != $project->owner->id){ return back();}

    $invitation = Invitation::where('project_id', '=', $project->id)->where('guest_id', '=', $user->id);
    $invitation->update(['accepted'=>true]);

    return back();
  }

  public function user_store(Request $request, User $user){

    $invitation = new Invitation();
    $invitation->guest_id = $user->id;
    $invitation->project_id = request()->project;
    $invitation->from_guest = false;
    $invitation->save();

    return redirect('/talents/'.$user->id)->with('status', $user->name . ' invited to ' . Project::find(request()->project)->title);
    return $user->path();
  }

  public function delete(Request $request, Project $project, User $user){
    //TODO add message, don't have permission
    // if(Auth::user()->id != $project->owner->id){ return back();}
    Invitation::where('project_id', '=', $project->id)->where('guest_id', '=', $user->id)->delete();

    return back();
  }

  // public function user_store(Request $request, User $talent){
  //
  //   $invitation = new Invitation();
  //   $invitation->guest_id = Auth::user()->id;
  //   $invitation->project_id = $project->id;
  //   $invitation->from_guest = false;
  //   $invitation->save();
  //
  //   return back();
  // }
}
