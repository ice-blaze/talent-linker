@extends('layout')

@section('content')

  <div class="row text-right col-centered">
    @if( Auth::user() && ($project->isUserTheOwner(Auth::user()) || $project->isUserACollaborator(Auth::user())))
      <a class="btn btn-primary" href="/projects/{{ $project->id }}/invitations">See pendings</a>
      <a class="btn btn-primary" href="/projects/{{ $project->id }}/private_comments">Private chat</a>
    @endif

    @if(Auth::user() && $project->isUserTheOwner(Auth::user()))
      <a class="btn btn-primary" href="/projects/{{ $project->id }}/edit">Edit</a>

      <form id="delete_form" method="post" action="/projects/{{ $project->id }}">
        {{ method_field('delete') }}
        {{ csrf_field() }}
        <div class="form-group">
          <button type="submit" class="btn btn-danger" name="delete">Delete</button>
        </div>
      </form>
    @endif

    @if( Auth::user() && $project->isPendingUser(Auth::user()))
      <div class="btn btn-default disabled">
        Invitation is pending...
      </div>
    @endif

    @if( Auth::user() && !$project->isPendingUser(Auth::user()) && !($project->isUserTheOwner(Auth::user()) || $project->isUserACollaborator(Auth::user())))
      <form method="get" action="/projects/{{ $project->id }}/join">
        {{ csrf_field() }}
        <div class="form-group">
          <button type="submit" class="btn btn-primary"  name="join_project">Join the project</button>
        </div>
      </form>
    @endif
  </div>

  <div class="row col-centered">
    <div class="col-md-12">
      <h1>{{$project->title}}</h1>
    </div>
  </div>

  <div class="row col-centered">
    <div class="col-md-12">
      <img class="image-256 img-rounded"
      @if($project->image)
        src="{{$project->image}}"
      @else
        src="{{asset('assets/images/default_project.png')}}"
      @endif
      alt="Project {{$project->title}} Image" />
    </div>
  </div>

  <br>
  <div class="row">
    <div class="col-sm-12 lead col-centered">
      {{$project->short_description}}
    </div>
  </div>

  <br>
  <div class="row">
    <div class="col-sm-12 lead col-centered">
      @foreach($project->current_skill_and_wanted() as $skill)
        @if($skill['wanted'] > 0 && $skill['have'] >= $skill['wanted'])
          <span class="tag tag-primary">
        @else
          <span class="tag tag-default">
        @endif
          {{$skill['skill']->name}} {{$skill['have']}} / {{$skill['wanted']}}
        </span>
      @endforeach
    </div>
  </div>
  <br>

  <div class="row">
    <div class="col-sm-12">
      {!! $project->long_description !!}
    </div>
  </div>

  <br>
  <div class="row">
    <label class="col-sm-12"><strong>Collaborators</strong></label>
      @foreach($project->collaborators as $collaborator)
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
          <div class="media card card-outline-primary ">
            <a class="media-left" href="{{$collaborator->user->path()}}">
              <img class="media-object img-circle image-64"
                src="{{$collaborator->user->image}}"
                alt="{{$collaborator->user->name}} profile image">
            </a>
            <div class="media-body">
              <a href="{{$collaborator->user->path()}}"><h4 class="media-heading">{{$collaborator->user->name}}</h4></a>
              <span class="tag tag-primary">{{$collaborator->skill->name}}</span>
              @if($collaborator->is_project_owner)
                <span class="tag tag-pill tag-danger">Owner</span>
              @endif
            </div>
          </div>
        </div>
      @endforeach
  </div>

  <br>
  <div class="row">
    <label class="col-sm-2"><strong>Languages</strong></label>
    <div class="col-sm-10">
      @foreach($project->languages as $language)
        <span class="tag tag-pill tag-primary">
          {{$language->name}}
        </span>
      @endforeach
    </div>
  </div>

  <br>
  <div class="row">
    @if($project->github_link)
      <label class="col-sm-2"><strong>GitHub</strong></label>
      <div class="col-sm-10 col-md-4">
        <a href="{{$project->github_link}}">{{$project->github_link}}</a>
      </div>
    @endif
    @if($project->siteweb_link)
      <label class="col-sm-2"><strong>Website</strong></label>
      <div class="col-sm-10 col-md-4">
        <a href="{{$project->siteweb_link}}">{{$project->siteweb_link}}</a>
      </div>
    @endif
  </div>

  <div class="row">
    @foreach($project->comments as $comment)
      @include('helpers/user_comment', [
        'comment' => $comment,
      ])
    @endforeach

    @if(Auth::user())
      <hr>
      <h3>Add a comment</h3>
      <form method="post" action="/projects/{{ $project->id }}/comments">
        {{ csrf_field() }}
        <div class="form-group">
          <textarea name="content" class="form-control"></textarea>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary" name="comment">Comment</button>
        </div>
      </form>
    @endif
  </div>


@stop
