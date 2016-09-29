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

    {{old('languages[]')}}

    @yield('owner_skill')

    <div class="form-group">
      <label for="title">Title</label>
      <input name="title" class="form-control" id="title" placeholder="Project Title"
        value="{{ $project->title or old('title') }}">
    </div>
    <div class="form-group">
      <label for="short_description">Short Description</label>
      <textarea name="short_description" class="form-control" id="short_description"
        placeholder="Project Short Description">{{ $project->short_description or old('short_description') }}</textarea>
    </div>
    <div class="form-group">
      <label for="long_description">Long Description</label>
      {{-- could be simplified I guess --}}
      {{ $description = old('long_description') }}
      @if (isset($project)) {{$description = $project->long_description}} @endif
      @include('helpers/ckeditor', [
        'name' => "long_description",
        'content' => $description,
        'placeholder' => "Project Long Description",
      ])
    </div>

    <div class="form-group">
      <label for="image">Image</label>
      <input name="image" type="url" class="form-control" id="image"
        placeholder="Image URL" value="{{ $project->image or old('image') }}">
    </div>

    <div class="form-group">
      <label for="github_link">GithHub</label>
      <input name="github_link" type="url" class="form-control" id="github_link"
        placeholder="GitHub Project URL" value="{{ $project->github_link or old('github_link') }}">
    </div>

    <div class="form-group">
      <label for="website_link">Website</label>
      <input name="website_link" type="url" class="form-control" id="website_link"
        placeholder="Stack Overflow URL" value="{{ $project->website_link or old('website_link') }}">
    </div>

    @yield('collaborators')

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
      <button type="submit" class="btn btn-primary" name="submit_project">
        @yield('button_name')
      </button>
    </div>
  </form>
@stop
