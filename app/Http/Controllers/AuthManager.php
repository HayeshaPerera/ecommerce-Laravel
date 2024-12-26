<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthManager extends Controller
{
    // Function to show login form
    public function login()
    {
        return view('auth.login');
    }

    // Function to handle login logic
    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended(route("home"));
        }

        return redirect("login")->with("error", "Invalid Email or Password");
    }

    public function logout(){

        Auth::logout();
        return redirect("login");
    }



    // Function to show registration form
    public function register()
    {
        return view('auth.register');
    }

    // Function to handle registration logic
    public function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            return redirect()->intended(route("login"))
                ->with("success", "Registration successful. Please log in.");
        }

        return redirect(route("register"))
            ->with("error", "Something went wrong. Please try again.");
    }
}
