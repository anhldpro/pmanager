<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\TaskUser;
use App\User;
use App\Project;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user_id = Auth::user()->id;
        //$userTasks = TaskUser::where('user_id',$user_id)->get();
        $tasks = Task::where('user_id',$user_id)->get();

        return view('tasks.index', ['tasks'=> $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $projects = Project::all();
        return view('tasks.create',['projects'=>$projects]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $user_id = Auth::user()->id;
        $project_id = $request->input('project_id');
        $days = $request->input('days');
        $hours = $request->input('hours');
        $name = $request->input('name');

        $project = Project::find($project_id);
        

        if($project){
            $company = $project->company;
            $company_id = $company->id;

            $task = Task::create([
                'name'=> $name,
                'project_id'=>$project_id,
                'user_id'=>$user_id,
                'company_id'=>$company_id,
                'days'=>$days,
                'hours'=>$hours
            ]);

            if($task){
                return redirect()->route('tasks.show', ['task_id'=>$task->id])->with('success', 'Task has been created successfully!');
            }
        }

        return back()->withInput()->with('errors', 'Task could not be created!');
        


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
        $task = Task::find($task->id);

        $comments = $task->comments;

        return view('tasks.show', ['task'=>$task, 'comments'=>$comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
        $task = Task::find($task->id);
        $projects = Project::all();
        return view('tasks.edit',['task'=>$task, 'projects'=>$projects]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
        $user_id = Auth::user()->id;
        $project_id = $request->input('project_id');
        $days = $request->input('days');
        $hours = $request->input('hours');
        $name = $request->input('name');

        $project = Project::find($project_id);

        $task = Task::find($task->id);
        $task->name = $name;
        $task->project_id = $project_id;
        $task->company_id = $project->company->id;
        $task->days = $days;
        $task->hours = $hours;
        $result = $task->update();

        if($result){
            return redirect()->route('tasks.show', ['task_id'=>$task->id])->with('success', 'Task has been updated successfully!');
        }

        return back()->withInput()->with('errors', 'Could not be updated task!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
        $task = Task::find($task->id);
        if($task->delete()){
            return redirect()->route('tasks.index')->with('success', 'Task has been deleted successfully!');
        }
        return back()->withInput()->with('errors', 'Task could not be deleted!');
    }

    public function adduser(Request $request){
        $error = 0;
        $task_id = $request->input('task_id');
        $email = $request->input('email');

        $user = User::where('email', $email)->first();
        $task = Task::find($task_id);

        if($user && (Auth::user()->id == $task->user_id)){
            $error = 1;
            //check if task is already assign to user
            $userTask = TaskUser::where('user_id', $user->id)->where('task_id', $task_id)->first();
            if($userTask){
                return back()->withInput()->with('errors', 'Task already assign to user'); 
            }
            $error = 2;

            if($user&&$task){
                $error = 3;
                $task->users()->attach($user->id);
                return redirect()->route('tasks.show', ['task_id'=>$task_id])->with('success', 'Task assign to user successfully!');
            }
        }

        return back()->withInput()->with('errors', 'Error assign task to user ' . $error);
    }
}
