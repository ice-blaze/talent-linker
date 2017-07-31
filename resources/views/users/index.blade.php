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
                <button type="submit" class="hidden" name="search_button"/> {{-- tests can activate this form --}}
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
                                @if($user->isInSearchDistance(Auth::user()))
                                    <span class="tag tag-pill tag-primary"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ Trans('users.near_you') }}</span>
                                @else
                                    <span class="tag tag-pill tag-danger"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ Trans('users.not_near') }}</span>
                                @endif
                            @endif
                            <br>
                            @forelse($user->generalSkills as $skill)
                                <span class="tag tag-primary">{{$skill->name}}</span>
                            @empty
                                {{ Trans('users.no_skills') }}...
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
          <div class="row">
            <div class="col-md-12 col-centered">
              <h2>{{ Trans('users.no_talents') }}...</h2>
            </div>
          </div>
        @endforelse
    </div>

@endsection
