<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Show registration form
    public function showRegistrationForm()
    {
        return view('Auth.register');
    }
    public function register(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:3|confirmed',
        ]);

        // Create the user and store data in the database
        // User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);

        // // Redirect or do further processing
        // return redirect()->route('login')->with('success', 'Registration successful! You can now log in.');

        try {
            // Save user data to the database
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return redirect()->route('login')->with('success', 'Registration successful!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Something went wrong. Please try again.']);
        }

    }

    public function showLoginForm()
    {
        return view('Auth.login');
    }

    // Handle login logic
    public function login(Request $request)
    {
        // Validate the form data
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to log the user in
        if (Auth::attempt($credentials)) {

            return redirect()->intended('dashboard');
        }

        // If login fails, redirect back with an error message and input data
        return redirect()->back()
            ->withErrors(['email' => 'Invalid credentials'])
            ->withInput();
    }

    // Logout logic
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}
