@extends('layouts.layout')

@section('content')

<form method="post" action="@yield('action')">
    @yield('method_type')

    {{ csrf_field() }}

    @yield('owner_skill')

    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
        <label for="name">Title</label>
        <input name="name" class="form-control{{ $errors->has('name') ? ' form-control-danger' : '' }}" id="name" placeholder="Project Title"
        value="{{ $project->name or old('name') }}">

        @if ($errors->has('name'))
        <span class="help-block form-control-feedback">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('short_description') ? ' has-danger' : '' }}">
        <label for="short_description">Short Description</label>
        <textarea name="short_description" class="form-control{{ $errors->has('short_description') ? ' form-control-danger' : '' }}" id="short_description" placeholder="Project Short Description">{{ $project->short_description or old('short_description') }}</textarea>

        @if ($errors->has('short_description'))
        <span class="help-block form-control-feedback">
            <strong>{{ $errors->first('short_description') }}</strong>
        </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('long_description') ? ' has-danger' : '' }}">
        <label for="long_description">Long Description</label>
        <div class="form-control{{ $errors->has('short_description') ? ' form-control-danger' : '' }}">
            {{-- could be simplified I guess --}}
            {{ $description = old('long_description') }}
            @if (isset($project)) {{$description = $project->long_description}} @endif
            @include('helpers/ckeditor', [
            'name' => "long_description",
            'content' => $description,
            'placeholder' => "Project Long Description",
            ])
        </div>
        @if ($errors->has('long_description'))
        <span class="help-block form-control-feedback">
            <strong>{{ $errors->first('long_description') }}</strong>
        </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('image') ? ' has-danger' : '' }}">
        <label for="image">Image</label>
        <input name="image" type="url" class="form-control{{ $errors->has('image') ? ' form-control-danger' : '' }}" id="image"
        placeholder="Image URL" value="{{ $project->image or old('image') }}">

        @if ($errors->has('image'))
        <span class="help-block form-control-feedback">
            <strong>{{ $errors->first('image') }}</strong>
        </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('github_link') ? ' has-danger' : '' }}">
        <label for="github_link">GithHub</label>
        <input name="github_link" type="url" class="form-control{{ $errors->has('github_link') ? ' form-control-danger' : '' }}" id="github_link"
        placeholder="GitHub Project URL" value="{{ $project->github_link or old('github_link') }}">

        @if ($errors->has('github_link'))
        <span class="help-block form-control-feedback">
            <strong>{{ $errors->first('github_link') }}</strong>
        </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('website_link') ? ' has-danger' : '' }}">
        <label for="website_link">Website</label>
        <input name="website_link" type="url" class="form-control{{ $errors->has('website_link') ? ' form-control-danger' : '' }}" id="website_link"
        placeholder="Stack Overflow URL" value="{{ $project->website_link or old('website_link') }}">

        @if ($errors->has('website_link'))
        <span class="help-block form-control-feedback">
            <strong>{{ $errors->first('website_link') }}</strong>
        </span>
        @endif
    </div>

    @yield('collaborators')

    <div class="form-group{{ $errors->has('general_skills') ? ' has-danger' : '' }}">
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

    <div class="form-group{{ $errors->has('languages') ? ' has-danger' : '' }}">
        <label for="languages">Languages</label>
        <select name="languages[]" class="selectpicker {{ $errors->has('name') ? ' form-control-danger' : '' }}" multiple>

            @foreach($languages as $language)
            <option value="{{$language->id}}"
                @if(isset($project))
                {{ $project->languages->contains($language->id) ? "selected" : ""}}
                @endif
                >{{$language->name}}</option>
                @endforeach
            </select>
            @if ($errors->has('languages'))
            <br>
            <span class="help-block form-control-feedback">
                <strong>{{ $errors->first('languages') }}</strong>
            </span>
            @endif
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary" name="submit_project">
            @yield('button_name')
        </button>
    </div>
</form>
@stop
