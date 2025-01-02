<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {

        Auth::logout();
         
        //remove alll session data
        $request->session()->invalidate();

        // generate the session token to protect against session fixation attacks
        $request->session()->regenerateToken();

        return redirect()->route('loginPage')->with('success', 'Successfully logged out.');
    }
}
