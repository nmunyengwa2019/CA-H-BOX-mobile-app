<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function register(Request $request){
        //validate data
        $data = $request->validate([
            'name'=>'required|min:2',
            'surname'=>'required|min:2',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed'
        ]);
        // $data['password']= Hash::make($data['password']);
        //Create a user
        $user = User::create([
            "name"=>$data['name'],
            "email"=>$data['email'],
            "password"=>bcrypt($data['password'])
        ]);

        //Create a token for the user
$accessToken = $user->createToken('secret')->plainTextToken;
        return response([
            'user'=>$user,
            'accessToken'=>$accessToken,
        ]);
    }

    public function login(Request $request){
        //validate data
        $data = $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);

        if(!Auth::attempt($data)){
            return response(['message'=>'Incorrect login details'],401);
        }
        $token = auth()->user()->createToken('secret')->plainTextToken;
        return response([
            'user'=>auth()->user(),
            'token'=>$token,
            'message'=>'Loggin successfully'
        ],200);

    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response(["message"=>"logged out successfully"],200);
    }

    public function user(){
        return response([
            "user"=>auth()->user()
        ]);
    }
}
