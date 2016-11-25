@extends('layouts.layout')

@section('content')

    <div class="row">
        <h1>Inbox</h1>
    </div>

    <div class="row">
        @forelse($ids as $id)
            @include('helpers/conversation', [
                'user' => \App\User::find($id),
            ])
        @empty
            <div class="lead col-sm-12">
                No Conversations ...
            </div>
        @endforelse
    </div>

@endsection