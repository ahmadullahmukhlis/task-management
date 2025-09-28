<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\UserProjectResource;
use App\Http\Resources\DashboardTaskResource;
use App\Models\Task;
use App\Models\User;
use App\Models\UserProject;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::where('created_by',auth()->id())->orWhereRelation('userProject','user_id',auth()->id())->get();
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

        $project = Project::findOrFail($id);
        $users = User::whereRelation('userProject', 'project_id', $project->id)->get();
        return UserProjectResource::collection($users);

    }
   public function statistic()
{
    $userId = auth()->id();

    // total counts
    $query = Task::query();
    $total = $query
        ->whereRelation('taskAssign', 'user_id', $userId)
        ->orWhere('created_by', $userId)
        ->count();

    $complate = $query
        ->whereRelation('taskAssign', 'user_id', $userId)
        ->whereRelation('taskAction', 'status', 'completed')
        ->orWhere('created_by', $userId)
        ->count();

    $pending = $query
        ->whereRelation('taskAssign', 'user_id', $userId)
        ->whereRelation('taskAction', 'status', 'Pending')
        ->orWhere('created_by', $userId)
        ->count();

    // === New: weekly counts ===
    $lastWeekStart = now()->subWeek()->startOfWeek();
    $lastWeekEnd   = now()->subWeek()->endOfWeek();

    $currentWeekStart = now()->startOfWeek();
    $currentWeekEnd   = now()->endOfWeek();

    $lastWeekTotal = Task::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
        ->where(function ($q) use ($userId) {
            $q->whereRelation('taskAssign', 'user_id', $userId)
              ->orWhere('created_by', $userId);
        })->count();
$userId = auth()->id();

$lastWeekComplete = Task::where(function ($q) use ($userId ,$lastWeekStart, $lastWeekEnd) {
    $q->whereHas('taskAction', function ($q2) use ($userId ,$lastWeekStart, $lastWeekEnd) {
        $q2->where('user_id', $userId)
           ->where('status', 'completed')->whereBetween('updated_at', [$lastWeekStart, $lastWeekEnd]);
    })
    ->orWhere('created_by', $userId);
})
->count();

$lastWeekPending = Task::where(function ($q) use ($userId ,$lastWeekStart, $lastWeekEnd) {
    $q->whereHas('taskAction', function ($q2) use ($userId ,$lastWeekStart, $lastWeekEnd) {
        $q2->where('user_id', $userId)
           ->where('status', 'Pending')->whereBetween('updated_at', [$lastWeekStart, $lastWeekEnd]);
    })
    ->orWhere('created_by', $userId);
})
->count();


    $currentWeekTotal = Task::whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])
        ->where(function ($q) use ($userId) {
            $q->whereRelation('taskAssign', 'user_id', $userId)
              ->orWhere('created_by', $userId);
        })->count();

    $trendTotal = $currentWeekTotal - $lastWeekTotal;
    $trendColor = $trendTotal >= 0 ? 'green' : 'red';
    $trendText  = ($trendTotal >= 0 ? '+' : '') . $trendTotal . ' from last week';

    return response()->json([
        'data' => [
            [
                'title' => 'Total Tasks',
                'value' => $total,
                'icon' => 'assignment',
                'color' => 'blue',
                'trend' => $trendText,      // changed to dynamic
                'trendColor' => $trendColor // dynamic
            ],
            [
                'title' => 'Completed',
                'value' => $complate,
                'icon' => 'check_circle',
                'color' => 'green',
                'trend' => '+'.$lastWeekComplete.' from last week',
                'trendColor' => 'green',
            ],
            [
                'title' => 'Pending',
                'value' => $pending,
                'icon' => 'autorenew',
                'color' => 'yellow',
                  'trend' => '+'.$lastWeekPending.' from last week',
                'trendColor' => 'red',
            ],
            [
                'title' => 'Overdue',
                'value' => 5,
                'icon' => 'warning',
                'color' => 'red',
                'trend' => '+2 from last week',
                'trendColor' => 'red',
            ],
        ]
    ]);
}
public function myTask()
{
    $tasks = Task::whereRelation('taskAssign', 'user_id', auth()->id())->orWhere('created_by',auth()->id())
        ->orderBy('id', 'desc')
        ->take(6)
        ->get();

    return DashboardTaskResource::collection($tasks);
}


}
