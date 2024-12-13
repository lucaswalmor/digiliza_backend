<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        Log::info('Login attempt: ', $credentials);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('digilize')->plainTextToken;

            return response()->json([
                'usuario'  => new UserResource($user),
                'token' => $token
            ], 200);
        }

        return response()->json(['message' => 'Credenciais inválidas'], 401);
    }
}
