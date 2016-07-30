@extends('projects/template')

@section('method_type')
  {{ method_field('patch') }}
@endsection

@section('action')
  {{"/projects/" . $project->id}}
@endsection

@section('button_name')
  Edit project
@endsection
