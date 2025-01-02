<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

     
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {

            $user = Auth::user();

            if ($user->status != 1) {
                Auth::logout();
                
                return redirect()->back()->with('error', 'Your account is inactive.');
            }

            // Store user data in session
            session(['user_data' => $user]);

            // redirect to homepage after login
            return  redirect()->intended(default: route('home'));
        }

        return redirect()->back()->with('error', 'Invalid credentials');
    }
}

