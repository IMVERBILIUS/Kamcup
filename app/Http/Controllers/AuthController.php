<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Menangani proses login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // Cari user berdasarkan email dan password md5
        $user = User::where('email', $request->email)
                    ->where('password', md5($request->password))
                    ->first();

        if ($user) {
            Auth::login($user); // Login secara manual
            $request->session()->regenerate();

            return redirect()->route('redirect.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    // Menampilkan halaman register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Menangani proses registrasi
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => md5($request->password), // menggunakan md5
            'role'     => 'reader', // default role
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // Redirect berdasarkan role
    public function redirectDashboard()
    {
        $role = Auth::user()->role;

        return match ($role) {
            'admin'  => redirect('/admin/dashboard'),
            'author' => redirect('/author/dashboard'),
            'reader' => redirect('/'),
            default  => abort(403),
        };
    }
}
