<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    //index
    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->with('user:id,name,image')->withCount('comments','likes')->get();

        return response([
            "posts"=> $posts
        ],200);
    }

    //show a post
    public function show($id)
    {
        
        return response([
            'post'=>Post::where('id',$id)->withCount('comments','likes')->get(),
        ]);
    }

    //Store posts

    public function store(Request $request)
    {
    $posts = $request->validate([
        'body'=>'required',
        // 'image'
    ]);

    $post = Post::create([
        'body'=>$posts['body'],
        'user_id'=>auth()->user()->id,
        // 'image'=>null
        
    ]);
    // dd('hello');
    return response([
        'message'=>'project created successfully',
        'post'=>$post
    ]);
    }

    public function update(Request $request,$id){
        $attribute = $request->validate([
            'body'=>'required'
        ]);
        if(!$id){
            return response(['message'=>'Post not found'],404);
        }
        if(auth()->user()->id!=$id){
            return response(['message'=>'unauthenticated'],403);
        }
        $post = Post::find($id)->update([
            'body'=>$attribute['body']
        ]);

        return response([
            'message'=>"updated successfully",
            'post'=>$post
        ],200); 
    }

    public function destroy($id){
        if(!$id){
            return response(['message'=>'Post not found'],404);
        }
        if(auth()->user()->id!=$id){
            return response(['message'=>'unauthenticated'],403);
        }
        $post  = Post::find($id);
        $post->delete();
        return response([
            'message'=>"deleted successfully",
            
        ],200); 
    }
}
