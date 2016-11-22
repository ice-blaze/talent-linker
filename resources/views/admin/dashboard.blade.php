@extends('layouts.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Dashboard</div>

            <div class="panel-body">
                <div>
                    <p>Welcome {{{Auth::user()->name}}}</p>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-2">
                        <div class="card-container">
                            <div class="card-left">
                                <i class="fa fa-users" style="color:white;" aria-hidden="true"></i>
                            </div>
                            <div class="card-right">
                                {{ App\User::count() }} Users
                            </div>
                        </div>
                    </div>

                    

                    <div class="col-md-2">
                        <div class="card-container">
                            <div class="card-left">
                                <i class="fa fa-paint-brush" style="color:white;" aria-hidden="true"></i>
                            </div>
                            <div class="card-right">
                                {{ App\Project::count() }} Projects <br>
                                {{ App\ProjectComment::count() }} Comments
                            </div>
                        </div>
                    </div>

                     <div class="col-md-3">
                        <div class="card-container">
                            <div class="card-left">
                                <i class="fa fa-paint-brush" style="color:white;" aria-hidden="true"></i>
                            </div>
                            <div class="card-right">
                                {{ App\Feedback::count() }} Feedbacks
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card-container">
                            <div class="card-left">
                                <i class="fa fa-paint-brush" style="color:white;" aria-hidden="true"></i>
                            </div>
                            <div class="card-right">
                                {{ App\ChatUser::count() }} User chat messages
                            </div>
                        </div>
                    </div>  
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>
@endsection
