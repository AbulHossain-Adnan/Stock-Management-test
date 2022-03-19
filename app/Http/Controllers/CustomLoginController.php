<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class CustomLoginController extends Controller
{
    public function admin_login(){
        return view('auth/login');
    }
     public function loginpost(Request $request)
    {

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        // $user = User::where('email',$request->email && 'password',Hash::check($request->password))

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        }

        return redirect('login')->with('error', 'Oppes! You have entered invalid credentials');
    }
     public function adminlogout() {
      Auth::logout();

      return redirect()->route('login');
    }
}
