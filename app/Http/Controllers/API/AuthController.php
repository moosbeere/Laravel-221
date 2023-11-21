<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Hash;
use App\Http\Controllers\Controller;


class AuthController extends Controller
{
    public function create(){
        // return view('auth.create');
    }
    
    public function registr(Request $request){
        
        $request->validate([
            'name'=>'required',
            'email' => 'required|email|unique:App\Models\User',
            'password' => 'required|min:6'
        ]);
        $user = User::create([
            'name' => $request->name, 
            'email'=> $request->email,
            'password' => Hash::make($request->password),
            'role'=>'reader'
        ]);
        $token = $user->createToken('myAppToken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
        ];
        return response()->json($response);
    }

    public function login(){
        // return view('auth.login');
    }

    public function customLogin(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt($credentials)){
            $token = auth()->user()->createToken('myAppToken');
            return response($token, 201);
        }
        return response('Bad login', 401);
    }

    public function logOut(Request $request){
        auth()->user()->tokens()->delete();
        return response('logout');
    }
}