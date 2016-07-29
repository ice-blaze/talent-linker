@extends('layout')

@section('content')
  <div class="row">
    Oops... 404 Error...
    <a class="btn btn-primary" href="{{ URL::previous() }}">Go Back</a>
  </div>
@endsection
