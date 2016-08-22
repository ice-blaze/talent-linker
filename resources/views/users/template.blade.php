@extends('layout')

@section('content')
  <form method="post" action="@yield('action')">
    @yield('method_type')

    {{ csrf_field() }}

    {{-- <div class="form-group">
      <label for="name">Name</label>
      <input name="name" type="text" class="form-control" id="name" placeholder="User Name"
        value="{{ $user->name or '' }}">
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input name="email" type="email" class="form-control" id="email"
        placeholder="User Email" value="{{ $user->email or '' }}">
    </div> --}}

    <div class="form-group">
      <label for="last_name">Last Name</label>
      <input name="last_name" type="text" class="form-control" id="last_name"
        placeholder="User Last Name" value="{{ $user->last_name or old('last_name') }}">
    </div>

    <div class="form-group">
      <label for="first_name">First Name</label>
      <input name="first_name" type="text" class="form-control" id="first_name"
        placeholder="User First Name" value="{{ $user->first_name or old('first_name') }}">
    </div>

    <div class="form-group">
      <label for="talent_description">Talent Description</label>
      <textarea name="talent_description" type="text" class="form-control" id="talent_description"
        placeholder="User Talent Description">{{ $user->talent_description or old('talent_description') }}</textarea>
    </div>

    <div class="form-group">
      <label for="website">Website</label>
      <input name="website" type="url" class="form-control" id="website"
        placeholder="User Website" value="{{ $user->website or old('website') }}">
    </div>

    <div class="form-group">
      <label for="github">GitHub</label>
      <input name="github" type="url" class="form-control" id="github"
        placeholder="User GitHub Profile" value="{{ $user->github or old('github') }}">
    </div>

    <div class="form-group">
      <label for="stack_overflow">Stack Overflow</label>
      <input name="stack_overflow" type="url" class="form-control" id="stack_overflow"
        placeholder="User Stack Overflow Profile" value="{{ $user->stack_overflow or old('stack_overflow') }}">
    </div>

    <div class="form-group">
      <label for="general_skills">Skills</label>
      <select name="general_skills[]" class="selectpicker" multiple>
        @foreach($general_skills as $skill)
          <option value="{{$skill->id}}"
            {{ $user->general_skills->contains($skill->id) ? "selected" : ""}}
          >{{$skill->name}}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="languages">Languages</label>
      <select name="languages[]" class="selectpicker" multiple>
        @foreach($languages as $language)
          <option value="{{$language->id}}"
            {{ $user->languages->contains($language->id) ? "selected" : ""}}
          >{{$language->name}}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-primary"  name="submit_user">
        @yield('button_name')
      </button>
      <a class="btn btn-default" href="/talents/{{ $user->id }}">Cancel</a>
    </div>
  </form>
@endsection
