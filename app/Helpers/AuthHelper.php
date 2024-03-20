<?php

namespace App\Helpers;

use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @OA\Schema(
 *  schema="AccessToken",
 *  type="object",
 *  @OA\Property(
 *      property="access_token",
 *      type="string",
 *  ),
 *  @OA\Property(
 *      property="token_type",
 *      type="string",
 *  ),
 *  @OA\Property(
 *      property="expires_at",
 *      type="string",
 *  ),
 *  @OA\Property(
 *      property="user",
 *      type="object",
 *      ref="#/components/schemas/UserResource"
 *  ),
 *  @OA\Property(
 *      property="isAuthenticated",
 *      type="boolean",
 *  )
 * )
 */
class AuthHelper
{
    /**
     * @param User|Model|Builder $user
     * @return array
     */
    public static function getAccessToken(User|Model|Builder $user): array
    {
        $tokenResult                          = $user->createToken('Personal Access Token');
        $tokenResult->accessToken->expires_at = Carbon::now()->addMinutes(
            config('sanctum.expiration') ?? 60 * 24 * 365
        );
        $tokenResult->accessToken->save();

        $token = $tokenResult->plainTextToken;

        return [
            'access_token'    => $token,
            'token_type'      => 'Bearer',
            'expires_at'      => Carbon::parse(
                $tokenResult->accessToken->expires_at
            )->toDateTimeString(),
            'user'            => UserResource::make($user),
            'isAuthenticated' => true,
        ];
    }
}
