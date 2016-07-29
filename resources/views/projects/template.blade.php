@extends('layout')

@section('content')

  <form method="post" action="@yield('action')">
    @yield('method_type')

    <div class="form-group">
      <label for="title">Title</label>
      <input name="title" class="form-control" id="title" placeholder="Project Title"
        value="@yield('title_content')">
    </div>
    <div class="form-group">
      <label for="short_description">Short Description</label>
      <textarea name="short_description" class="form-control" id="short_description"
        placeholder="Project Short Description">@yield('short_description')</textarea>
    </div>
    <div class="form-group">
      <label for="long_description">Long Description</label>
      <textarea name="long_description" class="form-control" id="long_description"
        placeholder="Project Long Description">@yield('long_description')</textarea>
    </div>

    <div class="form-group">
      <label for="github">GithHub</label>
      <textarea name="github" class="form-control" id="github"
        placeholder="GitHub Project">@yield('github')</textarea>
    </div>

    <div class="form-group">
      <label for="long_description">Long Description</label>
      <textarea name="long_description" class="form-control" id="long_description"
        placeholder="Project Long Description">@yield('long_description')</textarea>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-primary">
        @yield('button_name')
      </button>
    </div>
  </form>
@stop
