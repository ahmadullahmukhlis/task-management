<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'name'=>$this->name,
            'description'=>$this->comment,
            'initials'=>$this->firstTwoWords($this->name),
            'color'=>'bg-'.$this->color($this->id),
            'tasks'=>25 + $this->id,
            'progress'=>$this->id + 41,
            'progressColor'=>$this->color($this->id),
            'members'=>[
                [
                    'initials'=>'AJ',
                    'color'=> $this->color()
                ],        [
                    'initials'=>'AJ',
                    'color'=> $this->color()
                ]    ,    [
                    'initials'=>'AJ',
                    'color'=> $this->color()
                ]   ,     [
                    'initials'=>'AJ',
                    'color'=> $this->color()
                ]
            ]

        ];
    }
    private function firstTwoWords(string $name): string
    {
        $parts = array_values(array_filter(explode(' ', trim($name))));
        if (empty($parts)) {
            return '';
        }
        if (count($parts) === 1) {
            return $parts[0];
        }
        return $parts[0] . ' ' . $parts[1];
    }
    private   function dynamicBgColor(): string
    {

 $colors = [
            'bg-blue-600',
            'bg-pink-600',
            'bg-purple-600',
            'bg-green-600',
            'bg-yellow-600',
            'bg-red-600',
            'bg-indigo-600',
            'bg-teal-600',
            'bg-orange-600',
            'bg-gray-600',
        ];

        return $colors[array_rand($colors)];
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
        // no id passed → random colour
        return $colors[array_rand($colors)];
    }

    // id passed → pick by index (wrap if bigger than array)
    // ensure non-negative integer
    $index = abs($id) % count($colors);

    return $colors[$index];
}

}
