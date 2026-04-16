<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang, Admin!');
        } elseif ($user->role === 'user') {
            return redirect()->route('user.dashboard')
                ->with('success', 'Selamat datang!');
        }

        Auth::logout();
    }

    // Error message yang lebih baik
    return back()
        ->with('error', 'Email atau password salah. Silakan coba lagi.')
        ->withInput();
}

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')
            ->with('success', 'Anda telah logout.');
    }
}
