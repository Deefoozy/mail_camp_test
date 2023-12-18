<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function apiLogin(LoginRequest $request) {
        $request->validated();

        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $token = $user->createToken('authToken');

            return response()
                ->json([
                    'token' => $token->plainTextToken,
                ], 200);
        } else {
            return response()
                ->json([
                    'message' => 'Invalid username or password',
                ], 401);
        }
    }
}
