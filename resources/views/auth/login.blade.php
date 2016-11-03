@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-md-8 offset-md-4 col-centered">
        <div class="panel panel-default">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} row">
                        {{-- <label for="email" class="col-md-4 control-label">E-Mail Address</label> --}}

                        <div class="col-md-6 offset-md-6">
                            <div class="panel-heading"><h2>Login</h2></div>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                            placeholder="Email">
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} row">
                        {{-- <label for="password" class="col-md-4 control-label">Password</label> --}}

                        <div class="col-md-6 offset-md-6">
                            <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-6">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> Remember Me
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-6">
                            <button type="submit" class="btn btn-primary" name="login">
                              Login
                            </button>

                            <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
