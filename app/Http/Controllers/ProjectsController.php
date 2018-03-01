<?php

namespace App\Http\Controllers;

use App\Project;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\ProjectUser;

class ProjectsController extends Controller
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
        $projects = Project::where('user_id', $user_id)->get();
        return view('projects.index', ['projects'=>$projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($company_id = null)
    {
        //
        $companies = null;
        if(!$company_id){
            $companies = Company::where('user_id', Auth::user()->id)->get();
        }

        return view('projects.create', ['company_id'=>$company_id, 'companies'=>$companies]);
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
        if(Auth::check()){
            $project = Project::create([
                'name' => $request->input('name'),
                'user_id' => Auth::user()->id,
                'company_id' => $request->input('company_id'),
                'description' => $request->input('description'),
                'days' => '10'
            ]);

            if ($project) {
                return redirect()->route('projects.show', ['project'=> $project->id])->with('success', 'Project created successfully!');
                //return redirect()->route('projects.index');
            }
        }
        

        return back()->withInput()->with('errors', 'Project could not be created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
        $project = Project::find($project->id);
        return view('projects.show', ['project'=>$project, 'comments'=>$project->comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
        $project = Project::find($project->id);

        return view('projects.edit', ['project'=>$project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
        $project = Project::find($project->id);

        $project->name = $request->input('name');
        $project->description = $request->input('description');

        if($project->update()){
            return redirect()->route('projects.show', ['project'=>$project->id])->with('success', 'Project has been updated successfully!');
        }

        return back()->withInput()->with('errors', 'Project could not be updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
        $project = Project::find($project->id);

        if($project->delete()){
            return redirect()->route('projects.index')->with('success', 'Project has been deleted successfully!');
        }

        return back()->withInput()->with('errors', 'Project could not be deleted!');
    }

    public function adduser(Request $request){
        //add user to projects 

        //take a project, add a user to it
        $project_id = $request->input('project_id');
        $email = $request->input('email');

        $project = Project::find($project_id);
        $user = User::where('email', $email)->first();

        if($user && (Auth::user()->id == $project->user_id)){

            //check if user is already added to the project
            $userProject = ProjectUser::where('user_id', $user->id)->where('project_id', $project->id)->first();

            //if user already exists, exit 
            if($userProject){
                return redirect()->route('projects.show', ['project_id'=>$project->id])->with('success', $user->email.' is already member of this project');
            }

            if($user && $project){
                $project->users()->attach($user->id);

                return redirect()->route('projects.show', ['project_id' => $project->id])->with('success', $user->email . ' was added to the project successfully'); 
            }
            //success
        }

        //errors
        return redirect()->route('projects.show', ['project_id'=>$project->id])->with('errors', 'Error adding user to project');
    }
}
