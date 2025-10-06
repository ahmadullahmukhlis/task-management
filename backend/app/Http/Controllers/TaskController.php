<?php

namespace App\Http\Controllers;

use App\Events\TaskEvent;
use App\Http\Resources\RealtimeUSerTaskResource;
use App\Http\Resources\TaskResource;
use App\Models\Document;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskAction;
use App\Models\User;
use App\Models\UserTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $userId  = Auth()->id();
        $project= Project::where('id',$id)->where(function ($q) use($userId) {
            $q->whereRelation('userProject','user_id',$userId)->orWhere('created_by',$userId);
        })->first();
        if(!$project){
            return response()->json([
                'result'=>false ,
                'message'=>'the project is n ot assign to the user '
            ]);
        }
       $pendingTask = Task::where('project_id', $project->id)->orderBy('id', 'desc')
    ->where(function ($q) {

        $q->whereHas('taskAction', function ($q2) {
            $q2->where('user_id', auth()->id())
               ->where('status', '!=', 'completed');
        })
        ->orWhereDoesntHave('taskAction', function ($q2) {
            $q2->where('user_id', auth()->id());
        });
    })
    ->get();
        $complate = Task::where('project_id',$project->id)->orderBy('id', 'desc')
        ->where(function ($q) {

        $q->whereHas('taskAction', function ($q2) {
            $q2->where('user_id', auth()->id())
               ->where('status','completed');
        });
    })->get();
        return response()->json(['data'=>[
            'complate'=>TaskResource::collection($complate),
            'panding'=>TaskResource::collection($pendingTask)
        ]]);

    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $task = Task::create([
            'project_id'=>$request->project_id,
            'title'=>$request->title,
            'description'=>$request->description,
            'type'=>$request->type,
            'status'=>$request->status ? 'completed' : 'Pending',
            'due_to'=>$request->dueDate ?? now(),
            'created_by'=>auth()->user()->id
        ]);
        event(New TaskEvent($task));
        if($request->has('assign')) {
            foreach ($request->assign as $item) {
        UserTask::create(
        [
            'user_id' => $item,
            'task_id' => $task->id
        ]
    );
            }
        }
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
            'status'=>  TaskAction::where('task_id',$task->id)->where('status','Pending')->first() ?   'Pending' :'completed'
        ]);
$taskAction = TaskAction::where('user_id', auth()->id())
    ->where('task_id', $task->id)
    ->first();

$status = 'completed'; // default

if ($taskAction && $taskAction->status === 'completed') {
    // if already completed, toggle back to pending
    $status = 'Pending';
}
        event(New TaskEvent($task));

// now create or update with the decided status
TaskAction::updateOrCreate(
    [
        'user_id' => auth()->id(),
        'task_id' => $task->id,
    ],
    [
        'status' => $status,
    ]
);

             return response()->json(
            [
                'result'=>true ,
                'message'=>'the task has been completed'
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
public function assign(Request $request)
{
    UserTask::updateOrCreate(
        [
            'user_id' => $request->user_id,
            'task_id' => $request->task_id
        ]
    );

    return response()->json([
        'result' => true,
        'message' => 'The user is assigned to the task'
    ]);
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
public function remove(Request $request)
{
    UserTask::where('user_id', $request->user_id)
        ->where('task_id', $request->task_id)
        ->delete(); // delete the matching record

    return response()->json([
        'result' => true,
        'message' => 'The user has been removed from the task'
    ]);
}
public function realTimeData() {
    $user = User::whereHas('taskUser')->get();
    return RealtimeUSerTaskResource::collection($user);
}
public function uploadDocument(Request $request) {
    $task = Task::find($request->task_id);
    $document = null;
    if($request->hasFile('document')){
        $document = Storage::put('public', $request->file('document'));
    }
  $document =  Document::create([
        'task_id'=>$task->id,
        'title'=>$request->title,
        'document'=>$document ?? $request->document
    ]);
        return response()->json([
        'result' => true,
        'message' => 'The  Document Has Been Uploaded',
        'data'=> $document
    ]);
}
public function deleteDocument($id){
    $document = Document::find($id);
    if (Storage::disk('public')->exists($document->document)) {
     Storage::delete($document->document);
}
$document->delete();
  return response()->json([
        'result' => true,
        'message' => 'The document has been removed from the task'
    ]);
}
public function loadTask($id) {
    $task = Task::find($id);
    return new TaskResource($task);
}

}
