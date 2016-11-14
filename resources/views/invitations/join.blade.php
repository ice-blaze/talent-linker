@extends('layouts.layout')

@section('content')
    <div class="row">
        <h1>Join project: <a href="{{$project->path()}}">{{$project->name}}</a></h1>
    </div>

    <div class="row">
        <form method="post" action="/projects/{{ $project->id }}/invitations">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="project">Join as: </label>
                <select name="skill" class="custom-select">
                    @foreach($general_skills as $skill)
                        <option value="{{$skill->id}}">{{$skill->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="join">Join</button>
                <a class="btn btn-default" href="{{URL::previous() }}"  name="cancel">Cancel</a>
            </div>
        </form>
    </div>
@endsection
