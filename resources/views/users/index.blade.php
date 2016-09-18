@extends('layout')

@section('content')

    <div class="row">
      <div class="col-md-8 offset-md-2 col-sm-12">
        <form method="post" action="/talents">
          {{ csrf_field() }}
          <div class="form-group">
            <div class="input-group">
              <input name="search" placeholder="Search Talent" class="form-control"
              value="{{ old('search') }}"/>
            </div>
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

    <br>

    <div class="card-deck-wrapper">
      @foreach(array_chunk($users->all(), 3) as $threeUsers)
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
                @forelse($user->general_skills as $skill)
                  <span class="tag tag-primary">{{$skill->name}}</span>
                @empty
                  No Skills
                @endforelse
              </div>
            </div>
          @endforeach
        </div>
      @endforeach
    </div>

@endsection
