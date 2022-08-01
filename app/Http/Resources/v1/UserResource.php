<?php

namespace App\Http\Resources\v1;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin User */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name
        ];
    }
}
