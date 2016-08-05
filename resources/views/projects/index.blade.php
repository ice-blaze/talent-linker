@extends('layout')

@section('content')
  <h1>All projects</h1>

  @if(Auth::user())
    <a class="btn btn-primary" href="projects/create">Create project</a>
  @endif

  @foreach($projects as $project)
    <div>
      <a href="{{ $project->path() }}">{{ $project->title}}</a>
    </div>
  @endforeach
@stop
