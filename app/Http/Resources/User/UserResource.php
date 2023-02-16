<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class UserResource extends JsonResource
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
            'id'           => $this->id,
            'role'         => $this->role,
            'name'         => $this->name,
            'display_name' => $this->display_name,
            'code'         => $this->code,
            'email'        => $this->email,
            'avatar'       => $this->avatar,
        ];
    }
}
