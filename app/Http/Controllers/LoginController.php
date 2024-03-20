<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function index(){
        return view('auth.login');
    }


    public function loadLogin(Request $request){
        // dd($request->all());

        $request->validate([
            'email'     => 'required',
            'password'  => 'required',
        ]);

        $data = [
            'email'     => $request->email,
            'password'  =>$request->password
        ];


        if(Auth::attempt($data)){
            return redirect()->route('dashboard');
        }else{
            return redirect()->route('login')->with('failed', 'Email atau Password Salah, Silahkan Coba Lagi!');
        }
    }


    public function logout(){
        // dd('oke');
        Auth::logout();
        return redirect()->route('login')->with('success', 'Kamu Berhasil Logout!');
    }
}
