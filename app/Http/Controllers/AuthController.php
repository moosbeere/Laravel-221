<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Hash;

class AuthController extends Controller
{
    public function create(){
        return view('auth.create');
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
            'password' => Hash::make($request->password)
        ]);
        $user->createToken('myAppToken')->plainTextToken;
        return redirect()->route('login');
        // $response = [
        //     'name' => $request->name,
        //     'email' => $request->email,
        // ];
        // return response()->json($response);
    }

    public function login(){
        return view('auth.login');
    }

    public function customLogin(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->withError(
            [
                'email' => 'error email',
                'password' => 'error password',
            ]);
    }

    public function logOut(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}