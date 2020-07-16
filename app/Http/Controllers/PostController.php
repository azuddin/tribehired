<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Traits\Pagination;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostsResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $available_key = ['id', 'title', 'body', 'num_of_comments'];
        $paginate = Pagination::paginate($request, new Post, $available_key);

        return PostsResource::collection($paginate['data'])->additional(['meta'=>['total' => $paginate['count']]]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return (new PostResource($post));
    }
}
