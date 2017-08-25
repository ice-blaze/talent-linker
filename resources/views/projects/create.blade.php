@extends('projects/template')

@section('action')
    {{"/projects/create"}}
@endsection

@section('button_name')
    {{ Trans('projects.create_project') }}
@endsection

@section('owner_skill')
    <div class="form-group">
        <label for="project">{{ Trans('projects.your_skill_as_project_owner') }}</label>
        <select name="skill" class="custom-select">
            @foreach($general_skills as $skill)
                <option value="{{$skill->id}}">{{$skill->name}}</option>
            @endforeach
        </select>
    </div>
@endsection
