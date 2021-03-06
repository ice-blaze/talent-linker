@extends('layouts.layout')

@section('content')
    <div class="row">
        <h1>{{ Trans('invitations.invite') }} <a href="{{$user->path()}}">{{$user->name}}</a></h1>
    </div>

    <div class="row">
        <form method="post" action="/talents/{{ $user->id }}/recruit">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="project">Project</label>
                <select name="project" class="custom-select">
                    @foreach($projects as $project)
                        <option value="{{$project->id}}">{{$project->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="project">Role</label>
                <select name="skill" class="custom-select">
                    @foreach($general_skills as $skill)
                        <option value="{{$skill->id}}">{{$skill->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="invite">{{ Trans('invitations.invite') }}</button>
                <a class="btn btn-default" href="{{URL::previous() }}"  name="cancel">{{ Trans('invitations.cancel') }}</a>
            </div>
        </form>
    </div>
@endsection
