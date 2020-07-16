<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use App\Traits\Pagination;
use App\Http\Resources\CommentsResource;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $available_key = ['id', 'post_id', 'name', 'email', 'body'];
        $paginate = Pagination::paginate($request, new Comment, $available_key);

        return CommentsResource::collection($paginate['data'])->additional(['meta'=>['total' => $paginate['count']]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id'=>'required|exists:posts,id',
            'name'=>'required',
            'email'=>'required|email',
            'body'=>'required'
        ]);

        $post = Comment::create([
            'post_id'=>$validated['post_id'],
            'name'=>$validated['name'],
            'email'=>$validated['email'],
            'body'=>$validated['body']
        ])->post;
        $post->num_of_comments += 1;
        $post->save();

        return response(['message' => 'Comment added!'], 200);
    }
}
