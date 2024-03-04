<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class InviteeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "name"    => $this->name,
            "slug"    => $this->slug,
            "email"   => $this->email,
            "phone"   => $this->phone,
            "address" => $this->address,
            "card"    => $this->invitation->card,
            "code"    => $this->invitation->code,
        ];
    }
}
