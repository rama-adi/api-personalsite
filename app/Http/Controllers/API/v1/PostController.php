<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\PostIndexResource;
use App\Http\Resources\v1\PostShowResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return PostIndexResource::collection(Post::with('user')->paginate(10));
    }

    public function show(Post $post)
    {
        return new PostShowResource($post);
    }
}
