<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
class CommentsController extends Controller
{
    //view comments on a post
    public function index( $id){
        $post = Post::find($id);
        if(!$post){
            return response(['message'=>'Post not found'],404);
        }

        return response([
            'comments'=>$post->comments()->with('user:id,name,email')->get(),
        ]);
    }

    //create a comment on a post
    public function store(Request $request, $id)
    {
        $comment = $request->validate([
            'comment'=>'required',
        ]);
        $post = Post::find($id);
        if(!$post){
            return response(['message'=>'Post not found'],404);
        }
        $postComment = Comment::create([
            'user_id'=>auth()->user()->id,
            'post_id'=>$id,
            'comment'=>$comment['comment']
        ]);
        return response([
            'message'=>'comment posted',
            'comment'=>$postComment
        ],200);
    }

    public function update($id){

    }

}
