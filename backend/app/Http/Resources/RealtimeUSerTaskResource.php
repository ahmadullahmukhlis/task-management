<?php

namespace App\Http\Resources;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class RealtimeUSerTaskResource extends JsonResource
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
            'name' => $this->first_name.' '.$this->last_name,
            'image' => asset(Storage::url($this->image)),
            'email' => $this->email,
            'position' => 'development',
            'department' => 'IT Department',
            'taskCount' => $this->total($this->id),
            'tasks' => $this->loadAllTask($this->id),
            'icon' => $this->charecktor($this->first_name.' '.$this->last_name),
        ];
    }

    private function loadAllTask($user_id)
    {
        $tasks = Task::whereRelation('taskAssign', 'user_id', $user_id)->orderByRaw("FIELD(type, 'Urgent','High', 'Medium', 'Low')")->whereStatus('Pending')->get();

        return PedingTaskResource::collection($tasks);
    }

    private function total($user_id)
    {
        return Task::whereRelation('taskAssign', 'user_id', $user_id)->whereStatus('Pending')->count();
    }

    private function charecktor(string $name): string
    {
        $parts = array_values(array_filter(explode(' ', trim($name))));
        $initials = '';

        if (! empty($parts)) {
            $initials .= strtoupper($parts[0][0]);
        }

        if (count($parts) > 2) {
            $initials .= strtoupper($parts[2][0]);
        }
        if (count($parts) > 1) {
            $initials .= strtoupper($parts[1][0]);
        }

        return $initials;
    }
}
