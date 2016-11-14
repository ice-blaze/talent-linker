@extends('layouts.layout')

@section('content')

  @if(Auth::user())
    <div class="row">
      <div class="col-md-12 col-centered">
        <a class="btn btn-primary" href="projects/create">Create Project</a>
      </div>
    </div>
    <br>
  @endif

  <div class="row">
    <div class="col-md-8 offset-md-2 col-sm-12">
      <form method="post" action="/projects">
        {{ csrf_field() }}
        <div class="form-group input-group">
          <a onclick="$(this).closest('form').submit()" class="search-button input-group-addon">
            <i class="fa fa-search" aria-hidden="true"></i>
          </a>
          <input name="search" placeholder="Search Project" class="form-control" value="{{ old('search') }}"/>
        </div>
        <div class="form-group">
          @if (Auth::user())
            @include('helpers/form_checkbox', [
              'name' => "near_by",
              'display' => '<i class="fa fa-map-marker" aria-hidden="true"></i> Near By',
              'id' => "near_by",
              'skill' => false,
            ])
          @endif
          @foreach($general_skills as $skill)
            @include('helpers/form_checkbox', [
              'name' => $skill->technical_name,
              'display' => $skill->name,
              'id' => $skill->id,
              'skill' => true,
            ])
          @endforeach
        </div>
      </form>
    </div>
  </div>

  <div class="card-deck-wrapper">
    @forelse(array_chunk($projects->all(), 3) as $threeProjects)
      <div class="card-deck">
        @foreach($threeProjects as $project)
          <div class="card">
              <a href="{{ $project->path() }}">
                <img class="card-img-top img-fluid m-x-auto"
                  @if($project->image)
                    src="{{$project->image}}"
                  @else
                    src="{{asset('assets/images/default_project.png')}}"
                  @endif
                  alt="Project image">
              </a>
            <div class="card-block">
              <h4 class="card-title"><a href="{{ $project->path() }}">{{ $project->name }}</a></h4>
              @if (Auth::user())
                @if($project->isInSearchDistance(Auth::user()))
                  <span class="tag tag-pill tag-primary"><i class="fa fa-map-marker" aria-hidden="true"></i> Near You</span>
                @else
                  <span class="tag tag-pill tag-danger"><i class="fa fa-map-marker" aria-hidden="true"></i> Not Near</span>
                @endif
              @endif
            </div>
            {{-- <img class="card-img-top" src="..." alt="Card image cap"> --}}
            <div class="card-block">
              <p class="card-text">{{ $project->short_description }}</p>
              <p>
                @foreach($project->currentSkillAndWanted() as $skill)
                  @if($skill['wanted'] > 0 && $skill['have'] >= $skill['wanted'])
                    <span class="tag tag-primary">
                  @else
                    <span class="tag tag-default">
                  @endif
                    {{$skill['skill']->name}} {{$skill['have']}} / {{$skill['wanted']}}
                  </span>
                @endforeach
                <br>
              </p>
              <p class="card-text"><small class="text-muted">Last updated {{$project->updated_at->diffForHumans()}}</small></p>
            </div>
          </div>
        @endforeach
      </div>
    @empty
      <div class="row">
        <div class="col-md-12 col-centered">
          <h2>No Projects...</h2>
        </div>
      </div>
    @endforelse
  </div>
@stop
