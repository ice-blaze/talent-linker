@extends('layout')

@section('content')
    <div class="row">
        <h1>Chat with <a href="{{ $reciever->path() }}">{{ $reciever->name }}</a></h1>
    </div>

    <div class="row">
      @if(count($chats))
        @foreach($chats as $chat)
          <li class="list-group-item">
            {{ $chat->content}}
            <div class="comment_user text-muted">
              @if($chat->seen)
                seen
              @else
                unseen
              @endif
            </div>
          </li>
        @endforeach
      @else
        Come on start the conversation !!
      @endif
      <hr>

      <h3>New message</h3>
      <form method="post" action="/talents/{{ $reciever->id }}/chat">
        {{ csrf_field() }}
        <div class="form-group">
          <textarea name="content" class="form-control"></textarea>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary">Send</button>
        </div>
      </form>

@endsection
