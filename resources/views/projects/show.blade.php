@extends('layout')

@section('content')
  <div class="row">
    <div class="col-md-10">
      <h1>{{$project->title}}</h1>
    </div>

    <div class="col-md-1">
      <a class="btn btn-primary" href="/projects/{{ $project->id }}/edit">Edit</a>
    </div>

    <div class="col-md-1">
      <form method="post" action="/projects/{{ $project->id }}">
        {{ method_field('delete') }}
        <div class="form-group">
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </form>
    </div>
  </div>

  <div class="row">
    <label class="col-sm-2 control-label">Short Description</label>
    <div class="col-sm-10">
      {{$project->short_description}}
    </div>
  </div>

  <div class="row">
    <label class="col-sm-2 control-label">Long Description</label>
    <div class="col-sm-10">
      {{$project->long_description}}
    </div>
  </div>

  <div class="row">
    <label class="col-sm-2 control-label">Languages</label>
    <div class="col-sm-10">
      @foreach($project->languages as $language)
        {{$language->name}},
      @endforeach
    </div>
  </div>

  <div class="row">
    <label class="col-sm-2 control-label">GitHub</label>
    <div class="col-sm-10">
      {{$project->github}}
    </div>
  </div>

  <div class="row">
    <label class="col-sm-2 control-label">Stack Overflow</label>
    <div class="col-sm-10">
      {{$project->stack_overflow}}
    </div>
  </div>

  <div class="row">
    <li class="list-group">
      @foreach($project->comments as $comment)
        <li class="list-group-item">{{ $comment->content}}</li>
      @endforeach
    </li>

    <hr>
    <h3>Add a comment</h3>
    <form method="post" action="/projects/{{ $project->id }}/comments">
      <div class="form-group">
        <textarea name="content" class="form-control"></textarea>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Comment</button>
      </div>
    </form>
  </div>


@stop
