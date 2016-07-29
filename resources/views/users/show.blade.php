@extends('layout')

@section('content')
    <div class="row">
        {{$user->name}}
    </div>
    <div class="row">
        {{$user->email}}
    </div>
    <div class="row">
        <a class="btn btn-primary" href="/talents/{{ $user->id }}/edit">Edit</a>
    </div>

@endsection
