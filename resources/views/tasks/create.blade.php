@extends('layouts.app')

@section('content')
<div class="row col-md-9 col-lg-9 col-sm-9 pull-left" style="background: white; margin:10px">
    <h1>Create new task</h1>
    <form method="POST" action="{{ route('tasks.store') }}">
        {{csrf_field()}}

        <div class="form-group">
            <label for="task-name">Task name<span class="required">*</span></label>
            <input placeholder="Enter name"
                    id="task-name"
                    required
                    name="name"
                    spellcheck="false"
                    class="form-control"/>
        </div>
        <div class="form-group">
            <label for="task-project">Project<span class="required">*</span></label>
            <select name="project_id" class="form-control">
                @foreach($projects as $project)
                <option value="{{$project->id}}">{{$project->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="task-day">Days</label>
            <input placeholder="Enter days"
                    id="task-day"
                    name="days"
                    spellcheck="false"
                    class="form-control"/>
        </div>
        <div class="form-group">
            <label for="task-hour">Hours</label>
            <input placeholder="Enter hours"
                    id="task-hour"
                    name="hours"
                    spellcheck="false"
                    class="form-control"/>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit"/>
        </div>

    </form>
</div>

<div class="row col-md-3 col-lg-3 col-sm-3 pull-right">
    <div class="sizebar-modle">
        <h4>Actions</h4>
        <ol class="list-unstyled">
            <li><i class="fa fa-user-o" aria-hidden="true"></i><a href="/tasks">My tasks</a></li>
        </ol>
    </div>
</div>


@endsection