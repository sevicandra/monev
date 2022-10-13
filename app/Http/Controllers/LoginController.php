<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
        $credentials =$request->validate([
            'nip'=>'required|min:18|max:18',
            'nip'=>'numeric',
            'password'=>'required',
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            $request->session()->put('tahun', date('Y'));
            return redirect()->intended('/dashboard');
        }

        return back()->with('gagal','LoginFailed');
    }

    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect()->intended('');
    }
}
