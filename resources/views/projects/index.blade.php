@extends('layout')

@section('content')

  @if(Auth::user())
    <div class="row">
      <div class="col-md-12 col-centered">
        <a class="btn btn-primary" href="projects/create">Create project</a>
      </div>
    </div>
    <br>
  @endif

  <div class="row">
    <div class="col-md-8 offset-md-2 col-sm-12">
      <form method="post" action="/projects">
        {{ csrf_field() }}
        <div class="form-group">
          <input name="search" placeholder="Search Project" class="form-control" value="{{ old('search') }}"/>
        </div>
        <div class="form-group">
          @foreach($general_skills as $skill)
            @include('helpers/form_checkbox', [
              'name' => $skill->technical_name,
              'display' => $skill->name,
              'id' => $skill->id,
            ])
          @endforeach
        </div>
      </form>
    </div>
  </div>

  <div class="card-deck-wrapper">
    @foreach(array_chunk($projects->all(), 3) as $threeProjects)
      <div class="card-deck">
        @foreach($threeProjects as $project)
          <div class="card">
              <a href="{{ $project->path() }}">
                <img class="card-img-top img-fluid"
                  @if($project->image)
                    src="{{$project->image}}"
                  @else
                    src="{{asset('assets/images/default_project.png')}}"
                  @endif
                  alt="Project image">
              </a>
            <div class="card-block">
              <h4 class="card-title"><a href="{{ $project->path() }}">{{ $project->title }}</a></h4>
            </div>
            {{-- <img class="card-img-top" src="..." alt="Card image cap"> --}}
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                Profile wanted:
              </li>
            </ul>
            <div class="card-block">
              <p class="card-text">{{ $project->short_description }}</p>
              <p class="card-text"><small class="text-muted">Last updated {{$project->updated_at->diffForHumans()}}</small></p>
            </div>
          </div>
        @endforeach
      </div>
    @endforeach
  </div>
@stop
