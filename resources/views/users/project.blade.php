@extends('layouts.layout')

@section('content')

    @if($user->collaborations)
        <div class="col-md-12">

            @if (count($user->collaborations) > 0)
                <div class="row">
                    <label><strong>{{(count($user->collaborations) > 1)?"Projects":"Project"}}</strong></label>
                </div>
            @endif

            <div class="row">
                @forelse ($user->collaborations as $collaboration)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-xs-12">
                        <div class="media card card-outline-primary ">
                            <a class="media-left" href="{{$collaboration->project->path()}}">
                                <img class="media-object image-64"
                                    @if($collaboration->project->image)
                                        src="{{$collaboration->project->image}}"
                                    @else
                                        src="{{asset('assets/images/default_project.png')}}"
                                    @endif
                                    alt="Project Image {{$collaboration->project->name}}">
                            </a>
                            <div class="media-body">
                                <a href="{{$collaboration->project->path()}}">
                                    <h4 class="media-heading">{{$collaboration->project->name}}</h4>
                                </a>
                                <span class="tag tag-primary">{{$collaboration->skill->name}}</span>
                                @if($collaboration->is_project_owner)
                                    <span class="tag tag-pill tag-danger">Owner</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="row">
                        <div class="col-md-12 col-centered">
                            <h2>No Projects...</h2>
                        </div>
                    </div>
                    <div class="row">
                        <p class="col-centered">Do you want to <a href="{{"/projects/create"}}">create a project</a> or <a href="{{"/projects"}}">join a project</a> ?</p>
                    </div>
                @endforelse
            </div>
        </div>
    @endif

@endsection
