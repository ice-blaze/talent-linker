@extends('layout')

@section('content')
  <h1>Write a feedback</h1>
  <form method="post" action="/feedbacks">
    {{ csrf_field() }}

    <div class="form-group">
      <textarea name="content" class="form-control"></textarea>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Create Feedback</button>
    </div>
  </form>

  <h1>Your feedbacks</h1>
  @foreach($feedbacks as $feedback)
    <li class="list-group-item">{{ $feedback->content}}</li>
  @endforeach
@endsection
