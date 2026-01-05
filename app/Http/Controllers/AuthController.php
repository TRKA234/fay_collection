<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerificationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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

            // Untuk customer yang belum verified, redirect ke halaman verifikasi
            // OTP hanya dikirim saat registrasi, tidak setiap login
            if ($user->role === 'customer' && !$user->email_verified_at) {
                // Jika user belum punya kode verifikasi atau kode sudah expired, 
                // minta mereka untuk resend dari halaman verifikasi
                if (!$user->email_verification_code || 
                    !$user->email_verification_code_expires_at || 
                    now()->greaterThan($user->email_verification_code_expires_at)) {
                    return redirect()->route('verification.notice')
                        ->with('warning', 'Email Anda belum diverifikasi. Silakan klik tombol "Kirim Ulang Kode" untuk mendapatkan kode OTP baru.');
                }

                // Biarkan user login, tapi redirect ke halaman verifikasi
                return redirect()->route('verification.notice')
                    ->with('warning', 'Silakan verifikasi email Anda terlebih dahulu dengan kode OTP yang telah dikirim saat registrasi.');
            }

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

        // Generate OTP 6 digit
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = now()->addMinutes(15);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'whatsapp' => $data['whatsapp'],
            'password' => Hash::make($data['password']),
            'role' => 'customer', // Selalu customer untuk registrasi
            'email_verification_code' => $otpCode,
            'email_verification_code_expires_at' => $expiresAt,
        ]);

        // Kirim email OTP
        try {
            Mail::to($user->email)->send(new EmailVerificationMail($user, $otpCode));
        } catch (\Exception $e) {
            Log::error('Failed to send email verification: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengirim email verifikasi. Silakan coba lagi atau hubungi admin.');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('verification.notice')
            ->with('success', 'Registrasi berhasil! Silakan verifikasi email Anda dengan kode OTP yang telah dikirim.');
    }

    /**
     * Tampilkan halaman verifikasi email
     */
    public function showVerificationNotice()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Jika sudah verified, redirect ke home
        if ($user->email_verified_at) {
            return redirect()->route('home');
        }

        return view('auth.verify-email');
    }

    /**
     * Proses verifikasi OTP
     */
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek apakah sudah verified
        if ($user->email_verified_at) {
            return redirect()->route('home')->with('success', 'Email Anda sudah terverifikasi.');
        }

        // Cek apakah kode sesuai
        if ($user->email_verification_code !== $request->code) {
            return back()->withErrors(['code' => 'Kode verifikasi tidak sesuai.'])->withInput();
        }

        // Cek apakah kode masih berlaku
        if (now()->greaterThan($user->email_verification_code_expires_at)) {
            return back()->withErrors(['code' => 'Kode verifikasi sudah kadaluarsa. Silakan minta kode baru.'])->withInput();
        }

        // Verifikasi email
        $user->update([
            'email_verified_at' => now(),
            'email_verification_code' => null,
            'email_verification_code_expires_at' => null,
        ]);

        return redirect()->route('home')
            ->with('success', 'Email berhasil diverifikasi! Selamat datang di Fay Collection.');
    }

    /**
     * Kirim ulang kode OTP
     */
    public function resendVerificationCode()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Jika sudah verified, redirect ke home
        if ($user->email_verified_at) {
            return redirect()->route('home');
        }

        // Generate OTP baru
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = now()->addMinutes(15);

        $user->update([
            'email_verification_code' => $otpCode,
            'email_verification_code_expires_at' => $expiresAt,
        ]);

        // Kirim email OTP
        try {
            Mail::to($user->email)->send(new EmailVerificationMail($user, $otpCode));
        } catch (\Exception $e) {
            Log::error('Failed to resend email verification: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengirim email verifikasi. Silakan coba lagi.');
        }

        return back()->with('success', 'Kode verifikasi baru telah dikirim ke email Anda.');
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

