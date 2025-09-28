<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserProjectResource extends JsonResource
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
            'name'=> $this->first_name . ' ' .$this->last_name ,
            'image'=> asset(Storage::url($this->image)),
            'email'=> $this->email ,
            'initials'=>$this->charecktor($this->first_name . ' '. $this->last_name),
            'color'=> $this->color($this->id)
        ];
    }
    private function charecktor(string $name): string
{
    $parts = array_values(array_filter(explode(' ', trim($name))));
    $initials = '';

    if (!empty($parts)) {
        $initials .= strtoupper($parts[0][0]); // first letter of first word
    }

    if (count($parts) > 1) {
        $initials .= strtoupper($parts[1][0]); // first letter of second word
    }

    return $initials;
}
private function color(?int $id = null): string
{
    $colors = [
        'blue',
        'pink',
        'purple',
        'green',
        'yellow',
        'red',
        'indigo',
        'teal',
        'orange',
        'gray',
    ];

    if ($id === null) {
        return $colors[array_rand($colors)];
    }

    $index = abs($id) % count($colors);
    return $colors[$index];
}
}
