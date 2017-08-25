@extends('layouts.layout')

@section('content')
    <div class="row">
        <h1>{{ Trans('invitations.invitation_on_project') }}: <a href="{{$project->path()}}">{{$project->name}}</a></h1>
    </div>

    <div class="row">
        @forelse($pendings as $collaborator)
            <li class="list-group-item">
                <a href="{{$collaborator->user->path()}}">{{$collaborator->user->name}}</a>
                - {{ Trans('invitations.skills') }}: {{$collaborator->skill->name}}
                - {{ Trans('invitations.invited_the') }} {{$collaborator->created_at}}
                @if($collaborator->accepted)
                    - {{ Trans('invitations.accepted') }} {{$collaborator->accepted_date}}
                @else
                    - {{ Trans('invitations.pending') }} ...
                @endif
                @if($project->owner->user->id == Auth::user()->id)
                    @if( $collaborator->from_collaborator && !$collaborator->accepted )
                        <form method="post" action="/invitations/{{ $project->id }}/{{ $collaborator->user->id }}/accept">
                            {{ method_field('patch') }}
                            {{ csrf_field() }}
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary" name="accept{{ $collaborator->id }}">{{ Trans('invitations.accept') }}</button>
                            </div>
                        </form>
                    @endif
                    <form method="post" action="/invitations/{{ $project->id }}/{{ $collaborator->user_id }}/{{ $collaborator->id }}">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-danger" name="delete{{ $collaborator->id }}">
                                @if($collaborator->accepted)
                                    {{ Trans('invitations.kick_from_project') }}
                                @else
                                    {{ Trans('invitations.delete_request') }}
                                @endif
                            </button>
                        </div>
                    </form>
                @endif
            </li>
        @empty
            <br>
            <span class="lead col-centered">{{ Trans('invitations.no_invitations') }} ...</span>
        @endforelse
    </div>
@endsection
