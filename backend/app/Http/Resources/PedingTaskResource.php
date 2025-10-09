<?php

namespace App\Http\Resources;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PedingTaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status,
            'type' => $this->type,
            'project' => $this->projectName($this->project_id),
            'dueDate' => $this->getComparisonDateAttribute($this->created_at, $this->dueTo),
        ];
    }

    private function projectName($project)
    {
        $pro = Project::find($project);

        return $pro->name;
    }

    private function getComparisonDateAttribute($created_at, $dueTo)
    {
        $createdAt = Carbon::parse($created_at);
        $dueDate = Carbon::parse($dueTo);

        return $createdAt->isSameDay($dueDate)
            ? $dueDate->format('Y-m-d')
            : $createdAt->diffForHumans($dueDate, [
                'syntax' => Carbon::DIFF_RELATIVE_TO_NOW,
            ]);
    }
}
