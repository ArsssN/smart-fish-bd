<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class PriceResource extends JsonResource
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
            'title'         => $this->title,
            'slug'          => $this->slug,
            'price'         => $this->price,
            'currency'      => $this->currency,
            'card_bg_color' => $this->card_bg_color,
            'description'   => $this->description,
        ];
    }
}
