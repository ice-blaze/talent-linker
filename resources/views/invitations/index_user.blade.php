@extends('layout')

@section('content')
  <div class="row">
    <h1>Your invitations</h1>
  </div>

  <div class="row">
    @foreach($invitations as $invitation)
      <li class="list-group-item">
        <a href="{{$invitation->user->path()}}">{{$invitation->user->name}}</a> -
        <a href="{{$invitation->project->path()}}">{{$invitation->project->name}}</a>
        - skill: {{$invitation->skill->name}}
        - invited the {{$invitation->created_at}}
        {{-- accepted the 11.11.1111 --}}
        @if($invitation->accepted)
          - accepted {{$invitation->accepted_date}}
        @else
          - pending ...
          @if($user->id == Auth::user()->id && !$invitation->from_collaborator)
            <form method="post" action="/invitations/{{ $invitation->project->id }}/{{ $invitation->user->id }}/accept">
              {{ method_field('patch') }}
              {{ csrf_field() }}
              <div class="form-group text-right">
                <button type="submit" class="btn btn-primary" name="accept">Accept</button>
              </div>
            </form>
          @endif
        @endif
        @if($user->id == Auth::user()->id)
          <form method="post" action="/invitations/{{ $invitation->project->id }}/{{ $invitation->user->id }}/{{$invitation->id}}">
            {{ method_field('delete') }}
            {{ csrf_field() }}
            <div class="form-group text-right">
              <button type="submit" class="btn btn-danger" name="delete">
                @if($invitation->accepted)
                  Quit Project
                @else
                  Delete Reqest
                @endif
              </button>
            </div>
          </form>
        @endif

      </li>
    @endforeach
  </div>
@endsection