<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\UserProjectResource;
use App\Models\User;
use App\Models\UserProject;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::get();
        return ProjectResource::collection($projects);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function search(Request $request)
    {
        $search = $request->input('search');
        $users = User::where('email', $search)
    ->orWhere('first_name', 'like', '%' . $search . '%')
    ->orWhere('last_name', 'like', '%' . $search . '%')
    ->get();
    return UserProjectResource::collection($users);
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $project = Project::create([
                'name'=>$request->name,
                'comment'=>$request->comment,
                'created_by'=>auth()->user()->id
            ]);
            return response()->json([
                'result'=>true ,
                'message'=>'the record has been save',
                'data'=>$project
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function addUser(string $id , Request $request)
    {
        $project = Project ::find($id);
  UserProject::updateOrCreate(
    [
        'user_id' => $request->user_id,
        'project_id' => $project->id,
    ],
    [
        'updated_at' => now(),
    ]
);
           return response()->json([
                'result'=>true ,
                'message'=>'the user has been add to the project',

            ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Project::find($id);
        return  new  ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::find($id);

        $project->update([
            'name'=>$request->name,
                'comment'=>$request->comment,
        ]);
             return response()->json([
                'result'=>true ,
                'message'=>'the record has been updated',
                'data'=>$project
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function loadUser(string $id)
    {
        $project = Project::find($id);
        $user = User::whereRelation('userProject','project_id',$project->id);
        return UserProjectResource::collection($user);
    }
}
