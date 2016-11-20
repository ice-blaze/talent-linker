@extends('layouts.layout-noflash')

@section('content')
    <form method="post" action="@yield('action')">
        @yield('method_type')

        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
            <label for="name">Name</label>
            <input name="name" type="text" class="form-control{{ $errors->has('name') ? ' form-control-danger' : '' }}" id="name" placeholder="User Name"
            value="{{ $user->name or '' }}">

            @if ($errors->has('name'))
                <span class="help-block form-control-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
            <label for="email">Email</label>
            <input name="email" type="email" class="form-control{{ $errors->has('email') ? ' form-control-danger' : '' }}" id="email"
            placeholder="User Email" value="{{ $user->email or '' }}">

            @if ($errors->has('email'))
                <span class="help-block form-control-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>


        <div class="form-group{{ $errors->has('last_name') ? ' has-danger' : '' }}">
            <label for="last_name">Last Name</label>
            <input name="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' form-control-danger' : '' }}" id="last_name"
            placeholder="User Last Name" value="{{ $user->last_name or old('last_name') }}">

            @if ($errors->has('last_name'))
                <span class="help-block form-control-feedback">
                    <strong>{{ $errors->first('last_name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('first_name') ? ' has-danger' : '' }}">
            <label for="first_name">First Name</label>
            <input name="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' form-control-danger' : '' }}" id="first_name"
            placeholder="User First Name" value="{{ $user->first_name or old('first_name') }}">

            @if ($errors->has('first_name'))
                <span class="help-block form-control-feedback">
                    <strong>{{ $errors->first('first_name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('talent_description') ? ' has-danger' : '' }}">
            <label for="talent_description">Talent Description</label>
            <div class="form-control{{ $errors->has('talent_description') ? ' form-control-danger' : '' }}">
                @include('helpers/ckeditor', [
                    'name' => "talent_description",
                    'content' => $user->talent_description,
                    'placeholder' => "User Talent Description",
                ])
            </div>
            @if ($errors->has('talent_description'))
                <span class="help-block form-control-feedback">
                    <strong>{{ $errors->first('talent_description') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('image') ? ' has-danger' : '' }}">
            <label for="image">Image</label>
            <input name="image" type="url" class="form-control{{ $errors->has('image') ? ' form-control-danger' : '' }}" id="image"
            placeholder="Image URL" value="{{ $user->image or old('image') }}">

            @if ($errors->has('image'))
                <span class="help-block form-control-feedback">
                    <strong>{{ $errors->first('image') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('website') ? ' has-danger' : '' }}">
            <label for="website">Website</label>
            <input name="website" type="url" class="form-control{{ $errors->has('website') ? ' form-control-danger' : '' }}" id="website"
            placeholder="User Website" value="{{ $user->website or old('website') }}">

            @if ($errors->has('website'))
                <span class="help-block form-control-feedback">
                    <strong>{{ $errors->first('website') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('github_link') ? ' has-danger' : '' }}">
            <label for="github_link">GitHub</label>
            <input name="github_link" type="url" class="form-control{{ $errors->has('github_link') ? ' form-control-danger' : '' }}" id="github_link"
            placeholder="User GitHub Profile" value="{{ $user->github_link or old('github_link') }}">

            @if ($errors->has('github_link'))
                <span class="help-block form-control-feedback">
                    <strong>{{ $errors->first('github_link') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('stack_overflow') ? ' has-danger' : '' }}">
            <label for="stack_overflow">Stack Overflow</label>
            <input name="stack_overflow" type="url" class="form-control{{ $errors->has('stack_overflow') ? ' form-control-danger' : '' }}" id="stack_overflow"
            placeholder="User Stack Overflow Profile" value="{{ $user->stack_overflow or old('stack_overflow') }}">

            @if ($errors->has('stack_overflow'))
                <span class="help-block form-control-feedback">
                    <strong>{{ $errors->first('stack_overflow') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('general_skills') ? ' has-danger' : '' }}">
            <label for="general_skills">Skills</label>
            <select name="general_skills[]" id="general_skills" class="selectpicker" multiple>

                @php ($skills_array = collect(array_pluck($general_skills->toArray(), 'pivot.count', 'id')))

                @foreach(App\GeneralSkill::all() as $option)
                    @if (count(collect(old('general_skills'))) > 0)
                        <option value="{{ $option->id }}" {{ (collect(old('general_skills'))->contains($option->id)) ? 'selected':'' }}>{{ $option->name }}</option>
                    @else
                        <option value="{{ $option->id }}" {{ ($general_skills->contains($option->id)) ? 'selected':'' }}>{{ $option->name }}</option>
                    @endif
                @endforeach

            </select>
            @if ($errors->has('general_skills'))
                <br>
                <span class="help-block form-control-feedback">
                    <strong>{{ $errors->first('general_skills') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('languages') ? ' has-danger' : '' }}">
            <label for="languages">Languages</label>
            <select name="languages[]" id="languages" class="selectpicker" multiple>
                @foreach(App\Language::all() as $option)
                    @if (count(collect(old('languages'))) > 0)
                        <option value="{{ $option->id }}" {{ (collect(old('languages'))->contains($option->id)) ? 'selected':'' }}>{{ $option->name }}</option>
                    @else
                        <option value="{{ $option->id }}" {{ ($languages->contains($option->id)) ? 'selected':'' }}>{{ $option->name }}</option>
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

        <div class="row">
            <label class="col-sm-12"><strong>Your Location</strong> (with the search area)</label>
            <div class="col-sm-12">
                @include('helpers.gmap', [
                    "class" => "gm-show",
                    "lat" => $user->lat,
                    "lng" => $user->lng,
                    "find_distance" => $user->find_distance,
                    'edit' => 1,
                ])
            </div>
            <div class="col-sm-12">
                <input type="text" hidden="true" id="lat" value="{{$user->lat}}" name="lat">
                <input type="text" hidden="true" id="lng" value="{{$user->lng}}" name="lng">
                Distance :
                <input type="number" class="form-control{{ $errors->has('name') ? ' form-control-danger' : '' }}" id="find_distance" value="{{$user->find_distance}}"
                name="find_distance" min="1" step="1" max="200"><br><br>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary"  name="submit_user">
                @yield('button_name')
            </button>
            <a class="btn btn-default" href="/talents/{{ $user->id }}">Cancel</a>
        </div>
    </form>
@endsection
