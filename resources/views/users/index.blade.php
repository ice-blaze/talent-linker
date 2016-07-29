@extends('layout')

@section('content')
    <div class="row">
        <h1>All talents</h1>
    </div>

    <div class="row">
        @foreach($users as $user)
            <div>
                <a href="{{ $user->path() }}">{{ $user->email}}</a>
            </div>
        @endforeach
    </div>
@endsection
