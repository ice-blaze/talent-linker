@extends('layout')

@section('content')

  <div class="row text-right">
    @if( Auth::user() && ($project->isUserTheOwner(Auth::user()) || $project->isUserACollaborator(Auth::user())))
      <a class="btn btn-primary" href="/projects/{{ $project->id }}/invitations">See pendings</a>
      <a class="btn btn-primary" href="/projects/{{ $project->id }}/private_comments">Private chat</a>
    @endif

    @if(Auth::user() && $project->isUserTheOwner(Auth::user()))
      <a class="btn btn-primary" href="/projects/{{ $project->id }}/edit">Edit</a>

      <form id="delete_form" method="post" action="/projects/{{ $project->id }}">
        {{ method_field('delete') }}
        {{ csrf_field() }}
        <div class="form-group">
          <button type="submit" class="btn btn-danger" name="delete">Delete</button>
        </div>
      </form>
    @endif

    @if( Auth::user() && $project->isPendingUser(Auth::user()))
      <div class="btn btn-default disabled">
        Invitation is pending...
      </div>
    @endif

    @if( Auth::user() && !$project->isPendingUser(Auth::user()) && !($project->isUserTheOwner(Auth::user()) || $project->isUserACollaborator(Auth::user())))
      <form method="get" action="/projects/{{ $project->id }}/join">
        {{ csrf_field() }}
        <div class="form-group">
          <button type="submit" class="btn btn-primary"  name="join_project">Join the project</button>
        </div>
      </form>
    @endif
  </div>

  <div class="row">
    <div class="col-md-12">
      <h1>{{$project->title}}</h1>
    </div>
  </div>

  <div class="row">
    <label class="col-sm-2 control-label">Short Description</label>
    <div class="col-sm-10">
      {{$project->short_description}}
    </div>
  </div>

  <div class="row">
    <label class="col-sm-2 control-label">Long Description</label>
    <div class="col-sm-10">
      {{$project->long_description}}
    </div>
  </div>

  <div class="row">
    <label class="col-sm-2 control-label">Skills</label>
    <div class="col-sm-10">
      @foreach($project->general_skills as $skill)
        {{$skill->name}}:{{$skill->pivot->count}},
      @endforeach
    </div>
  </div>

  <div class="row">
    <label class="col-sm-2 control-label">Languages</label>
    <div class="col-sm-10">
      @foreach($project->languages as $language)
        {{$language->name}},
      @endforeach
    </div>
  </div>

  <div class="row">
    <label class="col-sm-2 control-label">Owner</label>
    <div class="col-sm-10">
      <a href="{{$project->owner()->path()}}">{{$project->owner()->name}}</a>
    </div>
  </div>

  <div class="row">
    <label class="col-sm-2 control-label">Collaborators</label>
    <div class="col-sm-10">
      @foreach($project->collaborators as $collaborator)
        {{$collaborator->name}},
      @endforeach
    </div>
  </div>

  <div class="row">
    <label class="col-sm-2 control-label">GitHub</label>
    <div class="col-sm-10">
      {{$project->github_link}}
    </div>
  </div>

  <div class="row">
    <label class="col-sm-2 control-label">Website</label>
    <div class="col-sm-10">
      {{$project->website_link}}
    </div>
  </div>

  <div class="row">
    @foreach($project->comments as $comment)
      @include('helpers/user_comment', [
        'comment' => $comment,
      ])
    @endforeach

    @if(Auth::user())
      <hr>
      <h3>Add a comment</h3>
      <form method="post" action="/projects/{{ $project->id }}/comments">
        {{ csrf_field() }}
        <div class="form-group">
          <textarea name="content" class="form-control"></textarea>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary" name="comment">Comment</button>
        </div>
      </form>
    @endif
  </div>


@stop
