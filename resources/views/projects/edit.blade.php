@extends('projects/template')

@section('method_type')
    {{ method_field('patch') }}
@endsection

@section('collaborators')
    <div class="form-group">
        <label for="collaborators">{{ Trans('projects.collaborators') }}</label>
        {{ Trans('projects.can_only_delete_collaborators') }}
    </div>
@endsection

@section('action')
    {{"/projects/" . $project->id}}
@endsection

@section('button_name')
    {{ Trans('projects.edit_project') }}
@endsection
