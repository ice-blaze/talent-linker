@extends('layouts.layout')

@section('content')

    <div class="row">
      <div class="col-md-8 offset-md-2 col-sm-12">
        <form method="post" action="/talents">
          {{ csrf_field() }}
          <div class="form-group">
            <div class="input-group">
              <a onclick="$(this).closest('form').submit()" class="search-button input-group-addon">
                <i class="fa fa-search" aria-hidden="true"></i>
              </a>
              <input name="search" placeholder="Search Talent" class="form-control"
              value="{{ old('search') }}"/>
            </div>
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
      @forelse(array_chunk($users->all(), 3) as $threeUsers)
        <div class="card-deck">
          @foreach($threeUsers as $user)
            <div class="card">
              <a href="{{ $user->path() }}">
                <img class="img-fluid img-circle col-centered image-256"
                  @if($user->image)
                    src="{{$user->image}}"
                  @else
                    src="{{asset('assets/images/default_profile.png')}}"
                  @endif
                  alt="User profile">
              </a>
              <div class="card-block">
                <h4 class="card-title"><a href="{{ $user->path() }}">{{ $user->name }}</a></h4>
                @if (Auth::user())
                  @if($user->is_in_search_distance(Auth::user()))
                    <span class="tag tag-pill tag-primary"><i class="fa fa-map-marker" aria-hidden="true"></i> Near You</span>
                  @else
                    <span class="tag tag-pill tag-danger"><i class="fa fa-map-marker" aria-hidden="true"></i> Not Near</span>
                  @endif
                @endif
                <br>
                @forelse($user->general_skills as $skill)
                  <span class="tag tag-primary">{{$skill->name}}</span>
                @empty
                  No Skills...
                @endforelse
              </div>
            </div>
          @endforeach
        </div>
      @empty
        <div class="row">
          <div class="col-md-12 col-centered">
            <h2>No Talents...</h2>
          </div>
        </div>
      @endforelse
    </div>

@endsection
