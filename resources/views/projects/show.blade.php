@extends('layouts.layout')

@section('content')

    <div class="row text-right col-centered">
        @if( Auth::user() && ($project->isUserTheOwner(Auth::user()) || $project->isUserACollaborator(Auth::user())))
            <a class="btn btn-primary" href="/projects/{{ $project->id }}/invitations">{{ Trans('projects.see_pendings') }}</a>
            <a class="btn btn-primary" href="/projects/{{ $project->id }}/privateComments">{{ Trans('projects.private_chat') }}</a>
        @endif

        @if(Auth::user() && $project->isUserTheOwner(Auth::user()))
            <a class="btn btn-primary" href="/projects/{{ $project->id }}/edit">Edit</a>

            <form id="delete_form" method="post" action="/projects/{{ $project->id }}">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <div class="form-group">
                    <button type="submit" class="btn btn-danger" name="delete">{{ Trans('projects.delete') }}</button>
                </div>
            </form>
        @endif

        @if( Auth::user() && $project->isPendingUser(Auth::user()))
            <div class="btn btn-default disabled">
                {{ Trans('projects.invitation_is_pending') }}...
            </div>
        @endif

        @if( Auth::user() && !$project->isPendingUser(Auth::user()) && !($project->isUserTheOwner(Auth::user()) || $project->isUserACollaborator(Auth::user())))
            <form method="get" action="/projects/{{ $project->id }}/join">
                {{ csrf_field() }}
                <div class="form-group">
                    <button type="submit" class="btn btn-primary"  name="join_project">{{ Trans('projects.join_the_project') }}</button>
                </div>
            </form>
        @endif
    </div>

    <div class="row col-centered">
        <div class="col-md-12">
            <h1>{{$project->name}}</h1>
            @if (Auth::user())
                @if ($project->isInSearchDistance(Auth::user()))
                    <span class="tag tag-pill tag-primary"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ Trans('projects.near_you') }}</span>
                @else
                    <span class="tag tag-pill tag-danger"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ Trans('projects.not_near') }}</span>
                @endif
            @endif
        </div>
    </div>

    <br>
    <div class="row col-centered">
        <div class="col-md-12">
            <img class="image-256 img-rounded"
                @if($project->image)
                    src="{{$project->image}}"
                @else
                    src="{{asset('assets/images/default_project.png')}}"
                @endif
                alt="Project {{$project->name}} Image" />
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
            @foreach($project->currentSkillAndWanted() as $skill)
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
        <label class="col-sm-12"><strong>{{ Trans('projects.collaborators') }}</strong></label>
        @foreach($project->collaborators as $collaborator)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="media card card-outline-primary ">
                    <a class="media-left" href="{{$collaborator->user->path()}}">
                        <img class="media-object img-circle image-64"
                            @if($collaborator->user->image)
                               src="{{$collaborator->user->image}}"
                            @else
                                src="{{asset('assets/images/default_profile.png')}}"
                            @endif
                            alt="{{$collaborator->user->name}} profile image">
                    </a>
                    <div class="media-body">
                        <a href="{{$collaborator->user->path()}}"><h4 class="media-heading">{{$collaborator->user->name}}</h4></a>
                        <span class="tag tag-primary">{{$collaborator->skill->name}}</span>
                        @if($collaborator->is_project_owner)
                            <span class="tag tag-pill tag-danger">{{ Trans('projects.owner') }}</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <br>
    <div class="row">
        <label class="col-sm-2"><strong>{{ Trans('projects.languages') }}</strong></label>
        <div class="col-sm-10">
            @foreach($project->languages as $language)
                <span class="tag tag-pill tag-primary">
                    {{$language->name}}
                </span>
            @endforeach
        </div>
    </div>

    <div class="row">
        <label class="col-sm-12"><strong>{{ Trans('projects.place') }}</strong></label>
        <div class="col-sm-12">
            @include('helpers.gmap', [
                "class" => "gm-show",
                "lat" => $project->owner->user->lat,
                "lng" => $project->owner->user->lng,
                "find_distance" => $project->owner->user->find_distance,
                'edit' => 0,
            ])
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
        @if($project->website_link)
            <label class="col-sm-2"><strong>{{ Trans('projects.website') }}</strong></label>
            <div class="col-sm-10 col-md-4">
                <a href="{{$project->website_link}}">{{$project->website_link}}</a>
            </div>
        @endif
    </div>

    <div class="row">
        <label class="col-sm-12"><strong>{{ Trans('projects.comments') }}</strong></label>

        @forelse($project->comments as $comment)
            @include('helpers/user_comment', [
                'comment' => $comment,
            ])

        @empty
            <div class="lead col-sm-12">
                {{ Trans('projects.no_comments') }}...
            </div>
        @endforelse

        @if(Auth::user())
            <hr>
            <h3>{{ Trans('projects.add_a_comment') }}</h3>
            <form method="post" action="/projects/{{ $project->id }}/comments">
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea name="content" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="comment">{{ Trans('projects.comment') }}</button>
                </div>
            </form>
        @endif
    </div>

@stop
