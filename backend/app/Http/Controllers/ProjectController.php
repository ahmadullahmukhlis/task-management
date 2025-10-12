<?php

namespace App\Http\Controllers;

use App\Http\Resources\DashboardTaskResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\UserProjectResource;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\UserProject;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::where('created_by', auth()->id())->orWhereRelation('userProject', 'user_id', auth()->id())->get();

        return ProjectResource::collection($projects);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function search(Request $request)
    {
        $search = $request->input('search');
        $users = User::where('email', $search)
            ->orWhere('first_name', 'like', '%'.$search.'%')
            ->orWhere('last_name', 'like', '%'.$search.'%')
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
            'name' => $request->name,
            'comment' => $request->comment,
            'created_by' => auth()->user()->id,
        ]);

        return response()->json([
            'result' => true,
            'message' => 'the record has been save',
            'data' => $project,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function addUser(string $id, Request $request)
    {
        $project = Project::find($id);
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
            'result' => true,
            'message' => 'the user has been add to the project',

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Project::find($id);

        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::find($id);

        $project->update([
            'name' => $request->name,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'result' => true,
            'message' => 'the record has been updated',
            'data' => $project,
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

        // === Base conditions ===
        $baseCondition = function ($q) use ($userId) {
            $q->whereRelation('taskAssign', 'user_id', $userId)
                ->orWhere('created_by', $userId);
        };

        // === Total ===
        $total = Task::where($baseCondition)->count();

        // === Completed ===
        $completed = Task::where($baseCondition)
            ->whereHas('taskAction', fn ($q) => $q->where('status', 'completed'))
            ->count();

        // === Pending ===
        $pending = Task::where($baseCondition)
            ->whereHas('taskAction', fn ($q) => $q->where('status', 'Pending'))
            ->count();

        // === Overdue ===
        $overdue = Task::where($baseCondition)
            ->whereHas('taskAction', fn ($q) => $q->where('status', 'Pending'))
            ->whereDate('due_to', '<', now())
            ->count();

        // === Weekly stats ===
        $lastWeekStart = now()->subWeek()->startOfWeek();
        $lastWeekEnd = now()->subWeek()->endOfWeek();
        $currentWeekStart = now()->startOfWeek();
        $currentWeekEnd = now()->endOfWeek();

        $lastWeekTotal = Task::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
            ->where($baseCondition)->count();

        $currentWeekTotal = Task::whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])
            ->where($baseCondition)->count();

        $lastWeekCompleted = Task::whereBetween('updated_at', [$lastWeekStart, $lastWeekEnd])
            ->where($baseCondition)
            ->whereHas('taskAction', fn ($q) => $q->where('status', 'completed'))
            ->count();
        $lastWeekOveritPending = Task::whereBetween('updated_at', [$lastWeekStart, $lastWeekEnd])
            ->where($baseCondition)
            ->whereHas('taskAction', fn ($q) => $q->where('status', 'Pending'))
            ->whereDate('due_to', '<', now())
            ->count();

        $lastWeekPending = Task::whereBetween('updated_at', [$lastWeekStart, $lastWeekEnd])
            ->where($baseCondition)
            ->whereHas('taskAction', fn ($q) => $q->where('status', 'Pending'))
            ->count();

        // === Trend ===
        $trendTotal = $currentWeekTotal - $lastWeekTotal;
        $trendColor = $trendTotal >= 0 ? 'green' : 'red';
        $trendText = ($trendTotal >= 0 ? '+' : '').$trendTotal.' from last week';

        return response()->json([
            'data' => [
                [
                    'title' => 'Total Tasks',
                    'value' => $total,
                    'icon' => 'assignment',
                    'color' => 'blue',
                    'trend' => $trendText,
                    'trendColor' => $trendColor,
                ],
                [
                    'title' => 'Completed',
                    'value' => $completed,
                    'icon' => 'check_circle',
                    'color' => 'green',
                    'trend' => '+'.$lastWeekCompleted.' from last week',
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
                    'value' => $overdue,
                    'icon' => 'warning',
                    'color' => 'red',
                    'trend' => $lastWeekCompleted.' from last week', // you can make this dynamic if needed
                    'trendColor' => 'red',
                ],
            ],
        ]);
    }

    public function myTask()
    {
       $tasks = Task::whereRelation('taskAssign', 'user_id', auth()->id())
    ->where(function ($q) {
        $q->whereRelation('project.userProject', 'user_id', auth()->id())
          ->orWhereRelation('project', 'created_by', auth()->id());
    })
    ->orWhere('created_by', auth()->id())
    ->orderBy('id', 'desc')
    ->take(6)
    ->get();


        return DashboardTaskResource::collection($tasks);
    }
}
