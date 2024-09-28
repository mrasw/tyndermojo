<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        return view('page.auth.login');
    }

    public function store(){

    }

    public function update(){

    }

    public function delete(){

    }

    public function login(Request $request){

        $request['no_hp'] = $request['login-nohp'];
        $request['password'] = $request['login-password'];
        // dd($request);
        try {
            $request->validate([
                'no_hp' => 'required|numeric',
                'password' => 'required',
            ]);

            if (Auth::attempt($request->only('no_hp', 'password'))) {
                return redirect()->intended();
            }
        } catch (\Throwable $th) {
            // throw $th;
            dd($th);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
