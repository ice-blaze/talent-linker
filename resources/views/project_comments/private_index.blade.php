@extends('layouts.layout')

@section('content')
    <div class="row">
        <h1>{{ Trans('project_comments.private_chat_of_project') }}: <a href="{{$project->path()}}">{{$project->name}}</a></h1>
    </div>
    <div class="row">

        {{-- use template ? --}}
        @foreach($project->privateComments as $comment)
            <li class="list-group-item">
                {{ $comment->content}}
                <div class="comment_user">
                    <a href="{{ $comment->user->path() }}">{{$comment->user->name}}</a> - {{$comment->date}}
                </div>
            </li>
        @endforeach

        <hr>
        <h3>{{ Trans('project_comments.add_a_comment') }}</h3>
        <form method="post" action="/projects/{{ $project->id }}/privateComments">
            {{ csrf_field() }}
            <div class="form-group">
                <textarea name="content" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="comment">{{ Trans('project_comments.comment') }}</button>
            </div>
        </form>
    </div>
@endsection
