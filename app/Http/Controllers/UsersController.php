<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log the user in
        if (auth()->attempt($request->only('email', 'password'))) {
            // Redirect to the intended page or dashboard
            return redirect()->intended('/');
        }

        // If authentication fails, redirect back with an error message
        return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function register(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Create a new user
        $user = new User();
        $user->nombres = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->nivel = 'cliente'; // Set default user level
        $user->estado = 'activo'; // Set default user status
        $user->save();

        // Log the user in
        auth()->login($user);

        // Redirect to the intended page or dashboard
        return redirect()->intended('/admin/dashboard');
    }


    public function logout()
    {
        // Log the user out
        auth()->logout();

        // Redirect to the login page or home page
        return redirect('/login')->with('success', 'Logged out successfully');
    }
}
