<div class="media card @if(\App\ChatUser::hasPendingMessage($user->id)) pending-message @endif">
    <form method="post" action="/chat/{{ $user->id }}">
        {{ method_field('delete') }}
        {{ csrf_field() }}

        <input type="hidden" value="{{$user->id}}" name="id">

        <button name="delete_conv" class="btn-delete-conv" type="submit">Delete</button>
    </form>
    <a class="media-left" href="{{url($user->path().'/chat')}}">
        <img class="media-object image-64"
             src="{{asset('assets/images/default_profile.png')}}"
             alt="User comment profile image">
    </a>
    <div class="media-body">
        <div class="media-heading">
            <a href="{{url($user->path().'/chat')}}"> <span class="h4">{{$user->name}} </span></a>
            <span class="text-muted"> - Last message: {{\App\ChatUser::lastCommunicationDate(Auth::user()->id, $user->id)}} </span>
        </div>
    </div>
</div>
