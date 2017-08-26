@extends('layouts.layout')

@section('content')
    <h1>{{ Trans('feedback.write_a_feedback') }}</h1>
    <form method="post" action="/feedbacks">
        {{ csrf_field() }}

        <div class="form-group">
            <textarea name="content" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" name="create_feedback">{{ Trans('feedback.create_feedback') }}</button>
        </div>
    </form>

    <h1>{{ Trans('feedback.your_feedbacks') }}</h1>
    @foreach($feedbacks as $feedback)
        <li class="list-group-item">{{ $feedback->content}}</li>
    @endforeach
@endsection
