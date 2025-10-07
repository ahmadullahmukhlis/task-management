<?php

namespace App\Http\Resources;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'completed' => (bool) $this->completed == 'Complate' ? true : false,
            'dueDate' => $this->due_to,
            'priority' => $this->type,
            'project_id' => $this->project_id,
            'created_by' => $this->created_by == auth()->id() ? true : false,
            'assign' => $this->userLoad($this->id),
            'documents' => $this->loadDocument($this->id),
        ];
    }

    private function userLoad($id)
    {
        $users = User::whereRelation('taskUser', 'task_id', $id)->get();

        return UserProjectResource::collection($users);
    }

    private function loadDocument($task_id)
    {
        $document = Document::where('task_id', $task_id)->get();

        return DocumentResource::collection($document);
    }
}
