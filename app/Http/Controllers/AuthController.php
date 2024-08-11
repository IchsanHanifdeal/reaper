<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.pilih');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }
    public function auth(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|string',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email salah.',
            'password.required' => 'Password harus diisi.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $userRole = $user->role;

            $loginTime = Carbon::now();
            $request->session()->put([
                'login_time' => $loginTime->toDateTimeString(),
                'nama' => $user->nama,
                'id_user' => $user->id_user,
                'email' => $user->email,
                'role' => $user->role,
                'created_at' => $user->created_at
            ]);


            if ($userRole === 'admin' || $userRole === 'user') {
                return redirect()->intended('dashboard')->with('toast', [
                    'message' => 'Login berhasil!',
                    'type' => 'success'
                ]);
            }

            return back()->with('toast', [
                'message' => 'Login gagal, role pengguna tidak dikenali.',
                'type' => 'error'
            ]);
        }

        return back()->withErrors([
            'loginError' => 'Email atau password salah.',
        ])->with('toast', [
            'message' => 'Email atau password salah.',
            'type' => 'error'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index')->with('toast', [
            'message' => 'Logout berhasil!',
            'type' => 'success'
        ]);;
    }
}
