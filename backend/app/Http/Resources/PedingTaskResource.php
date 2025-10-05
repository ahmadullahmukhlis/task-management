<?php

namespace App\Http\Resources;

use App\Models\Project;
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
            'id'=>$this->id ,
            'title'=>$this->title,
            'status'=>$this->status ,
            'type'=>$this->type ,
        'project'=>$this->projectName($this->project_id)
        ];
    }
    private function projectName($project) {
      $pro =  Project::find($project);
     return $pro->name;
    }
}
