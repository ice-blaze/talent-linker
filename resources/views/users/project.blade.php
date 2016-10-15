@extends('layout')

@section('content')


  @if($user->collaborations)
    <div class="row">
      <label for="col-md-12"><strong>Projects</strong></label>
      <div class="col-md-12">
        @foreach ($user->collaborations as $collaboration)
          <div class="col-xl-3 col-lg-4 col-md-6 col-xs-12">
            <div class="media card card-outline-primary ">
              <a class="media-left" href="{{$collaboration->project->path()}}">
                <img class="media-object image-64"
                  @if($collaboration->project->image)
                    src="{{$collaboration->project->image}}"
                  @else
                    src="{{asset('assets/images/default_project.png')}}"
                  @endif
                  alt="Project Image {{$collaboration->project->name}}">
              </a>
              <div class="media-body">
                <a href="{{$collaboration->project->path()}}">
                  <h4 class="media-heading">{{$collaboration->project->name}}</h4>
                </a>
                <span class="tag tag-primary">{{$collaboration->skill->name}}</span>
                @if($collaboration->is_project_owner)
                  <span class="tag tag-pill tag-danger">Owner</span>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endif

@endsection
