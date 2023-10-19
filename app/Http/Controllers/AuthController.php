<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function create(){
        return view('auth.registr');
    }

    public function registr(Request $request){
        $request->validate([
            'name'=> 'required',
            'email' => 'required|email|unique:App\Models\User, email',
            'password' => 'required|min:6'
        ]);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>'reader',
        ]);
        $user->createToken('MyAppTokens')->plainTextToken;
        return redirect()->route('login');
        // $form = [
        //     'name' => $request->name,
        //     'email' => request('email'),
        // ];

        // return response()->json($form);
    }

    public function login(){
        return view('auth.login');
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt($credentials, $request->remember)){
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
