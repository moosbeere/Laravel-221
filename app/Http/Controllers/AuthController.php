<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function create(){
        return view('auth.registr');
    }

    public function registr(Request $request){
        $request->validate([
            'name'=>'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        $response = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        return response()->json($response);
    }
}
