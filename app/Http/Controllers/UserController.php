<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{

    public function show(Request $request)
    {
        // Active users
        $users = User::where("status", 1)->get();

        return view('pages.users.view', compact('users'));
    }

    public function show_addUser(Request $request)
    {
        $generated_password = Str::random(10);
        $roles = map_options(Role::class, 'role_id', 'description');

        return view('pages.users.addUser', compact('roles', 'generated_password'));
    }

    // Add a new user
    public function store(Request $request)
    {
        // Validate input data
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'emailaddress' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Oh no! An error occured.');
        }

        // Create the user
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'emailaddress' => $request->emailaddress,
            'password' => Hash::make($request->password),
            'password_updated_at' => null,
            'role' => (int)$request->role,  
            'status' => 1, 
        ]);

        return redirect()->route('users')->with('success', 'User successfully Added!', 200);
    }

    // Show details of a user 
    public function details($id)
    {
        $userDetails = User::find($id);
        $roles = map_options(Role::class, 'role_id', 'description');
        //dd($userDetails);
        if ($userDetails) {
            return view('pages.users.editUser', compact('userDetails', 'roles'));
        }

        return redirect()->back()->with('error', 'User doesn\'t exist');
    }

     // Edit user details
     public function edit(Request $request, $id)
     {
         $user = User::find($id);
 
         if (!$user) {
            return redirect()->back()->with('error', 'User doesn\'t exist');
         }
 
         $request->validate([
             'firstname' => 'nullable|string|max:255',
             'lastname' => 'nullable|string|max:255',
             'username' => 'nullable|string|max:255|unique:users,username,' . $id,
             'emailaddress' => 'nullable|email|unique:users,emailaddress,' . $id,
             'role' => 'nullable|integer',
         ]);
 
         $user->update([
             'firstname' => $request->firstname,
             'lastname' => $request->lastname,
             'username' => $request->username,
             'emailaddress' => $request->emailaddress,
             'role' => $request->role,
         ]);
 
         return redirect()->route('users')->with('success', 'User updated successfully');
     }

    // disabled user acct
    public function disable($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User doesn\'t exist');
        }

        $user->update([
            'status' => 2,
        ]);

        return redirect()->route('users')->with('success', 'User account successfully disabled.');
    }


    public function update_user_password(){
        return view('pages.auth.update_password');
    }

    public function save_password(Request $request) {

       try{
            $request->validate([
                'password' => 'required|string|min:8|confirmed'
            ]);

            $user = User::find(Auth::user()->id);

            if (!$user) {
                return redirect()->back()->with('error', 'User doesn\'t exist');
            }
    
            $user->update([
                'password' => Hash::make($request->password),
                'password_updated_at' => Carbon::now(),
            ]);
    
            Auth::logout();
            
            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->route('loginPage')->with('success', 'Password updated successfully. Please log in again.');

       }catch(\Exception $e){
         dd($e->getMessage());
       }
    }

}
