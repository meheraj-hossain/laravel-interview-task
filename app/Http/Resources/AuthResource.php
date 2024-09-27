<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user'  => [
                'id'    => $this->resource['user']->id,
                'name'  => $this->resource['user']->name,
                'email' => $this->resource['user']->email
            ],
            'token' => $this->resource['token']
        ];
    }
}
