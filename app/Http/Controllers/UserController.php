<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;

class UserController extends Controller 
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user(); 
        return view('user.index', ['user' => $user]);
    }

    public function store(Request $request)
    {
        $user = auth()->user(); 
        
        $validation = [
            'email' => 'required|email|unique:users,email,'. $user->id,
        ]; 

        if ($request->password) {
            $validation['password'] = 'required|min:5';
            $user->password = Hash::make($request->password);
            $user->default_password = ''; 
        }

        $request->validate($validation); 

        $user->email = $request->email; 
        $user->save();

        return redirect('/')->with('success', 'Profile anda berhasil dirubah');
    }

}