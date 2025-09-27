<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $project= Project::where('id',$id)->whereRelation('userProject','user_id',auth()->user()->id)->orWhere('created_by',auth()->user()->id)->first();
        if(!$project){
            return response()->json([
                'result'=>false ,
                'message'=>'the project is n ot assign to the user '
            ]);
        }
        $pendingTask = Task::where('project_id',$project->id)->where('status', '!=','Complate')->get();
        $complate = Task::where('project_id',$project->id)->where('status', 'Complate')->get();
        return response()->json(['data'=>[
            'complate'=>TaskResource::collection($complate),
            'panding'=>TaskResource::collection($pendingTask)
        ]]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Task::create([
            'project_id'=>$request->project_id,
            'title'=>$request->title,
            'description'=>$request->description,
            'type'=>$request->type,
            'status'=>$request->status ? 'Complate' : 'Pending',
            'due_to'=>$request->dueDate ?? now()
        ]);
        return response()->json(
            [
                'result'=>true ,
                'message'=>'the task has been created'
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function complate(string $id)
    {
        $task = Task::find($id);
        $task->update([
            'status'=> $task->status =='Complate' ?   'Pending' :'Complate'
        ]);
             return response()->json(
            [
                'result'=>true ,
                'message'=>'the task has been complated'
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::find($id);

            $task->update([
            'title'=>$request->title,
            'description'=>$request->description,
            'type'=>$request->type,
            'due_to'=>$request->dueDate ?? now()
        ]);
             return response()->json(
            [
                'result'=>true ,
                'message'=>'the task has been updated'
            ]
        );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
