<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::all()
        ]);
    }

    public function show($id)
    {
        $post = Post::find($id);

        return view('posts.show', ['post'=>$post]);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'title' => '',
            'content' => '',
        ]);

        $post = Post::create($data);

        return $post;
    }

    public function update(Post $post, Request $request)
    {
        $post->update($request->all());

        return $post;
    }
}
