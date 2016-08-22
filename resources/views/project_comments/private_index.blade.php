@extends('layout')

@section('content')
  <div class="row">
    <h1>Private chat of project: <a href="{{$project->path()}}">{{$project->title}}</a></h1>
  </div>
  <div class="row">

    {{-- use template ? --}}
    @foreach($project->private_comments as $comment)
      <li class="list-group-item">
        {{ $comment->content}}
        <div class="comment_user">
          <a href="{{ $comment->user->path() }}">{{$comment->user->name}}</a> - {{$comment->date}}
        </div>
      </li>
    @endforeach

    <hr>
    <h3>Add a comment</h3>
    <form method="post" action="/projects/{{ $project->id }}/private_comments">
      {{ csrf_field() }}
      <div class="form-group">
        <textarea name="content" class="form-control"></textarea>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary" name="comment">Comment</button>
      </div>
    </form>
  </div>
@endsection
