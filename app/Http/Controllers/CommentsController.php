<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
class CommentsController extends Controller
{
    //Comments Controller
    public function index( $id){
        $post = Post::find($id);
        if(!$post){
            return response(['message'=>'Post not found'],404);
        }

        return response([
            'comments'=>$post->comments()->with('user:id, name,image')->get(),
        ]);
    }

    public function store($id)
    {
        $post = Post::find($id);
        if(!$post){
            return response(['message'=>'Post not found'],404);
        }

        
    }
}
