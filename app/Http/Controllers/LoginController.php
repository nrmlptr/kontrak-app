<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // FUNGSI VIEW LOGIN ======================================================================================================
    public function index()
    {
        return view('auth.login');
    }

    // FUNGSI LOADING LOGIN ===================================================================================================
    public function loadLogin(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'username'  => 'required',
            'password'  => 'required',
        ]);

        $data = [
            'username'  => $request->username,
            'password'  => $request->password
        ];


        if (Auth::attempt($data)) {
            return redirect()->route('dashboard')->with('success', 'Kamu Berhasil Login!');;
        } else {
            return redirect()->route('login')->with('failed', 'Email atau Password Salah, Silahkan Coba Lagi!');
        }
    }

    // FUNGSI LOGOUT ==========================================================================================================
    public function logout()
    {
        // dd('oke');
        Auth::logout();
        return redirect()->route('login')->with('success', 'Kamu Berhasil Logout!');
    }
}
