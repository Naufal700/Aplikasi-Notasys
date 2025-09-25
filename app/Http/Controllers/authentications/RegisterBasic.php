<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterBasic extends Controller
{
    // Menampilkan halaman register
    public function index()
    {
        return view('content.authentications.auth-register-basic');
    }

    // Menangani submit form register
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'terms' => 'accepted', // harus dicentang
        ]);

        // Membuat user baru
        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Auto-login
        Auth::login($user);

        // Redirect ke dashboard
        return redirect()->route('dashboard');
    }
}
