<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', ['posts' => Post::withTrashed()->paginate(15)]);
    }

    public function show($postId)
    {
        return view('posts.show', [
            'post' => Post::find($postId)
        ]);
    }

    // public function show($postId)
    // {
    //     return Post::findOrFail($postId);
    // }

    public function create()
    {
        return view('posts.create', ['users' => User::all()]);
    }

    public function store(StorePostRequest $request)
    {


        Post::create($request->all());
        return redirect()->route('posts.index');
    }

    public function edit($postId)
    {
        return view('posts.edit', ['post' => Post::find($postId), 'users' => User::all()]);
    }

    public function update(StorePostRequest $request, Post $post)
    {
        Post::find($post->id)
            ->update($request->all());
        return redirect()->route('posts.index');
    }


    public function destroy($postId)
    {
            Post::find($postId)->delete();
        return redirect()->route('posts.index');
    }

    public function restore($postId)
    {
        Post::withTrashed()->where('id', $postId)->restore();
        return redirect()->route('posts.index');
    }

    public function delete($postId)
    {
        Post::withTrashed()->where('id', $postId)->forceDelete();
        return redirect()->route('posts.index');
    }
}


