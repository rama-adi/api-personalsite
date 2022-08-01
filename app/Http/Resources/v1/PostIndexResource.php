<?php

namespace App\Http\Resources\v1;

use App\Models\Post;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Tiptap\Editor;

/** @mixin Post */
class PostIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {


        return [
            'id' => $this->id,
            'author' => new UserResource($this->user),
            'title' => $this->title,
            'excerpt' => str(strip_tags($this->body))->limit(),
            'og_image' => Storage::disk(config('filesystems.default'))->url($this->og_image),
            'created_at' => $this->created_at
        ];
    }
}
