<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Support login by email OR username
        $loginField = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $attempt = Auth::attempt([
            $loginField => $credentials['login'],
            'password' => $credentials['password'],
            'is_active' => true,
        ], $request->boolean('remember'));

        if ($attempt) {
            $request->session()->regenerate();
            $user = Auth::user();

            $greeting = $user->isPengawas() 
                ? "Selamat datang kembali, Pengawas/Pakar {$user->name}!" 
                : "Selamat bertugas di lapangan, {$user->name}!";

            return redirect()->intended(route('dashboard'))->with('success', $greeting);
        }

        return back()->withErrors([
            'login' => 'Kredensial yang dimasukkan tidak cocok atau akun dinonaktifkan.',
        ])->onlyInput('login');
    }

    /**
     * Demo Quick Login Switcher (khusus environment local/testing)
     */
    public function quickLogin($role)
    {
        if (!app()->environment(['local', 'testing'])) {
            abort(403, 'Fitur demo quick-login dinonaktifkan pada mode produksi.');
        }

        $user = User::where('role', $role)->where('is_active', true)->first();
        if ($user) {
            Auth::login($user);
            request()->session()->regenerate();
            return redirect()->route('dashboard')->with('success', "Beralih peran sebagai: {$user->name} ({$user->role})");
        }
        return redirect()->route('login')->with('error', 'Pengguna demo tidak ditemukan.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Anda telah berhasil keluar dari sistem.');
    }
}

