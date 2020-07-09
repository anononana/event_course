<?php

namespace App\Http\Controllers\API;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request) {
       $validatedData = $request->validate([
            'name'=>'required',
            'surname'=>'required',
            'login'=>'required|unique:users',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
            'image' => 'url'
        ]);
        $validatedData['password'] = bcrypt($validatedData['password']);
        $user = User::create($validatedData);
        $accessToken = $user->createToken('laravel')->accessToken;
        return response()->json(['user'=>$user, 'accessToken'=>$accessToken]);
    }
    public function login(Request $request) {
        $data = $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);
        if(!auth()->attempt($data)) {
            return response()->json(['message'=>'Invalid credentials'], 400);
        }

        $accessToken = auth()->user()->createToken('laravel')->accessToken;

        return response()->json(['user'=>auth()->user(), 'accessToken'=>$accessToken]);
    }
    public function logout() {
        auth()->user()->tokens->each(function($token, $key) {
            $token->delete();
        });
        return response()->json('Logged out succesfully', 200);
    }
}
