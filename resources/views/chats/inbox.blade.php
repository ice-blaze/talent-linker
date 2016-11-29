@extends('layouts.layout')

@section('content')

    <div class="row">
        <h1>{{ Trans('chat.title_inbox') }}</h1>
    </div>

    <div class="row">
        @forelse($ids as $id)
            @include('helpers/conversation', [
                'user' => \App\User::find($id),
            ])
        @empty
            <div class="lead col-sm-12">
                {{ Trans('chat.no_conversation') }}
            </div>
        @endforelse
    </div>

@endsection