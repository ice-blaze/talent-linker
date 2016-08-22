@extends('layout')

@section('content')
  <div class="row">
    <h1>Invitation on project: <a href="{{$project->path()}}">{{$project->title}}</a></h1>
  </div>

  <div class="row">
    @foreach($pendings as $collaborator)
      <li class="list-group-item">
        <a href="{{$collaborator->user->path()}}">{{$collaborator->user->name}}</a>
        - invited the {{$collaborator->created_at}}
        @if($collaborator->accepted)
          - accepted
        @else
          - pending ...
          @if($project->owner->id == Auth::user()->id)
            <form method="post" action="/invitations/{{ $project->id }}/{{ $collaborator->user->id }}/accept">
              {{ method_field('patch') }}
              {{ csrf_field() }}
              <div class="form-group text-right">
                <button type="submit" class="btn btn-primary" name="accept">Accept</button>
              </div>
            </form>
            <form method="post" action="/invitations/{{ $project->id }}/{{ $collaborator->user->id }}">
              {{ method_field('delete') }}
              {{ csrf_field() }}
              <div class="form-group text-right">
                <button type="submit" class="btn btn-danger" name="delete">Delete</button>
              </div>
            </form>
          @endif
        @endif

      </li>
    @endforeach
  </div>
@endsection
