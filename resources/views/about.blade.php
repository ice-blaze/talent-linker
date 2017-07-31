@extends('layouts.layout')

@section('content')
    <div class="row col-centered">
        <div class="col-md-6 offset-md-3">
            <img class="img-rounded" src="http://i.imgur.com/zsgGGvE.jpg?1" alt="About Pic Thanks" />
            <br><br>
            <hr>
            <h1 class="display-4">{{ Trans('views.developped_by') }}</h1>
            <span class="lead">Etienne Frank</span><br>
            <span class="lead">Michael Caraccio</span><br>
            <hr>
            <h1 class="display-4">{{ Trans('views.feedback_tests') }}</h1>
            ...
        </div>
    </div>
@endsection
