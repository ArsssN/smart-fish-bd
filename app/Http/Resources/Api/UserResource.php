<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *  schema="UserResource",
 *  type="object",
 *  @OA\Property(
 *      property="is_email_verified",
 *      type="boolean",
 *  ),
 *  @OA\Property(
 *      property="is_phone_verified",
 *      type="boolean",
 *  ),
 *  @OA\Property(
 *      property="photo",
 *      type="string",
 *  ),
 *  @OA\Property(
 *      property="n_id_photos",
 *      type="string",
 *  ),
 *  @OA\Property(
 *      property="account_holder_id",
 *      type="string",
 *  ),
 *  @OA\Property(
 *      property="first_name",
 *      type="string",
 *  ),
 *  @OA\Property(
 *      property="last_name",
 *      type="string",
 *  ),
 *  @OA\Property(
 *      property="farm_name",
 *      type="string",
 *  ),
 *  @OA\Property(
 *      property="email",
 *      type="string",
 *  ),
 *  @OA\Property(
 *      property="phone",
 *      type="string",
 *  ),
 *  @OA\Property(
 *      property="username",
 *      type="string",
 *  ),
 *  @OA\Property(
 *      property="is_admin",
 *      type="integer",
 *      format="int32",
 *  )
 * )
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = [
            'email' => $this->email,
            'username' => $this->username,
            'is_admin' => $this->is_admin,
        ];
        $userDetails = $this->userDetails;

        $optionals = [];
        if (!$this->email_verified_at) {
            $optionals['is_email_verified'] = false;
        }
        if (!$userDetails->phone_verified_at) {
            $optionals['is_phone_verified'] = false;
        }
        $optionals['photo'] = url($userDetails->photo);
        $optionals['n_id_photos'] = $userDetails->n_id_photos;
        $optionals['account_holder_id'] = $userDetails->account_holder_id;
        $optionals['first_name'] = $userDetails->first_name;
        $optionals['last_name'] = $userDetails->last_name;
        $optionals['farm_name'] = $userDetails->farm_name;
        $optionals['phone'] = $userDetails->phone;


        return [
            ...$optionals,
            ...$user,
        ];
    }
}
