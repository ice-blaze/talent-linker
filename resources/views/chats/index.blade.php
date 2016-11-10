@extends('layouts.layout')

@section('content')

  <div class="row">
    <h1>Chat with <a href="{{ $reciever->path() }}">{{ $reciever->name }}</a></h1>
  </div>

  <div class="row">
    @forelse($chats as $chat)
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
    @empty
      Come on start the conversation !!
    @endforelse
    <hr>

    <h3>New message</h3>
    <form method="post" action="/talents/{{ $reciever->id }}/chat">
      {{ csrf_field() }}
      <div class="form-group">
        <textarea name="content" id="chats-index-user-message" class="form-control"></textarea>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary" id="chats-index-message-send" disabled name="send">Send</button>
      </div>
    </form>
  </div>

@endsection

<script type="text/javascript" src="{{ URL::asset('assets/js/chat.js') }}"></script>