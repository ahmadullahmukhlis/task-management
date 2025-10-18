<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardTaskResource extends JsonResource
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
            'project_id' => $this->project_id,
            'description' => $this->description,
            'statusText' => $this->status, // method in Task model
            'statusColor' => $this->getStatusColor($this->status), // dynamic color
            'dueDate' => $this->due_to
    ? Carbon::parse($this->due_to)->format('M d')
    : 'Tomorrow',
            'assignee' => auth()->id() == $this->created_by ? 'You' : $this->user?->first_name.' '.$this->user?->last_name,

        ];
    }

    private function getStatusColor($status)
    {
        return match ($status) {
            'To Do' => 'grey-6',
            'In Progress' => 'blue',
            'Pending' => 'yellow',
            'completed' => 'green',
            default => 'grey-6',
        };
    }
}
