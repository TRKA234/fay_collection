<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan form login unified (untuk customer dan admin)
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login - otomatis deteksi role
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba login tanpa role dulu untuk mendapatkan user
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } else {
                return redirect()->intended(route('home'));
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ])->onlyInput('email');
    }

    /**
     * Tampilkan form register (hanya untuk customer)
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi (hanya customer)
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'whatsapp' => ['required', 'string', 'max:20'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'whatsapp' => $data['whatsapp'],
            'password' => Hash::make($data['password']),
            'role' => 'customer', // Selalu customer untuk registrasi
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Registrasi berhasil! Selamat datang di Fay Collection.');
    }

    /**
     * Logout - redirect berdasarkan role sebelumnya
     */
    public function logout(Request $request)
    {
        $wasAdmin = Auth::check() && Auth::user()->role === 'admin';
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($wasAdmin) {
            return redirect()->route('login');
        }

        return redirect()->route('home');
    }
}

