<?php

namespace App\Http\Resources\Project;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class ProjectResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'start_at' => $this->start_at,
            'end_at'   => $this->end_at,
        ];
    }
}
