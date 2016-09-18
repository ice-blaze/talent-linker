@extends('projects/template')

@section('action')
  {{"/projects/create"}}
@endsection

@section('button_name')
    Create project
@endsection

@section('owner_skill')
  <div class="form-group">
    <label for="project">Skill</label>
    <select name="skill" class="custom-select">
      @foreach($general_skills as $skill)
        <option value="{{$skill->id}}">{{$skill->name}}</option>
      @endforeach
    </select>
  </div>
@endsection
