@extends('layouts.layout-noflash')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-centered">
                <div class="row">
                    {{ Trans('errors.oops_404_error') }}
                </div>
                <div class="row">
                    <a class="btn btn-primary" href="/">{{ Trans('errors.go_back') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
