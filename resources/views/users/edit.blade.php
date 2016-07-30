@extends('users/template')

@section('method_type')
  {{ method_field('patch') }}
@endsection

@section('action')
  {{"/talents/" . $user->id}}
@endsection

@section('button_name')
  Save User
@endsection
