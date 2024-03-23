<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\AuthHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use OpenApi\Annotations as OA;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     operationId="login",
     *     summary="Login",
     *     tags={"Auth"},
     *     @OA\Parameter(
     *         name="username",
     *         in="query",
     *         description="Username",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="Password",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/AccessToken")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Invalid username or password"
     *     ),
     *  )
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'username' => 'nullable',
            'password' => 'required',
        ]);

        $user = User::query()->where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid username or password',
            ], 401);
        }

        return response()->json(AuthHelper::getAccessToken($user));
    }
}
