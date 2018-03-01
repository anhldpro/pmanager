@extends('layouts.app')

@section('content')
<div class="col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">
<div class="panel panel-primary">
  <div class="panel-heading">Tasks<a class="pull-right btn btn-primary btn-sm" href="/tasks/create">
    <i class="fa fa-plus-square"> </i> Create New</a></div>
  <div class="panel-body">
    <div class="table-container">
        <table class="table table-filter">
            <tbody>
                @foreach($tasks as $task)
                <tr data-status="pagado">
                    <td>
                        <div class="ckbox">
                            <input type="checkbox" id="checkbox1">
                            <label for="checkbox1"></label>
                        </div>
                    </td>
                    <td>
                        <div class="media">
                            <div class="media-body">
                                <span class="media-meta pull-right">{{$task->days}}D - {{$task->hours}}H</span>
                                <h4 class="title">
                                    <span class="pull-right pagado">({{$task->project->name}})</span>
                                </h4>
                                <p class="summary"><a href="/tasks/{{$task->id}}">{{$task->name}}</a></p>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  </div>
</div>
</div>
@endsection
