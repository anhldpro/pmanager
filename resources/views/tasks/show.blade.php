@extends('layouts.app')

@section('content')
<div class="row col-md-9 col-lg-9 col-sm-9 pull-left">
    <div class="well well-lg">
        <p>Task name: {{$task->name}}</p><br/>
        <p>Project: {{$task->project->name}}</p><br/>
        <p>Days: {{$task->days}} days</p><br/>
        <p>Hours: {{$task->hours}} hours</p><br/>
    </div>

    <div class="row col-md-12 col-lg-12 col-sm-12" style="background: white; margin:10px">
        @include('partials.comments')

        <div class="row container-fluid">
          <form method="POST" action="{{route('comments.store')}}">
            {{csrf_field()}}
            <input type="hidden" name="commentable_type" value="App\Task"/>
            <input type="hidden" name="commentable_id" value="{{$task->id}}"/>

            <div class="form-group">
              <label for="comment-body">Comment</label>
              <textarea placeholder="Enter comment"
                        style="resize:vertical"
                        id="comment-body"
                        name="body"
                        rows="3" spellcheck="false"
                        class="form-control autosize-target text-left">
              </textarea>
            </div>

            <div class="form-group">
              <label for="comment-url">Proof of work done (Url/Photos)</label>
              <textarea placeholder="Enter url or screenshots"
                        style="resize: vertical"
                        id="comment-url"
                        name="url"
                        rows="3" spellcheck="false"
                        class="form-control autosize-target text-left">
              </textarea>                      
            </div>

            <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Submit"/>
            </div>
          </form>
        </div>
    </div>
</div>

<div class="col-md-3 col-lg-3 col-sm-3 pull-right">
    <div class="sidebar-module">
        <h4>Actions</h4>
        <ol class="list-unstyled">
            <li>
                <a href="/tasks/{{$task->id}}/edit">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit
                </a>
            </li>
            <li>
                <a href="/tasks/create">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>Create new task
                </a>
            </li>
            <li>
                <a href="/tasks/">
                    <i class="fa fa-user-o" aria-hidden="true"></i>My Tasks
                </a>
            </li>
            <li>
                <a href="#" id="deleteTask">
                    <i class="fa fa-power-off" aria-hidden="true"></i>Delete
                </a>
                <form id="delete-form" method="POST" action="{{route('tasks.destroy', [$task->id])}}" style="display: none">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="delete" />
                </form>
            </li>
        </ol>
    </div>

    <hr/>

    <h4>Assign to</h4>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <form method="POST" action="{{ route('tasks.adduser')}}">
                {{csrf_field()}}

                <input type="hidden" name="task_id" value="{{$task->id}}" />
                <div class="input-group">
                    <input type="text" name="email" class="form-control" placeholder="Email" />
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit" id="adduser">Assign!</button>
                    </span>
                </div>
            </form>
        </div>
    </div>

    <hr/>
    <h4>Assign members</h4>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <ol class="list-unstyled" id="member-list">
                @foreach($task->users as $user)
                <li><a href="#">{{$user->email}}</a></li>
                @endforeach
            </ol>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    $("#deleteTask").on('click', function(e){
        var result = confirm('Are you sure you wish to delete the task');
        if(result){
            e.preventDefault();
            $("#delete-form").submit();
        }
    });
</script>
@endsection