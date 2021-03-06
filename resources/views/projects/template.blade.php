@extends('layouts.layout-noflash')

@section('content')
    <form method="post" action="@yield('action')">
        @yield('method_type')

        {{ csrf_field() }}

        @yield('owner_skill')

        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
            <label for="name">{{ Trans('projects.title') }}</label>
            <input name="name" class="form-control{{ $errors->has('name') ? ' form-control-danger' : '' }}" id="name" placeholder="Project Title"
            value="{{ $project->name or old('name') }}">

            @if ($errors->has('name'))
                <span class="help-block form-control-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('short_description') ? ' has-danger' : '' }}">
            <label for="short_description">{{ Trans('projects.short_description') }}</label>
            <textarea name="short_description" class="form-control{{ $errors->has('short_description') ? ' form-control-danger' : '' }}" id="short_description" placeholder="Project Short Description">{{ $project->short_description or old('short_description') }}</textarea>

            @if ($errors->has('short_description'))
                <span class="help-block form-control-feedback">
                    <strong>{{ $errors->first('short_description') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('long_description') ? ' has-danger' : '' }}">
            <label for="long_description">{{ Trans('projects.long_description') }}</label>
            <div class="form-control{{ $errors->has('long_description') ? ' form-control-danger' : '' }}">
                @php ($description = old('long_description'))
                @if (isset($project))
                    @php ($description = $project->long_description)
                @endif
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
                <label for="image">{{ Trans('projects.image') }}</label>
                <input name="image" type="url" class="form-control{{ $errors->has('image') ? ' form-control-danger' : '' }}" id="image"
                placeholder="Image URL" value="{{ $project->image or old('image') }}">

                @if ($errors->has('image'))
                    <span class="help-block form-control-feedback">
                        <strong>{{ $errors->first('image') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('github_link') ? ' has-danger' : '' }}">
                <label for="github_link">GitHub</label>
                <input name="github_link" type="url" class="form-control{{ $errors->has('github_link') ? ' form-control-danger' : '' }}" id="github_link"
                placeholder="GitHub Project URL" value="{{ $project->github_link or old('github_link') }}">

                @if ($errors->has('github_link'))
                    <span class="help-block form-control-feedback">
                        <strong>{{ $errors->first('github_link') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('website_link') ? ' has-danger' : '' }}">
                <label for="website_link">{{ Trans('projects.website') }}</label>
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
                <label for="general_skills">{{ Trans('projects.skills') }}</label>
                <ul name="general_skills[]" id="general_skills" >

                    @php ($skills_array = collect(array_pluck($general_skills->toArray(), 'pivot.count', 'id')))

                    @foreach(App\GeneralSkill::all() as $option)
                    @if (count(collect(old('general_skills'))) > 0)
                        <li>
                            {{$option->name}}
                            <input type="number" name="general_skills[{{ $option->id }}]" value="{{ (collect(old('general_skills'))->count() > 0) ? intval(collect(old('general_skills'))->toArray()[$option->id]):0}}" placeholder="0" min="0" step="1">
                        </li>
                    @else
                        <li>
                            {{$option->name}}
                            <input type="number" name="general_skills[{{ $option->id }}]" value="{{ ($skills_array->keys()->contains($option->id)) ? intval($skills_array[$option->id]):0}}" placeholder="0" min="0" step="1">
                        </li>
                    @endif
                    @endforeach

                </ul>
            </div>
            <div class="form-group{{ $errors->has('languages') ? ' has-danger' : '' }}">
                <label for="languages">{{ Trans('projects.languages') }}</label>
                <select name="languages[]" id="languages" class="selectpicker {{ $errors->has('name') ? ' form-control-danger' : '' }}" multiple>

                    @foreach(App\Language::all() as $option)
                        @if (count(collect(old('languages'))) > 0)
                            <option value="{{ $option->id }}" {{ (collect(old('languages'))->contains($option->id)) ? 'selected':'' }}>{{ $option->name }}</option>
                        @else
                            <option value="{{ $option->id }}"
                                @if (isset($project))
                                    {{ ($project->languages->contains($option->id)) ? 'selected':'' }}
                                @endif
                            >{{ $option->name }}</option>
                        @endif
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