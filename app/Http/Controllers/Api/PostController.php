<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class PostController extends Controller
{
    public function index () {

        return PostResource::collection(Post::with('user')->withTrashed()->paginate(15));

    }
    public function show ($post) {

        return new PostResource(Post::find($post));
    }
    public function store (StorePostRequest $request) {

        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        return Post::create(array_merge($request->validated(),['slug'=>$slug]));
    }
}
