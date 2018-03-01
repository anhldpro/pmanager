@extends('layouts.app')

@section('content')
<div class="row col-md-9 col-lg-9 col-sm-9 pull-left" style="background: white; margin:10px;">
    <h1>Update task</h1>
    <form method="POST" action="{{ route('tasks.update', [$task->id]) }}">
        {{csrf_field()}}

        <input type="hidden" name="_method" value="put"/>

        <div class="form-group">
            <label for="task-name">Task name<span class="required">*</span></label>
            <input placeholder="Enter name"
                    id="task-name"
                    required
                    name="name"
                    spellcheck="false"
                    class="form-control"
                    value="{{$task->name}}"/>
        </div>
        <div class="form-group">
            <label for="task-project">Project<span class="required">*</span></label>
            <select name="project_id" class="form-control">
                @foreach($projects as $project)
                @if($task->project_id == $project->id)
                <option value="{{$project->id}}" selected="selected">{{$project->name}}</option>
                @else
                <option value="{{$project->id}}">{{$project->name}}</option>
                @endif
                
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="task-day">Days</label>
            <input placeholder="Enter days"
                    id="task-day"
                    name="days"
                    spellcheck="false"
                    class="form-control"
                    value="{{$task->days}}"/>
        </div>
        <div class="form-group">
            <label for="task-hour">Hours</label>
            <input placeholder="Enter hours"
                    id="task-hour"
                    name="hours"
                    spellcheck="false"
                    class="form-control"
                    value="{{$task->hours}}"/>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit"/>
        </div>

    </form>
</div>

<div class="row col-md-3 col-lg-3 col-sm-3 pull-right">
    <div class="sizebar-module">
        <h4>Actions</h4>
        <ol class="list-unstyled">
            <li><a href="/tasks/{{$task->id}}"><i  class="fa fa-tasks" aria-hidden="true"></i>View tasks</a></li>
            <li><a href="/tasks"><i  class="fa fa-tasks" aria-hidden="true"></i>All tasks</a></li>
        </ol>
    </div>
</div>


@endsection