<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::published()->latest()->get()
        ]);
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            'posts' => Post::where('slug', $post->slug)
                ->get()
        ]);
    }
}
