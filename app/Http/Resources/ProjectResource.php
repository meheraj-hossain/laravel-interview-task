<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'Project_name' => $this->name,
            'created_at'   => $this->created_at->toDateTimestring(),
            'tasks'        => TaskResource::collection($this->tasks),
        ];
    }
}
