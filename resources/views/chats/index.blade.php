@extends('layouts.layout')

@section('content')

    <div class="row">
        <h1>{{ Trans('chat.chat_with') }} <a href="{{ $reciever->path() }}">{{ $reciever->name }}</a></h1>
    </div>

    <div class="row">
        @forelse($chats as $chat)
            <li class="list-group-item">
                @if($chat->isEditable($chat->sender_id))
                    <div class="delete-message">
                        <form name="delete_message_form" id="form-delete-{{$chat->id}}" method="post" action="/chat/{{$chat->id}}/delete">
                            {{ method_field('delete') }}
                            {{ csrf_field() }}

                            <button type="submit" name="delete_message" id="delete_message">x</button>
                        </form>
                    </div>
                @endif
                {{ $chat->content}}
                <div class="comment_user text-muted">
                    @if($chat->seen)
                        {{ Trans('chat.seen') }}
                    @else
                        {{ Trans('chat.unseen') }}
                    @endif
                </div>
                @if($chat->isEditable($chat->sender_id))
                    <div>
                        <a name="message_edit{{$chat->id}}" href="/chat/{{$chat->id}}/edit">{{ Trans('chat.edit') }}</a>
                    </div>
                @endif
            </li>
        @empty
            {{ Trans('chat.start_conversation') }}
        @endforelse
        <hr>

        <h3>{{ Trans('chat.new_message') }}</h3>
        <form method="post" action="/talents/{{ $reciever->id }}/chat">
            {{ csrf_field() }}
            <div class="form-group">
                <textarea name="content" id="chats-index-user-message" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" id="chats-index-message-send" disabled name="send">{{Trans('chat.send') }}</button>
            </div>
        </form>
    </div>

@endsection

<script type="text/javascript" src="{{ URL::asset('assets/js/chat.js') }}"></script>