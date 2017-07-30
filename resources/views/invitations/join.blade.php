@extends('layouts.layout')

@section('content')
    <div class="row">
        <h1>{{ Trans('invitations.join_project') }}: <a href="{{$project->path()}}">{{$project->name}}</a></h1>
    </div>

    <div class="row">
        <form method="post" action="/projects/{{ $project->id }}/invitations">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="project">{{ Trans('invitations.join_as') }}: </label>
                <select name="skill" class="custom-select">
                    @foreach($general_skills as $skill)
                        <option value="{{$skill->id}}">{{$skill->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="join">{{ Trans('invitations.join') }}</button>
                <a class="btn btn-default" href="{{URL::previous() }}"  name="cancel">{{ Trans('invitations.cancel') }}</a>
            </div>
        </form>
    </div>
@endsection
