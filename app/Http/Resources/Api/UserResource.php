<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

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
        $user        = [
            'name'     => $this->name,
            'email'    => $this->email,
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
        $optionals['photo'] = $userDetails->photo;

        return [
            ...$optionals,
            ...$user,
        ];
    }
}
