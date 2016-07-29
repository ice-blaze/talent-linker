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

@section('title_content'){{ $project->title }}@endsection

@section('short_description'){{ $project->short_description }}@endsection

@section('long_description'){{ $project->long_description }}@endsection
