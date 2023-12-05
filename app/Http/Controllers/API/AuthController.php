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
        // return view('auth.registr');
    }
    
    public function registr(Request $request){
        
        $request->validate([
            'name'=>'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        $user = User::create([
            'name' => $request->name, 
            'email'=> $request->email,
            'password' => Hash::make($request->password),
            'role'=>'reader'
        ]);
        $token = $user->createToken('myAppToken')->plainTextToken;
        return response()->json([
            'user'=>$user,
            'token'=>$token
        ]);
        // return redirect()->route('login');
        // $response = [
        //     'name' => $request->name,
        //     'email' => $request->email,
        // ];
        // return response()->json($response);
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
            // $token = auth()->user()->createToken('myAppToken');
            $token = $request->user()->createToken('myAppToken')->plainTextToken;
            return response()->json(['token'=>$token]);
        }
        return response(['email' => 'The provided credentials do not match our records.'], 401);
    }

    public function logOut(Request $request){
        $request->user()->tokens()->delete();
        return response('logout');
    }
}
