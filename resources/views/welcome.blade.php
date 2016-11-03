@extends('layouts.layout')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="jumbotron">
      <h1 class="display-3">Create some projects !</h1>
      <p class="lead">
        Welcome on XXXX, a web site that helps people to find other talents in the world or in their region for
        audio-visual-multimedia projects.
      </p>
      <hr class="m-y-2">
      <p class="lead">You have two choices</p>
      <div class="row">
        <div class="col-xs-6 col-centered">
          <a class="btn btn-primary btn-lg" href="/projects" role="button">Find projects</a>
        </div>
        <div class="col-xs-6 col-centered">
          <a class="btn btn-primary btn-lg" href="/talents" role="button">Find talents</a>
        </div>
      </div>
      </p>
    </div>
  </div>
</div>
@endsection
