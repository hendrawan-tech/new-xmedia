<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return ResponseFormatter::error(null, 'Email atau Kata Sandi anda salah!', 401);
            }

            $user = User::where('email', $request->email)->first();
            return ResponseFormatter::success([
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'user' => $user,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return ResponseFormatter::success([
                'user' => $user,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
