@extends('layout')

@section('content')
  <div class="row">
    <div class="col-md-8">
      <h1>{{$project->title}}</h1>
    </div>
    @if( $project->isCurrentAuthTheOwner() || $project->isCurrentAuthACollaborator())
      <div class="col-md-1">
        <a class="btn btn-primary" href="/projects/{{ $project->id }}/invitations">See pendings</a>
      </div>

      <div class="col-md-1">
        <a class="btn btn-primary" href="/projects/{{ $project->id }}/private_comments">Private chat</a>
      </div>
    @endif
    @if($project->isCurrentAuthTheOwner())

      <div class="col-md-1">
        <a class="btn btn-primary" href="/projects/{{ $project->id }}/edit">Edit</a>
      </div>

      <div class="col-md-1">
        <form method="post" action="/projects/{{ $project->id }}">
          {{ method_field('delete') }}
          {{ csrf_field() }}
          <div class="form-group">
            <button type="submit" class="btn btn-danger">Delete</button>
          </div>
        </form>
      </div>
    @endif
    @if( Auth::user() && !($project->isCurrentAuthTheOwner() || $project->isCurrentAuthACollaborator()))
      <div class="col-md-4">
        <form method="post" action="/projects/{{ $project->id }}/invitations">
          {{ csrf_field() }}
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Join the project</button>
          </div>
        </form>
      </div>
    @endif
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
      <a href="{{$project->owner->path()}}">{{$project->owner->name}}</a>
    </div>
  </div>

  <div class="row">
    <label class="col-sm-2 control-label">Collaborators</label>
    <div class="col-sm-10">
      {{$project->collaborators}}
      @foreach($project->collaborators as $collaborator)
        {{$collaborator->name}},
      @endforeach
    </div>
  </div>

  <div class="row">
    <label class="col-sm-2 control-label">GitHub</label>
    <div class="col-sm-10">
      {{$project->github}}
    </div>
  </div>

  <div class="row">
    <label class="col-sm-2 control-label">Stack Overflow</label>
    <div class="col-sm-10">
      {{$project->stack_overflow}}
    </div>
  </div>

  <div class="row">
    @foreach($project->comments as $comment)
      <li class="list-group-item">
        {{ $comment->content}}
        <div class="comment_user">
          <a href="{{ $comment->user->path() }}">{{$comment->user->name}}</a> - {{$comment->date}}
        </div>
      </li>
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
          <button type="submit" class="btn btn-primary">Comment</button>
        </div>
      </form>
    @endif
  </div>


@stop
