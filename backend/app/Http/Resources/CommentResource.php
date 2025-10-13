<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;


class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      return [
        'id'=>$this->id,
        'comment'=>$this->body,
        'user'=>$this->users($this->user_id),
      ];
    }
    private function users($user_id) {
        $user  = User::find($user_id);
        return $user?->first_name . ' ' . $user?->last_name;
    }
}
