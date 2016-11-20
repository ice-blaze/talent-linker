<div class="media card">
    <a class="media-left" href="{{$comment->user->path()}}">
        <img class="media-object image-64"
            src="{{asset('assets/images/default_profile.png')}}"
            alt="User comment profile image">
    </a>
    <div class="media-body">
        <div class="media-heading">
            <a href="{{$comment->user->path()}}"> <span class="h4">{{$comment->user->name}} </span></a>
            <span class="text-muted"> -  {{$comment->created_at->diffForHumans()}} </span>
            @if(Auth::user() && Auth::user()->id == $comment->user->id)
                <a name="comment_edit{{$comment->id}}" href="{{$comment->path()}}">Edit</a>
            @endif
        </div>
        {{$comment->content}}
    </div>
</div>
