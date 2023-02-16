<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class ReportResource extends JsonResource
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
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'project_id' => $this->project_id,
            'title'      => $this->title,
            'content'    => $this->content,
        ];
    }
}
