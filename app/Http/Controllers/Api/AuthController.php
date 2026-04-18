<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Ubah email jadi huruf kecil semua
        $request->merge(['email' => strtolower($request->email)]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'masyarakat',
        ]);

        /** @var \Tymon\JWTAuth\JWTGuard $guard */
        $guard = auth('api');
        $token = $guard->login($user);

        return $this->respondWithToken($token);
    }

    public function login(Request $request)
    {
        // Ubah email jadi huruf kecil semua saat login
        $request->merge(['email' => strtolower($request->email)]);
        
        $credentials = $request->only('email', 'password');

        /** @var \Tymon\JWTAuth\JWTGuard $guard */
        $guard = auth('api');
        if (!$token = $guard->attempt($credentials)) {
            return response()->json(['error' => 'Kredensial tidak valid'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        /** @var \Tymon\JWTAuth\JWTGuard $guard */
        $guard = auth('api');
        $guard->logout();

        return response()->json(['message' => 'Berhasil logout']);
    }

    public function refresh()
    {
        /** @var \Tymon\JWTAuth\JWTGuard $guard */
        $guard = auth('api');
        return $this->respondWithToken($guard->refresh());
    }

    protected function respondWithToken($token)
    {
        /** @var \Tymon\JWTAuth\JWTGuard $guard */
        $guard = auth('api');
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $guard->factory()->getTTL() * 60,
            'user' => $guard->user()
        ]);
    }
}
