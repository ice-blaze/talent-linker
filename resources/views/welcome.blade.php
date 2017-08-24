@extends('layouts.layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="jumbotron">
                <h1 class="display-3">{{ Trans('views.create_some_projects') }} !</h1>
                <p class="lead">
                    {{ Trans('views.index_welcome_message') }}
                </p>
                <hr class="m-y-2">
                <p class="lead">{{ Trans('views.you_have_two_choices') }}</p>
                <div class="row">
                    <div class="col-xs-6 col-centered">
                        <a class="btn btn-primary btn-lg" href="/projects" role="button">{{ Trans('views.find_projects') }}</a>
                    </div>
                    <div class="col-xs-6 col-centered">
                        <a class="btn btn-primary btn-lg" href="/talents" role="button">{{ Trans('views.find_talents') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
