<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\User;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;


class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', ['posts' => Post::withTrashed()->paginate(15)]);
    }

    // public function show($postId)
    public function show($postSlug)
    {
        return view('posts.show', [
            // 'post' => Post::find($postId)
            'post' => Post::where('slug',$postSlug)->first()
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

        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        Post::create(array_merge($request->validated(),['slug'=>$slug]));
        return redirect()->route('posts.index');
    }

    // public function edit($postId)
    public function edit($postSlug)
    {
        // return view('posts.edit', ['post' => Post::find($postId), 'users' => User::all()]);
        return view('posts.edit', ['post' => Post::where('slug',$postSlug)->first(), 'users' => User::all()]);
    }

    public function update(StorePostRequest $request, Post $post)
    {
        if(isset(parse_url($request->prev)['query'])){
            parse_str(parse_url($request->prev)['query'], $output);
        }


        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        // Str::of($request->title)->slug('-')->value; // this can be enough, cuz we validate uniqe title
        // Str::slug($request->title, '-'); // direct value
        Post::find($post->id)
            ->update(array_merge($request->validated(),['slug'=>$slug]));
        return redirect()->route('posts.index', ['page'=>$output['page'] ?? null]);
    }


    public function destroy($postId)
    {
        if(isset(parse_url(url()->previous())['query'])){

            parse_str(parse_url(url()->previous())['query'], $output);
        }

            Post::find($postId)->delete();
        return redirect()->route('posts.index',['page'=>$output['page'] ?? null]);
    }

    public function restore($postId)
    {
        if(isset(parse_url(url()->previous())['query'])){

            parse_str(parse_url(url()->previous())['query'], $output);
        }

        Post::withTrashed()->where('id', $postId)->restore();
        return redirect()->route('posts.index', ['page'=>$output['page'] ?? null]);
    }

    public function delete($postId)
    {
        if(isset(parse_url(url()->previous())['query'])){

            parse_str(parse_url(url()->previous())['query'], $output);
        }

        Post::withTrashed()->where('id', $postId)->forceDelete();
        return redirect()->route('posts.index', ['page'=>$output['page'] ?? null]);
    }
}


