@extends('layout')

@section('content')
  <h1>Edit the comment</h1>
  <form method="post" action="/comments/{{ $comment->id }}">
    {{ method_field('patch') }}
    {{ csrf_field() }}

    <div class="form-group">
      <textarea name="content" class="form-control">{{ $comment->content }}</textarea>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Update comment</button>
    </div>
  </form>
@endsection
