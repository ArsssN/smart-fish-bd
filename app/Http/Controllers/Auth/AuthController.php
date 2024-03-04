<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AuthHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'email' => 'nullable',
            'password' => 'required',
        ]);

        $usernameCredentials = request(['email', 'password']);

        if (!Auth::attempt($usernameCredentials, true)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        return response()->json(AuthHelper::getAccessToken($request->user()));
    }
}
