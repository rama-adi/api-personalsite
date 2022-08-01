<?php

namespace App\Http\Resources\v1;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Tiptap\Editor;

/** @mixin Post */
class PostShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'og_image' => Storage::disk(config('filesystems.default'))->url($this->og_image),
            'body' => $this->body,
            'created_at' => $this->created_at
        ];
    }
}
