<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginInput = $request->input('username');
        $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $field => $loginInput,
            'password' => $request->input('password')
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Cek status akun — tolak user nonaktif
            if (Auth::user()->status_akun === 'nonaktif') {
                Auth::logout();
                return back()->withErrors([
                    'username' => 'Akun Anda telah dinonaktifkan. Hubungi administrator untuk informasi lebih lanjut.',
                ])->onlyInput('username');
            }

            return $this->redirectByRole(Auth::user());
        }

        return back()->withErrors([
            'username' => 'Kredensial login (username/email atau password) salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    protected function redirectByRole($user)
    {
        return match ($user->role) {
            'dapur' => redirect('/dapur'),
            'ahli_gizi' => redirect('/gizi'),
            'sekolah' => redirect('/sekolah'),
            'admin' => redirect('/admin'),
            'kurir' => redirect('/kurir'),
            default => redirect('/login'),
        };
    }
}
