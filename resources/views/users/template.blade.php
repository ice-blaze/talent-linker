@extends('layout')

@section('content')
    <form method="post" action="@yield('action')">
      @yield('method_type')

      <div class="form-group">
        <label for="name">Name</label>
        <input name="name" type="text" class="form-control" id="name" placeholder="User Name"
          value="@yield('name')">
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input name="email" type="email" class="form-control" id="email"
          placeholder="User Email" value="@yield('email')">
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary">
          @yield('button_name')
        </button>
      </div>
    </form>

@endsection
