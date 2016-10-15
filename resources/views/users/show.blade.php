@extends('layout')

@section('content')
  <div class="row col-centered">
    @if($user->isCurrentAuth())
      <a class="btn btn-primary" href="/talents/{{ $user->id }}/edit">Edit Profile</a>
      <a class="btn btn-primary" href="/talents/{{ $user->id }}/invitations">Invitations</a>
    @endif
    @if(Auth::user() && !$user->isCurrentAuth())
      <a class="btn btn-primary" href="/talents/{{ $user->id }}/chat">Chat with this talent</a>
      <a class="btn btn-primary" href="/talents/{{ $user->id }}/recruit">Recruit for one project</a>
    @endif
  </div>
  <br>

  <div class="row col-centered">
    <img class="img-circle image-256"
      @if($user->image)
        src="{{$user->image}}"
      @else
        src="{{asset('assets/images/default_profile.png')}}"
      @endif
      alt="User profile">
  </div>

  <div class="row col-centered">
    <div class="col-sm-12">
      @if (Auth::user())
        @if ($user->is_in_search_distance(Auth::user()))
          <span class="tag tag-pill tag-primary"><i class="fa fa-map-marker" aria-hidden="true"></i> Near You</span>
        @else
          <span class="tag tag-pill tag-danger"><i class="fa fa-map-marker" aria-hidden="true"></i> Not Near</span>
        @endif
      @endif
      <h1>{{$user->name}}</h1>
    </div>
  </div>

  <div class="row col-centered">
    <div class="col-sm-12">
      <a href="mailto:{{$user->email}}">{{$user->email}}</a>
    </div>
  </div>

  <br>
  <div class="row lead">
    <div class="col-sm-12">
      {{-- {{$user->talent_description}} --}}
      {!! $user->talent_description !!}
    </div>
  </div>

  <br>
  <div class="row">
    <label class="col-sm-2"><strong>Skills</strong></label>
    <div class="col-sm-10">
      @forelse($user->general_skills as $skill)
        <span class="tag tag-primary">{{$skill->name}}</span>
      @empty
        No Skills
      @endforelse
    </div>
  </div>

  <br>
  <div class="row">
    <label class="col-sm-2"><strong>Languages</strong></label>
    <div class="col-sm-10">
      @foreach($user->languages as $language)
        <span class="tag tag-pill tag-primary">
          {{$language->name}}
        </span>
      @endforeach
    </div>
  </div>

  <div class="row">
    <label class="col-sm-12"><strong>Place</strong></label>
    <div class="col-sm-12">
      @include('helpers.gmap', [
        "class" => "gm-show",
        "lat" => $user->lat,
        "lng" => $user->lng,
        "find_distance" => $user->find_distance,
        'edit' => 0,
      ])
    </div>
  </div>

  <br>
  @if($user->github)
    <div class="row">
        <label class="col-sm-3 col-lg-2"><strong>GitHub</strong></label>
        <div class="col-sm-9 col-md-3">
          <a href="{{$user->github}}">{{$user->github}}</a>
        </div>
    </div>
  @endif
  @if($user->website)
    <div class="row">
        <label class="col-sm-3 col-lg-2"><strong>Website</strong></label>
        <div class="col-sm-9 col-md-3">
          <a href="{{$user->website}}">{{$user->website}}</a>
        </div>
    </div>
  @endif
  @if($user->stack_overflow)
    <div class="row">
        <label class="col-sm-3 col-lg-2"><strong>Stack Overflow</strong></label>
        <div class="col-sm-9 col-md-4">
          <a href="{{$user->stack_overflow}}">{{$user->stack_overflow}}</a>
        </div>
    </div>
  @endif
  @if($user->collaborations)
    <br>
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
