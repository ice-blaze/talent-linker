@extends('layouts.layout')

@section('content')
    <h1>Edit the {{$object}}</h1>
    <form method="post" action="/{{$route}}/{{ $item->id }}">
        {{ method_field('patch') }}
        {{ csrf_field() }}

        <div class="form-group">
            <textarea name="content" class="form-control">{{ $item->content }} </textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary"  name="update_comment">Update {{$object}}</button>
        </div>
    </form>
    <form method="post" action="{{url($routeToDelete)}}">
        {{ method_field('delete') }}
        {{ csrf_field() }}
        <button type="submit" class="btn btn-danger"  name="delete_comment">Delete</button>
    </form>
@endsection
