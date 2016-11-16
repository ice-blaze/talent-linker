@extends('layouts.layout')

@section('content')
    <h1>Edit the message</h1>
    <form method="post" action="/chat/{{ $chat->id }}">
        {{ method_field('patch') }}
        {{ csrf_field() }}

        <div class="form-group">
            <textarea name="content" class="form-control">{{ $chat->content }} </textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary"  name="update_comment">Update message</button>
        </div>
    </form>
@endsection
