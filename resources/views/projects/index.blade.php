@extends('layout')

@section('content')
  <h1>All projects</h1>
  Search bar YAYKS

  @if(Auth::user())
    <a class="btn btn-primary" href="projects/create">Create project</a>
  @endif

  <div class="row">
    <div class="col-md-8 offset-md-2 col-sm-12">
      <form method="post" action="/projects">
        {{ csrf_field() }}
        <div class="form-group">
          <input name="search" placeholder="Search Project" class="form-control"/>
        </div>
      </form>
    </div>
  </div>

  <div class="card-deck-wrapper">
  @foreach(array_chunk($projects->all(), 3) as $threeProjects)
    <div class="card-deck">
      @foreach($threeProjects as $project)
        <div class="card">
          <div class="card-block">
            <h4 class="card-title"><a href="{{ $project->path() }}">{{ $project->title }}</a></h4>
          </div>
          {{-- <img class="card-img-top" src="..." alt="Card image cap"> --}}
          <div class="card-block">
            <p class="card-text">{{ $project->short_description }}</p>
          </div>
        </div>
      @endforeach
    </div>
  @endforeach
@stop
