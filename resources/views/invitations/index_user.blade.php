@extends('layouts.layout')

@section('content')
    <div class="row">
        <h1>Your invitations</h1>
    </div>

    <div class="row">
        @forelse($invitations as $invitation)
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
                                <button type="submit" class="btn btn-primary" name="accept{{ $invitation->id }}">Accept</button>
                            </div>
                        </form>
                    @endif
                @endif
                @if($user->id == Auth::user()->id)
                    <form method="post" action="/invitations/{{ $invitation->project->id }}/{{ $invitation->user->id }}/{{$invitation->id}}">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-danger" name="delete{{ $invitation->id }}">
                                @if($invitation->accepted)
                                    Quit Project (Delete)
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
