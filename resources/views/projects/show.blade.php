@extends('layout')

@section('content')
  <h1>{{$project->title}}</h1>

  <a class="btn btn-primary" href="/projects/{{ $project->id }}/edit">Edit</a>
  <form method="post" action="/projects/{{ $project->id }}">
    {{ method_field('delete') }}
    <div class="form-group">
      <button type="submit" class="btn btn-danger">Delete</button>
    </div>
  </form>


  {{-- <div class="row">
    {{ $project->long_description}}
  </div> --}}
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
