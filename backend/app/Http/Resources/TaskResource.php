<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
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
            'due_date' => $this->due_to,
            'tags' => $this->tags ,
            'project_id'=>$this->project_id
        ];
    }
}
