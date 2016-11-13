@extends('layouts.layout')

@section('content')
  <div class="row">
    <h1>Invitation on project: <a href="{{$project->path()}}">{{$project->name}}</a></h1>
  </div>

  <div class="row">
    @forelse($pendings as $collaborator)
      <li class="list-group-item">
        <a href="{{$collaborator->user->path()}}">{{$collaborator->user->name}}</a>
        - skill: {{$collaborator->skill->name}}
        - invited the {{$collaborator->created_at}}
        @if($collaborator->accepted)
          - accepted
        @else
          - pending ...
        @endif
        @if($project->owner->user->id == Auth::user()->id)
          @if( $collaborator->from_collaborator && !$collaborator->accepted )
            <form method="post" action="/invitations/{{ $project->id }}/{{ $collaborator->user->id }}/accept">
              {{ method_field('patch') }}
              {{ csrf_field() }}
              <div class="form-group text-right">
                <button type="submit" class="btn btn-primary" name="accept">Accept</button>
              </div>
            </form>
          @endif
          <form method="post" action="/invitations/{{ $project->id }}/{{ $collaborator->user_id }}/{{ $collaborator->id }}">
            {{ method_field('delete') }}
            {{ csrf_field() }}
            <div class="form-group text-right">
              <button type="submit" class="btn btn-danger" name="delete">
                @if($collaborator->accepted)
                  Kick from project
                @else
                  Delete Request
                @endif
              </button>
            </div>
          </form>
        @endif

      </li>
    @empty
      <br>
      <span class="lead col-centered">No invitations...</span>
    @endforelse
  </div>
@endsection
