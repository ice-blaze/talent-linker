@extends('layouts.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <h1>Dashboard</h1>
            <hr>
            <div class="card-deck-wrapper">
                <div class="card-deck">

                    <div class="card">
                        <div class="card-header">
                            Users
                        </div>
                        <div class="card-block">
                            {{ App\User::count() }} Users <br>
                            {{ number_format(App\ProjectCollaborator::count() / App\Project::count(), 2, '.', '') }} per project
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            Projects
                        </div>
                        <div class="card-block">
                            {{ App\Project::count() }} Projects <br>
                            {{ App\ProjectComment::count() }} Comments
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            Feedbacks
                        </div>
                        <div class="card-block">
                            {{ App\Feedback::count() }} Feedbacks
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            Chat
                        </div>
                        <div class="card-block">
                            {{ App\ChatUser::count() }} User chat messages <br>
                            {{ number_format(App\ProjectCollaborator::count() / App\ChatUser::count(), 2, '.', '') }} per project
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
