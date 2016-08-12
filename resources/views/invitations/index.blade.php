@extends('layout')

@section('content')
  <div class="row">
    <h1>Invitation on project: <a href="{{$project->path()}}">{{$project->title}}</a></h1>
  </div>

  <div class="row">
    @foreach($invitations as $invitation)
      <li class="list-group-item">
        <a href="{{$invitation->guest->path()}}">{{$invitation->guest->name}}</a>
        - invited the {{$invitation->created_at}}
        @if($invitation->accepted)
          - accepted
        @else
          - pending ...
          @if($project->owner->id == Auth::user()->id && $invitation->from_guest)
            <form method="post" action="/invitations/{{ $project->id }}/{{ $invitation->guest->id }}/accept">
              {{ method_field('patch') }}
              {{ csrf_field() }}
              <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">Accept</button>
              </div>
            </form>
            <form method="post" action="/invitations/{{ $project->id }}/{{ $invitation->guest->id }}">
              {{ method_field('delete') }}
              {{ csrf_field() }}
              <div class="form-group text-right">
                <button type="submit" class="btn btn-danger">Delete</button>
              </div>
            </form>
          @endif
        @endif

      </li>
    @endforeach
  </div>
@endsection
