<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\AuthHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'username' => 'nullable',
            'password' => 'required',
        ]);

        $usernameCredentials = request(['username', 'password']);

        if (!Auth::attempt($usernameCredentials, true)) {
            return response()->json([
                'message' => 'Invalid username or password',
            ], 401);
        }

        return response()->json(AuthHelper::getAccessToken($request->user()));
    }
}
