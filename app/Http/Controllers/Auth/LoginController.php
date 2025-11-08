<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{
    // Show the login form (for Vue.js)
    public function showLoginForm()
    {
        return Inertia::render('Login');
    }

    // Handle login logic
    public function login(Request $request)
    {
        // Validate login input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Get the remember me value (defaults to false if not provided)
        $remember = $request->boolean('remember');
        
        // Debug logging
        \Log::info('Login attempt', [
            'email' => $request->email,
            'remember' => $remember,
            'remember_raw' => $request->input('remember')
        ]);

        // Attempt to authenticate the user with remember me functionality
        if (Auth::attempt($credentials, $remember)) {
            // If successful, redirect to dashboard
            $request->session()->regenerate();
            
            \Log::info('Login successful', [
                'user_id' => Auth::id(),
                'remember_token_set' => !empty(Auth::user()->remember_token)
            ]);
            
            return redirect()->intended(route('dashboard'));
        }

        // If authentication fails, return with an error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Logout logic
    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect()->route('login');
    }
}