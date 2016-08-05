@extends('layout')

@section('content')

  {{-- @if(count($errors))
    <ul>
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  @endif --}}

  <form method="post" action="@yield('action')">
    @yield('method_type')

    {{ csrf_field() }}

    <div class="form-group">
      <label for="title">Title</label>
      <input name="title" class="form-control" id="title" placeholder="Project Title"
        value="{{ $project->title or '' }}">
    </div>
    <div class="form-group">
      <label for="short_description">Short Description</label>
      <textarea name="short_description" class="form-control" id="short_description"
        placeholder="Project Short Description">{{ $project->short_description or '' }}</textarea>
    </div>
    <div class="form-group">
      <label for="long_description">Long Description</label>
      <textarea name="long_description" class="form-control" id="long_description"
        placeholder="Project Long Description">{{ $project->long_description or '' }}</textarea>
    </div>

    <div class="form-group">
      <label for="github">GithHub</label>
      <input name="github" type="url" class="form-control" id="github"
        placeholder="GitHub Project URL" value="{{ $project->github or '' }}">
    </div>

    <div class="form-group">
      <label for="stack_overflow">Stack Overflow</label>
      <input name="stack_overflow" type="url" class="form-control" id="stack_overflow"
        placeholder="Stack Overflow URL" value="{{ $project->stack_overflow or '' }}">
    </div>

    <div class="form-group">
      <label for="general_skills">Skills</label>
      <ul name="general_skills[]">
        @foreach($general_skills as $skill)
          <li>
            {{$skill->name}}
              <input type="number" name="general_skills[{{$skill->id}}]"
              @if(isset($project))
                value="{{ $project->general_skill_count($skill)  }}"
              @endif
              placeholder="0">
          </li>
        @endforeach
      </ul>
    </div>

    <div class="form-group">
      <label for="languages">Languages</label>
      <select name="languages[]" class="selectpicker" multiple>
        @foreach($languages as $language)
          <option value="{{$language->id}}"
            @if(isset($project))
              {{ $project->languages->contains($language->id) ? "selected" : ""}}
            @endif
          >{{$language->name}}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-primary">
        @yield('button_name')
      </button>
    </div>
  </form>
@stop
