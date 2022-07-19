<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class OpengraphImageController extends Controller
{
    public function post(Post $post)
    {
        $tag = implode(", ", $post->tags()->get()->map(function ($tag) {
            return "#{$tag->name}";
        })->toArray());

        return view('og-template.post')->with([
            'post' => $post,
            'tags' => $tag
        ]);

    }
}
