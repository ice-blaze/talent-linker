@extends('projects/template')

@section('method_type')
    {{ method_field('patch') }}
@endsection

@section('collaborators')
    <div class="form-group">
        <label for="collaborators">Collaborators</label>
        can only delete collaborators
        {{-- <select name="collaborators[]" class="selectpicker" multiple>
          @foreach($all_users as $user)
            <option value="{{$user->id}}"
              @if(isset($project))
                {{ $project->collaborators->contains('id', $user->id) ? "selected" : ""}}
              @endif
            >{{$user->name}}</option>
          @endforeach
        </select> --}}
    </div>
@endsection

@section('action')
    {{"/projects/" . $project->id}}
@endsection

@section('button_name')
    Edit project
@endsection
