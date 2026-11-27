<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Fungsi Login
    public function login(Request $request)
    {
        // 1. Validasi input
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Cari user berdasarkan email
        $user = User::where('email', $data['email'])->first();

        // 3. Cek apakah user ada DAN password-nya cocok
        $ok = $user && Hash::check($data['password'], $user->password);

        if (! $ok) {
            // Jika gagal, kembalikan 401 Unauthorized
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        // 4. Buat token jika berhasil
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'token' => $token
        ], 200);
    }

    // Fungsi Logout (Mencabut token)
    public function logout(Request $request)
    {
        // Hapus token yang sedang digunakan
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil, token dicabut'
        ], 200);
    }
}
