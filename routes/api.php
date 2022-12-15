<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PostsController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Public routes
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

//protected routes
Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::post('/logout',[AuthController::class,'logout']);
    Route::get('/user',[AuthController::class,'user']);

    //Posts 
    Route::get('/posts',[PostsController::class,'index']);//get posts
    Route::post('/posts',[PostsController::class,'store']);//create post
    Route::get('/posts/{id}',[PostsController::class,'show']);//view a post
    Route::patch('/posts/{id}',[PostsController::class,'update']);//update a post
    Route::delete('/posts/{id}',[PostsController::class,'destroy']);//delete a post

    //Comments
    Route::get('/posts/{id}/comments',[CommentsController::class,'index']);//get posts
    Route::post('/posts/{id}/comments',[CommentsController::class,'store']);//create post
    // Route::get('/posts/{id}/comments',[CommentsController::class,'show']);//view a post
    Route::patch('/comments/{id}',[CommentsController::class,'update']);//update a post
    Route::delete('/comments/{id}',[CommentsController::class,'destroy']);//delete a post
    
    //Likes
    Route::post('/posts/{id}/like',[LikesController::class,'likeOrUnlike']);//get posts


});